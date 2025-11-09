<?php

namespace common\requests;

use yii\base\Model;

/**
 * CreateContactRequest - Request validator para crear contactos
 */
class CreateContactRequest extends Model
{
    public $type;
    public $role;
    public $fiscal_name;
    public $trade_name;
    public $nif_id_number;
    public $vat_id_number;
    public $code;
    public $email;
    public $mobile;
    public $phone;
    public $website;
    public $language_id;
    public $currency_id;
    public $default_payment_method_id;
    public $default_due_days;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['type', 'fiscal_name'], 'required'],
            [['type', 'role', 'default_payment_method_id', 'default_due_days'], 'integer'],
            [['type'], 'in', 'range' => [1, 2]], // organization, person
            [['role'], 'in', 'range' => [1, 2, 3, 4, 5]], // client, supplier, lead, debtor, creditor
            [['fiscal_name', 'trade_name'], 'string', 'max' => 200],
            [['code'], 'string', 'max' => 100],
            [['nif_id_number'], 'string', 'max' => 100],
            [['vat_id_number'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['mobile', 'phone'], 'string', 'max' => 50],
            [['website'], 'url'],
            [['language_id'], 'string', 'max' => 5],
            [['currency_id'], 'string', 'length' => 3],
            [['default_due_days'], 'integer', 'min' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'type' => 'Tipo',
            'role' => 'Rol',
            'fiscal_name' => 'Nombre Fiscal',
            'trade_name' => 'Nombre Comercial',
            'nif_id_number' => 'NIF/CIF',
            'vat_id_number' => 'VAT ID',
            'code' => 'Código',
            'email' => 'Email',
            'mobile' => 'Móvil',
            'phone' => 'Teléfono',
            'website' => 'Sitio Web',
            'language_id' => 'Idioma',
            'currency_id' => 'Moneda',
            'default_payment_method_id' => 'Método de Pago',
            'default_due_days' => 'Días de Vencimiento',
        ];
    }
}
