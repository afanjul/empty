<?php

namespace common\services;

use common\dto\InvoiceDTO;
use common\interfaces\InvoiceServiceInterface;
use common\interfaces\VerifactuServiceInterface;
use common\models\Account;
use common\models\Contact;
use common\models\Document;
use common\models\DocumentItem;
use common\models\DocumentSeries;
use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

/**
 * InvoiceService - Servicio de negocio para facturas
 *
 * Implementa la lógica completa de gestión de facturas incluyendo:
 * - Creación y actualización de facturas
 * - Cálculo de totales
 * - Generación de números de factura
 * - Integración con Verifactu
 * - Generación de PDFs
 * - Envío por email
 */
class InvoiceService implements InvoiceServiceInterface
{
    private VerifactuServiceInterface $verifactuService;

    public function __construct(VerifactuServiceInterface $verifactuService = null)
    {
        $this->verifactuService = $verifactuService ?? Yii::$container->get(VerifactuServiceInterface::class);
    }

    /**
     * {@inheritdoc}
     */
    public function createInvoice(array $data): InvoiceDTO
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // Obtener tenant actual
            $tenantId = Yii::$app->tenantManager->getTenantId();

            if ($tenantId === null) {
                throw new \RuntimeException('No hay tenant activo');
            }

            // Obtener tenant para datos del emisor
            $tenant = Account::findOne($tenantId);

            // Crear documento
            $document = new Document();
            $document->tenant_id = $tenantId;
            $document->document_type_id = $data['document_type_id'] ?? Document::TYPE_INVOICE;
            $document->status = $data['status'] ?? Document::STATUS_DRAFT;
            $document->issue_date = $data['issue_date'] ?? date('Y-m-d');
            $document->due_date = $data['due_date'] ?? null;
            $document->description = $data['description'] ?? null;
            $document->notes = $data['notes'] ?? null;

            // Datos del emisor (desde el tenant)
            $document->issuer_name = $tenant->fiscal_name;
            $document->issuer_tax_id = $tenant->nif_id_number;

            // Datos del destinatario
            if (isset($data['recipient_id'])) {
                $recipient = Contact::findOne($data['recipient_id']);
                if ($recipient) {
                    $document->recipient_id = $recipient->contact_id;
                    $document->recipient_name = $recipient->fiscal_name;
                    $document->recipient_email = $recipient->email;
                    $document->recipient_tax_id = $recipient->nif_id_number;
                }
            }

            // Moneda
            $document->base_currency_id = $tenant->base_currency_id;
            $document->document_currency_id = $data['currency_id'] ?? $tenant->base_currency_id;
            $document->exchange_rate = $data['exchange_rate'] ?? 1.0;

            if (!$document->save()) {
                throw new Exception('Error al crear documento: ' . json_encode($document->errors));
            }

