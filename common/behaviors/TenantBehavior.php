<?php

namespace common\behaviors;

use common\components\TenantManager;
use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\web\ForbiddenHttpException;

/**
 * TenantBehavior - Behavior para automáticamente gestionar el tenant_id en modelos
 *
 * Este behavior:
 * - Asigna automáticamente el tenant_id al crear registros
 * - Filtra automáticamente las consultas por tenant_id
 * - Previene acceso cross-tenant
 * - Audita cambios de tenant_id (no permitidos)
 *
 * @property ActiveRecord $owner
 */
class TenantBehavior extends Behavior
{
    /**
     * @var string Nombre del atributo que almacena el tenant_id
     */
    public string $tenantAttribute = 'tenant_id';

    /**
     * @var bool Lanzar excepción si no hay tenant activo
     */
    public bool $required = true;

    /**
     * @var bool Permitir modificación del tenant_id (por defecto no)
     */
    public bool $allowModification = false;

    /**
     * @inheritdoc
     */
    public function events(): array
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    /**
     * Asigna el tenant_id antes de insertar
     *
     * @param Event $event
     * @throws ForbiddenHttpException
     */
    public function beforeInsert(Event $event): void
    {
        $tenantId = $this->getCurrentTenantId();

        if ($tenantId === null && $this->required) {
            throw new ForbiddenHttpException('No tenant context available');
        }

        if ($tenantId !== null) {
            $this->owner->{$this->tenantAttribute} = $tenantId;
        }
    }

    /**
     * Previene modificación del tenant_id en actualizaciones
     *
     * @param Event $event
     * @throws ForbiddenHttpException
     */
    public function beforeUpdate(Event $event): void
    {
        if (!$this->allowModification) {
            $oldTenantId = $this->owner->getOldAttribute($this->tenantAttribute);
            $newTenantId = $this->owner->{$this->tenantAttribute};

            if ($oldTenantId != $newTenantId) {
                // Intento de cambiar tenant_id - no permitido
                Yii::error(
                    "Attempted to modify tenant_id from {$oldTenantId} to {$newTenantId}",
                    __METHOD__
                );

                throw new ForbiddenHttpException('Modification of tenant_id is not allowed');
            }
        }

        // Verificar que el registro pertenece al tenant actual
        $currentTenantId = $this->getCurrentTenantId();

        if ($currentTenantId !== null && $this->owner->{$this->tenantAttribute} != $currentTenantId) {
            throw new ForbiddenHttpException('Access denied: cross-tenant operation detected');
        }
    }

    /**
     * Verifica acceso después de encontrar un registro
     *
     * @param Event $event
     * @throws ForbiddenHttpException
     */
    public function afterFind(Event $event): void
    {
        $currentTenantId = $this->getCurrentTenantId();

        // Si hay tenant actual y no coincide, es un error de seguridad
        if ($currentTenantId !== null && $this->owner->{$this->tenantAttribute} != $currentTenantId) {
            Yii::warning(
                "Cross-tenant access attempt: current tenant {$currentTenantId}, record tenant {$this->owner->{$this->tenantAttribute}}",
                __METHOD__
            );

            throw new ForbiddenHttpException('Access denied: cross-tenant access detected');
        }
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
