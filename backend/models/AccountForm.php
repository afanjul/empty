<?php

namespace backend\models;

use common\models\Account;

/**
 * AccountForm for creating and updating accounts
 */
class AccountForm extends Account
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['status', 'default', 'value' => self::STATUS_TRIAL],
            ['base_currency_id', 'default', 'value' => 'EUR'],
            ['timezone', 'default', 'value' => 'Europe/Madrid'],
        ]);
    }
}
