<?php

use yii\db\Migration;

/**
 * Migración para crear la tabla account (tenants)
 *
 * Esta tabla almacena la información de cada tenant (cliente) del sistema SaaS
 */
class m241109_000001_create_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%account}}', [
            'tenant_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'fiscal_name' => $this->string(200)->notNull()->comment('Nombre fiscal/razón social'),
            'trade_name' => $this->string(200)->null()->comment('Nombre comercial'),
            'subdomain' => $this->string(100)->notNull()->unique()->comment('Subdominio para acceso'),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1)->comment('1=TRIAL,2=ACTIVE,3=INACTIVE,4=CANCELED,5=CHARGEBACK'),
            'base_currency_id' => $this->char(3)->notNull()->comment('ISO 4217'),
            'default_language_id' => $this->string(5)->null()->comment('ISO 639-1'),
            'country_id' => $this->char(2)->null()->comment('ISO 3166-1 alpha-2'),
            'timezone' => $this->string(64)->notNull()->defaultValue('UTC'),
            'nif_id_number' => $this->string(50)->null()->comment('NIF/CIF español'),
            'vat_id_number' => $this->string(50)->null()->comment('VAT/Tax ID'),
            'account_settings' => $this->json()->null()->comment('Configuración en JSON'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'created_by' => $this->integer()->unsigned()->null(),
            'updated_by' => $this->integer()->unsigned()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->unsigned()->null(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Índices
        $this->createIndex('idx_account_status', '{{%account}}', 'status');
        $this->createIndex('idx_account_subdomain', '{{%account}}', 'subdomain');
        $this->createIndex('idx_account_deleted_at', '{{%account}}', 'deleted_at');

        // Comentarios
        $this->addCommentOnTable('{{%account}}', 'Tenants/Cuentas del sistema SaaS');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%account}}');
    }
}
