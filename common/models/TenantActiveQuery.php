<?php

namespace common\models;

use common\components\TenantManager;
use Yii;
use yii\db\ActiveQuery;

/**
 * TenantActiveQuery - Query automática filtrada por tenant
 *
 * Esta clase extiende ActiveQuery para automáticamente filtrar
 * todas las consultas por el tenant_id del contexto actual.
 */
class TenantActiveQuery extends ActiveQuery
{
    /**
     * @var bool Si se debe aplicar el filtro de tenant automáticamente
     */
    private bool $_applyTenantFilter = true;

    /**
     * @var string Nombre del atributo de tenant
     */
    protected string $tenantAttribute = 'tenant_id';

    /**
     * Desactiva el filtro automático de tenant para esta consulta
     *
     * USO: Solo usar cuando explícitamente necesites datos cross-tenant
     * (por ejemplo, administradores del sistema)
     *
     * @return $this
     */
    public function withoutTenantFilter(): static
    {
        $this->_applyTenantFilter = false;
        return $this;
    }

    /**
     * Filtra específicamente por un tenant dado
     *
     * @param int $tenantId ID del tenant a filtrar
     * @return $this
     */
    public function forTenant(int $tenantId): static
    {
        $this->_applyTenantFilter = false; // Desactivar filtro automático
        $this->andWhere([$this->tenantAttribute => $tenantId]);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prepare($builder)
    {
        // Aplicar filtro de tenant si está activado
        if ($this->_applyTenantFilter) {
            $tenantId = $this->getCurrentTenantId();

            if ($tenantId !== null) {
                // Agregar condición WHERE para tenant_id
                $tableName = $this->getPrimaryTableName();

                if ($tableName !== null) {
                    $this->andWhere(["{$tableName}.{$this->tenantAttribute}" => $tenantId]);
                } else {
                    $this->andWhere([$this->tenantAttribute => $tenantId]);
                }
            }
        }

        return parent::prepare($builder);
    }

    /**
     * Obtiene el nombre de la tabla principal
     *
     * @return string|null
     */
    protected function getPrimaryTableName(): ?string
    {
        if (empty($this->from)) {
            /** @var \yii\db\ActiveRecord $modelClass */
            $modelClass = $this->modelClass;
            return $modelClass::tableName();
        }

        $from = $this->from;

        if (is_array($from)) {
            $tableName = reset($from);
        } else {
            $tableName = $from;
        }

        // Remover alias si existe
        if (is_string($tableName) && preg_match('/^(.*?)\s+as\s+/i', $tableName, $matches)) {
            $tableName = $matches[1];
        }

        return is_string($tableName) ? $tableName : null;
    }

    /**
     * Obtiene el ID del tenant actual
     *
     * @return int|null
     */
    protected function getCurrentTenantId(): ?int
    {
        if (!Yii::$app->has('tenantManager')) {
            return null;
        }

        /** @var TenantManager $tenantManager */
        $tenantManager = Yii::$app->get('tenantManager');

        return $tenantManager->getTenantId();
    }
}
