<?php

namespace common\services;

use common\dto\ContactDTO;
use common\interfaces\ContactServiceInterface;
use common\models\Contact;
use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

/**
 * ContactService - Servicio de negocio para contactos (clientes/proveedores)
 */
class ContactService implements ContactServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function createContact(array $data): ContactDTO
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $tenantId = Yii::$app->tenantManager->getTenantId();

            $contact = new Contact();
            $contact->tenant_id = $tenantId;
            $contact->type = $data['type'];
            $contact->role = $data['role'] ?? null;
            $contact->fiscal_name = $data['fiscal_name'];
            $contact->trade_name = $data['trade_name'] ?? null;
            $contact->nif_id_number = $data['nif_id_number'] ?? null;
            $contact->vat_id_number = $data['vat_id_number'] ?? null;
            $contact->code = $data['code'] ?? null;
            $contact->email = $data['email'] ?? null;
            $contact->mobile = $data['mobile'] ?? null;
            $contact->phone = $data['phone'] ?? null;
            $contact->website = $data['website'] ?? null;
            $contact->language_id = $data['language_id'] ?? null;
            $contact->currency_id = $data['currency_id'] ?? null;
            $contact->default_payment_method_id = $data['default_payment_method_id'] ?? null;
            $contact->default_due_days = $data['default_due_days'] ?? null;

            if (!$contact->save()) {
                throw new Exception('Error al crear contacto: ' . json_encode($contact->errors));
            }

            $transaction->commit();

            Yii::info("Contacto creado: {$contact->contact_id}", __METHOD__);

            return ContactDTO::fromModel($contact);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error creando contacto: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateContact(int $contactId, array $data): ContactDTO
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $contact = Contact::findOne($contactId);

            if ($contact === null) {
                throw new NotFoundHttpException('Contacto no encontrado');
            }

            // Actualizar campos
            if (isset($data['type'])) $contact->type = $data['type'];
            if (isset($data['role'])) $contact->role = $data['role'];
            if (isset($data['fiscal_name'])) $contact->fiscal_name = $data['fiscal_name'];
            if (isset($data['trade_name'])) $contact->trade_name = $data['trade_name'];
            if (isset($data['nif_id_number'])) $contact->nif_id_number = $data['nif_id_number'];
            if (isset($data['vat_id_number'])) $contact->vat_id_number = $data['vat_id_number'];
            if (isset($data['email'])) $contact->email = $data['email'];
            if (isset($data['mobile'])) $contact->mobile = $data['mobile'];
            if (isset($data['phone'])) $contact->phone = $data['phone'];
            if (isset($data['website'])) $contact->website = $data['website'];

            if (!$contact->save()) {
                throw new Exception('Error al actualizar contacto: ' . json_encode($contact->errors));
            }

            $transaction->commit();

            Yii::info("Contacto actualizado: {$contact->contact_id}", __METHOD__);

            return ContactDTO::fromModel($contact);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error actualizando contacto: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getContact(int $contactId): ?ContactDTO
    {
        $contact = Contact::findOne($contactId);

        if ($contact === null) {
            return null;
        }

        return ContactDTO::fromModel($contact);
    }

    /**
     * {@inheritdoc}
     */
    public function listContacts(array $filters = [], int $page = 1, int $pageSize = 20): array
    {
        $query = Contact::find()->orderBy(['contact_id' => SORT_DESC]);

        // Aplicar filtros
        if (isset($filters['type'])) {
            $query->andWhere(['type' => $filters['type']]);
        }

        if (isset($filters['role'])) {
            $query->andWhere(['role' => $filters['role']]);
        }

        if (isset($filters['search'])) {
            $query->andWhere([
                'or',
                ['like', 'fiscal_name', $filters['search']],
                ['like', 'trade_name', $filters['search']],
                ['like', 'nif_id_number', $filters['search']],
                ['like', 'email', $filters['search']],
            ]);
        }

        // Contar total
        $total = $query->count();

        // Paginar
        $offset = ($page - 1) * $pageSize;
        $contacts = $query->offset($offset)->limit($pageSize)->all();

        // Convertir a DTOs
        $items = array_map(fn($contact) => ContactDTO::fromModel($contact), $contacts);

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
    public function deleteContact(int $contactId): bool
    {
        $contact = Contact::findOne($contactId);

        if ($contact === null) {
            throw new NotFoundHttpException('Contacto no encontrado');
        }

        return $contact->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function searchContacts(string $query, int $limit = 10): array
    {
        $contacts = Contact::find()
            ->where([
                'or',
                ['like', 'fiscal_name', $query],
                ['like', 'trade_name', $query],
                ['like', 'nif_id_number', $query],
            ])
            ->limit($limit)
            ->all();

        return array_map(fn($contact) => ContactDTO::fromModel($contact), $contacts);
    }

    /**
     * {@inheritdoc}
     */
    public function validateNIF(string $nif): bool
    {
        $nif = strtoupper(trim(str_replace([' ', '-', '.'], '', $nif)));

        // Validación básica de formato
        if (!preg_match('/^[XYZ0-9][0-9]{7}[A-Z0-9]$/', $nif)) {
            return false;
        }

        // TODO: Implementar validación completa del dígito de control
        return true;
    }
}
