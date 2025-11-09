<?php

namespace common\services;

use common\components\VerifactuComponent;
use common\interfaces\VerifactuServiceInterface;
use common\models\Document;
use common\models\VerifactuRecord;
use Yii;
use yii\db\Exception;

/**
 * VerifactuService - Servicio de negocio para Verifactu
 *
 * Implementa la lógica de negocio para:
 * - Generación de registros de facturación con hash encadenado
 * - Firma electrónica de registros
 * - Generación de códigos QR
 * - Validación de cadena de registros
 * - Registros de anulación
 */
class VerifactuService implements VerifactuServiceInterface
{
    private VerifactuComponent $verifactu;

    public function __construct(VerifactuComponent $verifactu = null)
    {
        $this->verifactu = $verifactu ?? Yii::$app->verifactu;
    }

    /**
     * {@inheritdoc}
     */
    public function generateRecord(Document $document, array $options = []): array
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // Validar que el documento esté aprobado
            if (!$document->isApproved()) {
                throw new \RuntimeException('El documento debe estar aprobado para generar registro Verifactu');
            }

            // Verificar si ya tiene un registro Verifactu
            if ($document->verifactuRecord !== null) {
                throw new \RuntimeException('El documento ya tiene un registro Verifactu asociado');
            }

            // Obtener el registro anterior
            $previousRecord = $this->getPreviousRecord($document->tenant_id);

            // Crear nuevo registro Verifactu
            $record = new VerifactuRecord();
            $record->tenant_id = $document->tenant_id;
            $record->document_id = $document->document_id;
            $record->version = $options['version'] ?? '1.0';
            $record->record_type = $options['record_type'] ?? VerifactuRecord::TYPE_ALTA;

            // Datos de la factura
            $record->issuer_nif = $document->issuer_tax_id;
            $record->invoice_number = $document->document_number;
            $record->issue_date = $document->issue_date;
            $record->operation_description = $document->description;

            // Tipo de factura (por defecto F1 = factura completa)
            $record->invoice_type = $this->determineInvoiceType($document, $options);

            // Importes
            $record->total_base = $document->subtotal_amount ?? 0;
            $record->total_tax = $document->tax_amount ?? 0;
            $record->total_amount = $document->total_amount ?? 0;

            // Encadenamiento
            if ($previousRecord === null) {
                // Primer registro de la cadena
                $record->is_first_record = true;
                $record->previous_record_id = null;
                $record->previous_hash = null;
            } else {
                // Registro subsiguiente - encadenar con el anterior
                $record->is_first_record = false;
                $record->previous_record_id = $previousRecord['record_id'];
                $record->previous_issuer_nif = $previousRecord['issuer_nif'];
                $record->previous_invoice_number = $previousRecord['invoice_number'];
                $record->previous_issue_date = $previousRecord['issue_date'];
                $record->previous_hash = $previousRecord['hash'];
            }

            // Generar hash
            $hashData = [
                'issuer_nif' => $record->issuer_nif,
                'invoice_number' => $record->invoice_number,
                'issue_date' => $record->issue_date,
                'invoice_type' => $record->invoice_type,
                'total_tax' => $record->total_tax,
                'total_amount' => $record->total_amount,
            ];

            $record->hash = $this->verifactu->generateHash($hashData, $record->previous_hash);
            $record->hash_algorithm = '01'; // SHA-256

            // Timestamp de generación
            $record->generated_at = date('Y-m-d H:i:s');

            // Guardar el registro
            if (!$record->save()) {
                throw new Exception('Error al guardar el registro Verifactu: ' . json_encode($record->errors));
            }

            // Generar código QR
            $this->generateQR($record->verifactu_record_id);

            // Firmar si hay certificado disponible (opcional en remisión voluntaria)
            if ($options['sign'] ?? false) {
                $this->signRecord($record->verifactu_record_id);
            }

            $transaction->commit();

            Yii::info("Registro Verifactu generado: {$record->verifactu_record_id} para documento {$document->document_id}", __METHOD__);