            // Crear líneas de documento
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $index => $itemData) {
                    $item = new DocumentItem();
                    $item->tenant_id = $tenantId;
                    $item->document_id = $document->document_id;
                    $item->position = $index + 1;
                    $item->item_type = $itemData['item_type'] ?? DocumentItem::TYPE_PRODUCT;
                    $item->name = $itemData['name'];
                    $item->description = $itemData['description'] ?? null;
                    $item->sku = $itemData['sku'] ?? null;
                    $item->quantity = $itemData['quantity'] ?? 1;
                    $item->unit_price = $itemData['unit_price'] ?? 0;

                    // Descuento
                    if (isset($itemData['discount_type'])) {
                        $item->discount_type = $itemData['discount_type'];
                        $item->discount_value = $itemData['discount_value'] ?? 0;
                    }

                    // Calcular totales (con tasa de impuesto)
                    $taxRate = $itemData['tax_rate'] ?? 21.0;
                    $item->calculateTotals($taxRate);

                    if (!$item->save()) {
                        throw new Exception('Error al crear línea de documento: ' . json_encode($item->errors));
                    }
                }
            }

            // Recalcular totales del documento
            $this->recalculateDocumentTotals($document);

            $transaction->commit();

            Yii::info("Factura creada: {$document->document_id}", __METHOD__);

            return InvoiceDTO::fromModel($document);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error creando factura: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateInvoice(int $documentId, array $data): InvoiceDTO
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $document = Document::findOne($documentId);

            if ($document === null) {
                throw new NotFoundHttpException('Factura no encontrada');
            }

            // Solo se puede editar si está en borrador
            if (!$document->canBeEdited()) {
                throw new \RuntimeException('La factura no puede ser editada en su estado actual');
            }

            // Actualizar campos permitidos
            if (isset($data['issue_date'])) {
                $document->issue_date = $data['issue_date'];
            }
            if (isset($data['due_date'])) {
                $document->due_date = $data['due_date'];
            }
            if (isset($data['description'])) {
                $document->description = $data['description'];
            }
            if (isset($data['notes'])) {
                $document->notes = $data['notes'];
            }

            // Actualizar destinatario si cambió
            if (isset($data['recipient_id']) && $data['recipient_id'] != $document->recipient_id) {
                $recipient = Contact::findOne($data['recipient_id']);
                if ($recipient) {
                    $document->recipient_id = $recipient->contact_id;
                    $document->recipient_name = $recipient->fiscal_name;
                    $document->recipient_email = $recipient->email;
                    $document->recipient_tax_id = $recipient->nif_id_number;
                }
            }

            if (!$document->save()) {
                throw new Exception('Error al actualizar documento: ' . json_encode($document->errors));
            }

            // Actualizar líneas si se proporcionaron
            if (isset($data['items'])) {
                // Eliminar líneas existentes
                DocumentItem::deleteAll(['document_id' => $document->document_id]);

                // Crear nuevas líneas
                foreach ($data['items'] as $index => $itemData) {
                    $item = new DocumentItem();
                    $item->tenant_id = $document->tenant_id;
                    $item->document_id = $document->document_id;
                    $item->position = $index + 1;
                    $item->item_type = $itemData['item_type'] ?? DocumentItem::TYPE_PRODUCT;
                    $item->name = $itemData['name'];
                    $item->description = $itemData['description'] ?? null;
                    $item->quantity = $itemData['quantity'] ?? 1;
                    $item->unit_price = $itemData['unit_price'] ?? 0;

                    $taxRate = $itemData['tax_rate'] ?? 21.0;
                    $item->calculateTotals($taxRate);

                    if (!$item->save()) {
                        throw new Exception('Error al crear línea: ' . json_encode($item->errors));
                    }
                }

                // Recalcular totales
                $this->recalculateDocumentTotals($document);
            }

            $transaction->commit();

            Yii::info("Factura actualizada: {$document->document_id}", __METHOD__);

            return InvoiceDTO::fromModel($document);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error actualizando factura: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getInvoice(int $documentId): ?InvoiceDTO
    {
        $document = Document::find()
            ->where(['document_id' => $documentId])
            ->with(['items', 'verifactuRecord'])
            ->one();

        if ($document === null) {
            return null;
        }

        return InvoiceDTO::fromModel($document);
    }

    /**
     * {@inheritdoc}
     */
    public function listInvoices(array $filters = [], int $page = 1, int $pageSize = 20): array
    {
        $query = Document::find()
            ->with(['items', 'verifactuRecord'])
            ->orderBy(['document_id' => SORT_DESC]);

        // Aplicar filtros
        if (isset($filters['status'])) {
            $query->andWhere(['status' => $filters['status']]);
        }

        if (isset($filters['document_type_id'])) {
            $query->andWhere(['document_type_id' => $filters['document_type_id']]);
        }

        if (isset($filters['recipient_id'])) {
            $query->andWhere(['recipient_id' => $filters['recipient_id']]);
        }

        if (isset($filters['date_from'])) {
            $query->andWhere(['>=', 'issue_date', $filters['date_from']]);
        }

        if (isset($filters['date_to'])) {
            $query->andWhere(['<=', 'issue_date', $filters['date_to']]);
        }

        if (isset($filters['search'])) {
            $query->andWhere([
                'or',
                ['like', 'document_number', $filters['search']],
                ['like', 'recipient_name', $filters['search']],
                ['like', 'description', $filters['search']],
            ]);
        }

        // Contar total
        $total = $query->count();

        // Paginar
        $offset = ($page - 1) * $pageSize;
        $documents = $query->offset($offset)->limit($pageSize)->all();

        // Convertir a DTOs
        $items = array_map(fn($doc) => InvoiceDTO::fromModel($doc), $documents);

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'page_size' => $pageSize,
            'total_pages' => ceil($total / $pageSize),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function deleteInvoice(int $documentId): bool
    {
        $document = Document::findOne($documentId);

        if ($document === null) {
            throw new NotFoundHttpException('Factura no encontrada');
        }

        // Solo se puede eliminar si está en borrador
        if ($document->status !== Document::STATUS_DRAFT) {
            throw new \RuntimeException('Solo se pueden eliminar facturas en borrador');
        }

        // Soft delete
        return $document->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function approveInvoice(int $documentId): InvoiceDTO
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $document = Document::findOne($documentId);

            if ($document === null) {
                throw new NotFoundHttpException('Factura no encontrada');
            }

            if (!$document->canBeApproved()) {
                throw new \RuntimeException('La factura no puede ser aprobada (debe tener líneas)');
            }

            // Generar número de factura si no tiene
            if (empty($document->document_number)) {
                $this->assignDocumentNumber($document);
            }

            // Cambiar estado a aprobado
            $document->status = Document::STATUS_APPROVED;

            if (!$document->save()) {
                throw new Exception('Error al aprobar factura: ' . json_encode($document->errors));
            }

            // Generar registro Verifactu
            $this->verifactuService->generateRecord($document, [
                'sign' => true, // Firmar automáticamente
            ]);

            $transaction->commit();

            Yii::info("Factura aprobada: {$document->document_id}", __METHOD__);

            // Recargar para obtener el registro Verifactu
            $document->refresh();
            return InvoiceDTO::fromModel($document);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error aprobando factura: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generatePDF(int $documentId): string
    {
        $document = Document::findOne($documentId);

        if ($document === null) {
            throw new NotFoundHttpException('Factura no encontrada');
        }

        // TODO: Implementar generación de PDF con TCPDF
        // Por ahora retornar una ruta placeholder
        return '/path/to/invoice_' . $documentId . '.pdf';
    }

    /**
     * {@inheritdoc}
     */
    public function sendByEmail(int $documentId, ?string $email = null): bool
    {
        $document = Document::findOne($documentId);

        if ($document === null) {
            throw new NotFoundHttpException('Factura no encontrada');
        }

        $recipientEmail = $email ?? $document->recipient_email;

        if (empty($recipientEmail)) {
            throw new \RuntimeException('No hay email de destinatario');
        }

        // TODO: Implementar envío de email con Yii2 Mailer
        Yii::info("Enviando factura {$documentId} a {$recipientEmail}", __METHOD__);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateTotals(array $items, array $taxes = []): array
    {
        $subtotal = 0;
        $totalTax = 0;

        foreach ($items as $item) {
            $lineSubtotal = $item['quantity'] * $item['unit_price'];

            // Aplicar descuento
            if (isset($item['discount'])) {
                $lineSubtotal -= $item['discount'];
            }

            $subtotal += $lineSubtotal;

            // Calcular impuesto
            $taxRate = $item['tax_rate'] ?? 21.0;
            $lineTax = $lineSubtotal * ($taxRate / 100);
            $totalTax += $lineTax;
        }

        $total = $subtotal + $totalTax;

        return [
            'subtotal' => round($subtotal, 2),
            'tax' => round($totalTax, 2),
            'total' => round($total, 2),
        ];
    }

    /**
     * Recalcula los totales de un documento basándose en sus líneas
     *
     * @param Document $document
     */
    protected function recalculateDocumentTotals(Document $document): void
    {
        $items = DocumentItem::findAll(['document_id' => $document->document_id]);

        $subtotal = 0;
        $totalTax = 0;

        foreach ($items as $item) {
            $subtotal += $item->line_total_excl_tax;
            $totalTax += $item->tax_amount;
        }

        $document->subtotal_amount = $subtotal;
        $document->tax_amount = $totalTax;
        $document->total_amount = $subtotal + $totalTax;
        $document->save(false);
    }

    /**
     * Asigna un número de documento usando la serie por defecto
     *
     * @param Document $document
     */
    protected function assignDocumentNumber(Document $document): void
    {
        // Obtener serie por defecto para este tipo de documento
        $series = DocumentSeries::find()
            ->where([
                'tenant_id' => $document->tenant_id,
                'document_type_id' => $document->document_type_id,
                'is_default' => true,
            ])
            ->one();

        if ($series === null) {
            throw new \RuntimeException('No hay serie de numeración configurada para este tipo de documento');
        }

        // Generar número
        $document->document_series_id = $series->document_series_id;
        $document->document_number = $series->getNextNumber();
        $document->sequence_number = $series->last_sequence;

        // Guardar serie con el nuevo last_sequence
        $series->save(false);
    }
}
