<?php

namespace common\models;

/**
 * Contact Model - Representa un contacto (cliente/proveedor)
 *
 * @property int $contact_id
 * @property int $tenant_id
 * @property int $type
 * @property int|null $role
 * @property int|null $parent_contact_id
 * @property string|null $nif_id_number
 * @property string|null $vat_id_number
 * @property string|null $code
 * @property string $fiscal_name
 * @property string|null $trade_name
 * @property string|null $email
 * @property string|null $mobile
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $language_id
 * @property string|null $currency_id
 * @property int|null $default_payment_method_id
 * @property int|null $default_due_days
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 */
class Contact extends TenantActiveRecord
{
    // Tipos de contacto
    const TYPE_ORGANIZATION = 1;
    const TYPE_PERSON = 2;

    // Roles de contacto
    const ROLE_CLIENT = 1;
    const ROLE_SUPPLIER = 2;
    const ROLE_LEAD = 3;
    const ROLE_DEBTOR = 4;
    const ROLE_CREDITOR = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%contact}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fiscal_name'], 'required'],
            [['type'], 'required'],
            [['type', 'role'], 'integer'],
            [['type'], 'in', 'range' => [self::TYPE_ORGANIZATION, self::TYPE_PERSON]],
            [['role'], 'in', 'range' => [self::ROLE_CLIENT, self::ROLE_SUPPLIER, self::ROLE_LEAD, self::ROLE_DEBTOR, self::ROLE_CREDITOR]],
            [['fiscal_name', 'trade_name'], 'string', 'max' => 200],
            [['code'], 'string', 'max' => 100],
            [['nif_id_number'], 'string', 'max' => 100],
            [['vat_id_number'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 200],
            [['mobile', 'phone'], 'string', 'max' => 50],
            [['website'], 'url'],
            [['website'], 'string', 'max' => 255],
            [['language_id'], 'string', 'max' => 5],
            [['currency_id'], 'string', 'length' => 3],
            [['default_due_days'], 'integer', 'min' => 0],
            [['nif_id_number'], 'validateSpanishNIF'],
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
            'contact_id' => 'ID',
            'type' => 'Tipo',
            'role' => 'Rol',
            'nif_id_number' => 'NIF/CIF',
            'vat_id_number' => 'VAT ID',
            'code' => 'Código',
            'fiscal_name' => 'Nombre Fiscal',
            'trade_name' => 'Nombre Comercial',
            'email' => 'Email',
            'mobile' => 'Móvil',
            'phone' => 'Teléfono',
            'website' => 'Sitio Web',
            'language_id' => 'Idioma',
            'currency_id' => 'Moneda',
            'default_payment_method_id' => 'Método de Pago',
            'default_due_days' => 'Días de Vencimiento',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Obtiene el nombre para mostrar
     */
    public function getDisplayName(): string
    {
        return $this->trade_name ?? $this->fiscal_name;
    }

    /**
     * Verifica si es un cliente
     */
    public function isClient(): bool
    {
        return $this->role === self::ROLE_CLIENT;
    }

    /**
     * Verifica si es un proveedor
     */
    public function isSupplier(): bool
    {
        return $this->role === self::ROLE_SUPPLIER;
    }

    /**
     * Relación con documentos como destinatario
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::class, ['recipient_id' => 'contact_id']);
    }

    /**
     * Relación con contacto padre
     */
    public function getParent()
    {
        return $this->hasOne(Contact::class, ['contact_id' => 'parent_contact_id']);
    }

    /**
     * Relación con contactos hijos
     */
    public function getChildren()
    {
        return $this->hasMany(Contact::class, ['parent_contact_id' => 'contact_id']);
    }
}
