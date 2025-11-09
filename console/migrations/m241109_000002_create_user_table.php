<?php

use yii\db\Migration;

/**
 * Migración para crear la tabla user
 *
 * Almacena usuarios del sistema, con soporte multitenencia
 */
class m241109_000002_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'user_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->null()->comment('NULL para superadmins'),
            'email' => $this->string(200)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_reset_token' => $this->string(255)->null()->unique(),
            'email_verification_token' => $this->string(255)->null()->unique(),
            'first_name' => $this->string(100)->notNull(),
            'last_name' => $this->string(100)->null(),
            'is_superadmin' => $this->boolean()->notNull()->defaultValue(false),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'user_settings' => $this->json()->null(),
            'last_login_at' => $this->dateTime()->null(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'password_updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'updated_by' => $this->integer()->unsigned()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->unsigned()->null(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Índices
        $this->createIndex('idx_user_tenant', '{{%user}}', 'tenant_id');
        $this->createIndex('idx_user_email', '{{%user}}', 'email');
        $this->createIndex('idx_user_is_active', '{{%user}}', 'is_active');
        $this->createIndex('idx_user_deleted_at', '{{%user}}', 'deleted_at');

        // Foreign Keys
        $this->addForeignKey(
            'fk_user_tenant',
            '{{%user}}',
            'tenant_id',
            '{{%account}}',
            'tenant_id',
            'RESTRICT',
            'CASCADE'
        );

        // Comentarios
        $this->addCommentOnTable('{{%user}}', 'Usuarios del sistema');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_tenant', '{{%user}}');
        $this->dropTable('{{%user}}');
    }
}
