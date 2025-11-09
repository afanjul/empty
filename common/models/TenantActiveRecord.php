<?php

namespace common\models;

use common\behaviors\TenantBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * TenantActiveRecord - Clase base para todos los modelos con multitenencia
 *
 * Esta clase proporciona:
 * - Filtrado automático por tenant_id
 * - Asignación automática de tenant_id al crear
 * - Protección cross-tenant
 * - Timestamps automáticos (created_at, updated_at)
 * - Tracking de usuario (created_by, updated_by)
 * - Soft deletes (deleted_at, deleted_by)
 *
 * @property int $tenant_id
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
abstract class TenantActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            // Behavior de multitenencia
            'tenant' => [
                'class' => TenantBehavior::class,
                'tenantAttribute' => 'tenant_id',
                'required' => true,
                'allowModification' => false,
            ],

            // Timestamps automáticos
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],

            // Tracking de usuario
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => function () {
                    return \Yii::$app->user->id ?? null;
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return TenantActiveQuery
     */
    public static function find(): TenantActiveQuery
    {
        return new TenantActiveQuery(get_called_class());
    }

    /**
     * Encuentra un registro sin filtro de tenant
     *
     * USO: Solo para administradores del sistema o casos específicos
     *
     * @return TenantActiveQuery
     */
    public static function findWithoutTenant(): TenantActiveQuery
    {
        return static::find()->withoutTenantFilter();
    }

    /**
     * Soft delete - Marca el registro como eliminado sin borrarlo
     *
     * @return bool
     */
    public function softDelete(): bool
    {
        if ($this->hasAttribute('deleted_at')) {
            $this->deleted_at = new Expression('NOW()');
        }

        if ($this->hasAttribute('deleted_by')) {
            $this->deleted_by = \Yii::$app->user->id ?? null;
        }

        return $this->save(false);
    }

    /**
     * Restaura un registro soft deleted
     *
     * @return bool
     */
    public function restore(): bool
    {
        if ($this->hasAttribute('deleted_at')) {
            $this->deleted_at = null;
        }

        if ($this->hasAttribute('deleted_by')) {
            $this->deleted_by = null;
        }

        return $this->save(false);
    }

    /**
     * Verifica si el registro está soft deleted
     *
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->hasAttribute('deleted_at') && $this->deleted_at !== null;
    }

    /**
     * Scope para obtener solo registros no eliminados
     *
     * @return TenantActiveQuery
     */
    public static function findActive(): TenantActiveQuery
    {
        $query = static::find();

        if (static::instance()->hasAttribute('deleted_at')) {
            $query->andWhere(['deleted_at' => null]);
        }

        return $query;
    }

    /**
     * Scope para obtener solo registros eliminados
     *
     * @return TenantActiveQuery
     */
    public static function findDeleted(): TenantActiveQuery
    {
        $query = static::find();

        if (static::instance()->hasAttribute('deleted_at')) {
            $query->andWhere(['IS NOT', 'deleted_at', null]);
        }

        return $query;
    }

    /**
     * Obtiene una instancia nueva del modelo
     *
     * @return static
     */
    protected static function instance(): static
    {
        return new static();
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        // Si el modelo soporta soft delete, usarlo por defecto
        if ($this->hasAttribute('deleted_at')) {
            return $this->softDelete();
        }

        return parent::delete();
    }

    /**
     * Hard delete - Elimina el registro físicamente de la base de datos
     *
     * @return int|false
     * @throws \yii\db\StaleObjectException
     */
    public function hardDelete(): int|false
    {
        return parent::delete();
    }
}