            return [
                'record_id' => $record->verifactu_record_id,
                'hash' => $record->hash,
                'qr_code' => $record->qr_code,
                'signed' => $record->isSigned(),
            ];
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error generando registro Verifactu: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function signRecord(int $verifactuRecordId): bool
    {
        /** @var VerifactuRecord $record */
        $record = VerifactuRecord::findOne($verifactuRecordId);

        if ($record === null) {
            throw new \RuntimeException('Registro Verifactu no encontrado');
        }

        if ($record->isSigned()) {
            Yii::warning("El registro {$verifactuRecordId} ya está firmado", __METHOD__);
            return true;
        }

        // Obtener certificado del tenant
        $certificate = $this->getTenantCertificate($record->tenant_id);

        if ($certificate === null) {
            throw new \RuntimeException('No hay certificado digital configurado para este tenant');
        }

        // Construir contenido XML para firmar (simplificado)
        $xmlContent = $this->buildXMLForSigning($record);

        // Firmar
        $signature = $this->verifactu->signRecord(
            $xmlContent,
            $certificate['certificate_pem'],
            $certificate['private_key_pem'],
            $certificate['passphrase']
        );

        // Guardar firma
        $record->signature = $signature;
        $record->signed_at = date('Y-m-d H:i:s');

        if (!$record->save(false)) {
            throw new Exception('Error al guardar la firma');
        }

        Yii::info("Registro Verifactu {$verifactuRecordId} firmado correctamente", __METHOD__);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function generateQR(int $verifactuRecordId): string
    {
        /** @var VerifactuRecord $record */
        $record = VerifactuRecord::findOne($verifactuRecordId);

        if ($record === null) {
            throw new \RuntimeException('Registro Verifactu no encontrado');
        }

        // Generar contenido del QR
        $qrData = [
            'issuer_nif' => $record->issuer_nif,
            'invoice_number' => $record->invoice_number,
            'issue_date' => $record->issue_date,
            'total_amount' => $record->total_amount,
        ];

        $qrContent = $this->verifactu->generateQRCode($qrData);

        // Guardar la URL del QR
        $record->qr_code = $qrContent;

        // Generar imagen del QR y guardarla
        $qrImagePath = $this->saveQRImage($record, $qrContent);
        $record->qr_image_path = $qrImagePath;

        if (!$record->save(false)) {
            throw new Exception('Error al guardar el código QR');
        }

        Yii::info("Código QR generado para registro {$verifactuRecordId}", __METHOD__);

        return $qrContent;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousRecord(int $tenantId): ?array
    {
        $record = VerifactuRecord::find()
            ->where(['tenant_id' => $tenantId])
            ->orderBy(['verifactu_record_id' => SORT_DESC])
            ->one();

        if ($record === null) {
            return null;
        }

        return [
            'record_id' => $record->verifactu_record_id,
            'issuer_nif' => $record->issuer_nif,
            'invoice_number' => $record->invoice_number,
            'issue_date' => $record->issue_date,
            'hash' => $record->hash,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function validateChain(int $tenantId, ?int $limit = null): array
    {
        $query = VerifactuRecord::find()
            ->where(['tenant_id' => $tenantId])
            ->orderBy(['verifactu_record_id' => SORT_ASC]);

        if ($limit !== null) {
            $query->limit($limit);
        }

        $records = $query->all();
        $errors = [];
        $validated = 0;

        foreach ($records as $index => $record) {
            // Validar hash
            $expectedHash = $this->verifactu->generateHash([
                'issuer_nif' => $record->issuer_nif,
                'invoice_number' => $record->invoice_number,
                'issue_date' => $record->issue_date,
                'invoice_type' => $record->invoice_type,
                'total_tax' => $record->total_tax,
                'total_amount' => $record->total_amount,
            ], $record->previous_hash);

            if ($expectedHash !== $record->hash) {
                $errors[] = [
                    'record_id' => $record->verifactu_record_id,
                    'error' => 'Hash no coincide',
                    'expected' => $expectedHash,
                    'actual' => $record->hash,
                ];
            }

            // Validar encadenamiento
            if ($index === 0) {
                if (!$record->is_first_record) {
                    $errors[] = [
                        'record_id' => $record->verifactu_record_id,
                        'error' => 'El primer registro no está marcado como is_first_record',
                    ];
                }
            } else {
                $previousRecord = $records[$index - 1];
                if ($record->previous_hash !== $previousRecord->hash) {
                    $errors[] = [
                        'record_id' => $record->verifactu_record_id,
                        'error' => 'El hash anterior no coincide',
                        'expected' => $previousRecord->hash,
                        'actual' => $record->previous_hash,
                    ];
                }
            }

            $validated++;
        }

        return [
            'validated' => $validated,
            'errors' => $errors,
            'is_valid' => count($errors) === 0,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateCancellationRecord(Document $document, array $options = []): array
    {
        // Similar a generateRecord pero con record_type = 'anulacion'
        $options['record_type'] = VerifactuRecord::TYPE_ANULACION;
        return $this->generateRecord($document, $options);
    }

    /**
     * Determina el tipo de factura Verifactu basándose en el documento
     */
    protected function determineInvoiceType(Document $document, array $options): string
    {
        if (isset($options['invoice_type'])) {
            return $options['invoice_type'];
        }

        // Lógica por defecto
        if ($document->document_type_id === Document::TYPE_INVOICE) {
            return VerifactuRecord::INVOICE_TYPE_F1; // Factura completa
        } elseif ($document->document_type_id === Document::TYPE_SALES_RECEIPT) {
            return VerifactuRecord::INVOICE_TYPE_F2; // Factura simplificada
        } elseif ($document->document_type_id === Document::TYPE_CREDIT_NOTE) {
            return VerifactuRecord::INVOICE_TYPE_R1; // Rectificativa
        }

        return VerifactuRecord::INVOICE_TYPE_F1;
    }

    /**
     * Obtiene el certificado digital del tenant
     */
    protected function getTenantCertificate(int $tenantId): ?array
    {
        // En producción, esto debe obtener el certificado de la tabla verifactu_certificate
        // y desencriptarlo

        // Implementación simplificada
        return [
            'certificate_pem' => '-----BEGIN CERTIFICATE-----...-----END CERTIFICATE-----',
            'private_key_pem' => '-----BEGIN PRIVATE KEY-----...-----END PRIVATE KEY-----',
            'passphrase' => null,
        ];
    }

    /**
     * Construye el XML para firmar
     */
    protected function buildXMLForSigning(VerifactuRecord $record): string
    {
        // Construir XML según especificación Verifactu
        // Esta es una versión simplificada
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<RegistroFacturacion>\n";
        $xml .= "  <IDFactura>\n";
        $xml .= "    <IDEmisorFactura>{$record->issuer_nif}</IDEmisorFactura>\n";
        $xml .= "    <NumSerieFactura>{$record->invoice_number}</NumSerieFactura>\n";
        $xml .= "    <FechaExpedicionFactura>" . date('d-m-Y', strtotime($record->issue_date)) . "</FechaExpedicionFactura>\n";
        $xml .= "  </IDFactura>\n";
        $xml .= "  <Huella>{$record->hash}</Huella>\n";
        $xml .= "</RegistroFacturacion>";

        return $xml;
    }

    /**
     * Guarda la imagen del QR en el filesystem
     */
    protected function saveQRImage(VerifactuRecord $record, string $qrContent): string
    {
        $uploadPath = Yii::getAlias('@webroot/uploads/qr');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $filename = "qr_{$record->tenant_id}_{$record->verifactu_record_id}.png";
        $fullPath = $uploadPath . '/' . $filename;

        $this->verifactu->generateQRImage($qrContent, $fullPath);

        return '/uploads/qr/' . $filename;
    }
}
