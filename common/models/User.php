<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * User Model - Representa un usuario del sistema
 *
 * @property int $user_id
 * @property int|null $tenant_id
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $password_reset_token
 * @property string|null $email_verification_token
 * @property string $first_name
 * @property string|null $last_name
 * @property bool $is_superadmin
 * @property bool $is_active
 * @property array|null $user_settings
 * @property string|null $last_login_at
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['email', 'first_name'], 'required'],
            [['tenant_id'], 'integer'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['password_reset_token', 'email_verification_token'], 'unique'],
            [['is_superadmin', 'is_active'], 'boolean'],
            [['user_settings'], 'safe'],
            [['last_login_at', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'user_id' => 'ID',
            'tenant_id' => 'Tenant',
            'email' => 'Email',
            'first_name' => 'Nombre',
            'last_name' => 'Apellido',
            'is_superadmin' => 'Superadministrador',
            'is_active' => 'Activo',
            'last_login_at' => 'Último Acceso',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Genera un hash de contraseña
     *
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Valida una contraseña
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Genera un auth key
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Genera un token para reset de contraseña
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Verifica si el token de reset es válido
     *
     * @param string $token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'] ?? 3600;

        return $timestamp + $expire >= time();
    }

    /**
     * Limpia el token de reset
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    /**
     * Obtiene el nombre completo
     */
    public function getFullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Relación con Account (tenant)
     */
    public function getTenant()
    {
        return $this->hasOne(Account::class, ['tenant_id' => 'tenant_id']);
    }

    /**
     * Verifica si el usuario es superadmin
     */
    public function isSuperadmin(): bool
    {
        return (bool) $this->is_superadmin;
    }

    // IdentityInterface implementation

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id, 'is_active' => true, 'deleted_at' => null]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Implementar si se usa autenticación por token
        return null;
    }

    /**
     * Encuentra un usuario por email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail(string $email): ?static
    {
        return static::findOne(['email' => $email, 'is_active' => true, 'deleted_at' => null]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Hook before save
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert && empty($this->auth_key)) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }
}
