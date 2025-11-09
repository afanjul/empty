<?php

namespace common\services;

use common\dto\TenantDTO;
use common\interfaces\TenantServiceInterface;
use common\models\Account;
use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

/**
 * TenantService - Servicio de negocio para gestión de tenants
 */
class TenantService implements TenantServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function createTenant(array $data): TenantDTO
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $tenant = new Account();
            $tenant->fiscal_name = $data['fiscal_name'];
            $tenant->trade_name = $data['trade_name'] ?? null;
            $tenant->subdomain = $data['subdomain'];
            $tenant->status = $data['status'] ?? Account::STATUS_TRIAL;
            $tenant->base_currency_id = $data['base_currency_id'];
            $tenant->default_language_id = $data['default_language_id'] ?? null;
            $tenant->country_id = $data['country_id'] ?? null;
            $tenant->timezone = $data['timezone'] ?? 'UTC';
            $tenant->nif_id_number = $data['nif_id_number'] ?? null;
            $tenant->vat_id_number = $data['vat_id_number'] ?? null;
            $tenant->account_settings = $data['account_settings'] ?? [];

            if (!$tenant->save()) {
                throw new Exception('Error al crear tenant: ' . json_encode($tenant->errors));
            }

            $transaction->commit();

            Yii::info("Tenant creado: {$tenant->tenant_id}", __METHOD__);

            return TenantDTO::fromModel($tenant);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error creando tenant: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateTenant(int $tenantId, array $data): TenantDTO
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $tenant = Account::findOne($tenantId);

            if ($tenant === null) {
                throw new NotFoundHttpException('Tenant no encontrado');
            }

            // Actualizar campos permitidos
            if (isset($data['fiscal_name'])) $tenant->fiscal_name = $data['fiscal_name'];
            if (isset($data['trade_name'])) $tenant->trade_name = $data['trade_name'];
            if (isset($data['nif_id_number'])) $tenant->nif_id_number = $data['nif_id_number'];
            if (isset($data['vat_id_number'])) $tenant->vat_id_number = $data['vat_id_number'];
            if (isset($data['timezone'])) $tenant->timezone = $data['timezone'];

            if (!$tenant->save()) {
                throw new Exception('Error al actualizar tenant: ' . json_encode($tenant->errors));
            }

            $transaction->commit();

            // Limpiar caché del tenant
            Yii::$app->tenantManager->clearCache();

            Yii::info("Tenant actualizado: {$tenant->tenant_id}", __METHOD__);

            return TenantDTO::fromModel($tenant);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error actualizando tenant: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTenant(int $tenantId): ?TenantDTO
    {
        $tenant = Account::findOne($tenantId);

        if ($tenant === null) {
            return null;
        }

        return TenantDTO::fromModel($tenant);
    }

    /**
     * {@inheritdoc}
     */
    public function getVerifactuConfig(int $tenantId): array
    {
        $tenant = Account::findOne($tenantId);

        if ($tenant === null) {
            throw new NotFoundHttpException('Tenant no encontrado');
        }

        return $tenant->getVerifactuSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function updateVerifactuConfig(int $tenantId, array $config): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $tenant = Account::findOne($tenantId);

            if ($tenant === null) {
                throw new NotFoundHttpException('Tenant no encontrado');
            }

            $tenant->setVerifactuSettings($config);

            if (!$tenant->save()) {
                throw new Exception('Error al actualizar configuración Verifactu: ' . json_encode($tenant->errors));
            }

            $transaction->commit();

            // Limpiar caché
            Yii::$app->tenantManager->clearCache();

            Yii::info("Configuración Verifactu actualizada para tenant {$tenantId}", __METHOD__);

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error actualizando configuración Verifactu: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }
}
