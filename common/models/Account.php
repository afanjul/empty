<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Account Model - Representa un tenant (cliente) del sistema SaaS
 *
 * @property int $tenant_id
 * @property string $fiscal_name
 * @property string|null $trade_name
 * @property string $subdomain
 * @property int $status
 * @property string $base_currency_id
 * @property string|null $default_language_id
 * @property string|null $country_id
 * @property string $timezone
 * @property string|null $nif_id_number
 * @property string|null $vat_id_number
 * @property array|null $account_settings
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class Account extends ActiveRecord
{
    // Estados de la cuenta
    const STATUS_TRIAL = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_INACTIVE = 3;
    const STATUS_CANCELED = 4;
    const STATUS_CHARGEBACK = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%account}}';
    }

    /**
     * {@inheritdoc}
     *
     * NOTA: Account NO usa TenantActiveRecord porque es la tabla de tenants misma
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fiscal_name', 'subdomain', 'base_currency_id'], 'required'],
            [['fiscal_name', 'trade_name'], 'string', 'max' => 200],
            [['subdomain'], 'string', 'max' => 100],
            [['subdomain'], 'unique'],
            [['subdomain'], 'match', 'pattern' => '/^[a-z0-9-]+$/', 'message' => 'El subdominio solo puede contener letras minúsculas, números y guiones'],
            [['status'], 'integer'],
            [['status'], 'in', 'range' => [self::STATUS_TRIAL, self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_CANCELED, self::STATUS_CHARGEBACK]],
            [['base_currency_id'], 'string', 'length' => 3],
            [['default_language_id'], 'string', 'max' => 5],
            [['country_id'], 'string', 'length' => 2],
            [['timezone'], 'string', 'max' => 64],
            [['nif_id_number', 'vat_id_number'], 'string', 'max' => 50],
            [['nif_id_number'], 'validateSpanishNIF'],
            [['account_settings'], 'safe'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * Valida formato de NIF/CIF español
     */
    public function validateSpanishNIF($attribute, $params)
    {
        if (empty($this->$attribute)) {
            return;
        }

        $nif = strtoupper($this->$attribute);

        // Validación básica de formato NIF/CIF/NIE español
        if (!preg_match('/^[XYZ0-9][0-9]{7}[A-Z0-9]$/', $nif)) {
            $this->addError($attribute, 'El formato del NIF/CIF no es válido');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'tenant_id' => 'ID Tenant',
            'fiscal_name' => 'Nombre Fiscal',
            'trade_name' => 'Nombre Comercial',
            'subdomain' => 'Subdominio',
            'status' => 'Estado',
            'base_currency_id' => 'Moneda Base',
            'default_language_id' => 'Idioma',
            'country_id' => 'País',
            'timezone' => 'Zona Horaria',
            'nif_id_number' => 'NIF/CIF',
            'vat_id_number' => 'VAT ID',
            'account_settings' => 'Configuración',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Obtiene el nombre del estado
     */
    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_TRIAL => 'Prueba',
            self::STATUS_ACTIVE => 'Activo',
            self::STATUS_INACTIVE => 'Inactivo',
            self::STATUS_CANCELED => 'Cancelado',
            self::STATUS_CHARGEBACK => 'Impago',
            default => 'Desconocido',
        };
    }

    /**
     * Verifica si la cuenta está activa
     */
    public function isActive(): bool
    {
        return in_array($this->status, [self::STATUS_TRIAL, self::STATUS_ACTIVE]);
    }

    /**
     * Obtiene la configuración de Verifactu
     */
    public function getVerifactuSettings(): array
    {
        return $this->account_settings['verifactu'] ?? [];
    }

    /**
     * Establece la configuración de Verifactu
     */
    public function setVerifactuSettings(array $settings): void
    {
        $currentSettings = $this->account_settings ?? [];
        $currentSettings['verifactu'] = $settings;
        $this->account_settings = $currentSettings;
    }

    /**
     * Relación con usuarios
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['tenant_id' => 'tenant_id']);
    }
}
