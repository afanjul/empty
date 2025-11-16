<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * UserForm for creating and updating users
 */
class UserForm extends User
{
    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Las contraseñas no coinciden'],
            ['is_active', 'default', 'value' => true],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->password)) {
                $this->setPassword($this->password);
            }
            if ($insert && empty($this->auth_key)) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }
}
