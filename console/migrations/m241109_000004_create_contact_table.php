<?php

use yii\db\Migration;

/**
 * Migración para crear la tabla contact
 *
 * Almacena clientes y proveedores de los tenants
 */
class m241109_000004_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'contact_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'type' => $this->tinyInteger()->unsigned()->notNull()->comment('1=organization,2=person'),
            'role' => $this->tinyInteger()->unsigned()->null()->comment('NULL=unspecified,1=client,2=supplier,3=lead,4=debtor,5=creditor'),
            'contact_group_id' => $this->integer()->unsigned()->null(),
            'parent_contact_id' => $this->integer()->unsigned()->null(),
            'nif_id_number' => $this->string(100)->null()->comment('NIF/CIF español'),
            'vat_id_number' => $this->string(50)->null()->comment('VAT/Tax ID'),
            'code' => $this->string(100)->null()->comment('Código interno'),
            'fiscal_name' => $this->string(200)->notNull()->comment('Nombre fiscal/razón social'),
            'trade_name' => $this->string(200)->null()->comment('Nombre comercial'),
            'email' => $this->string(200)->null(),
            'mobile' => $this->string(50)->null(),
            'phone' => $this->string(50)->null(),
            'website' => $this->string(255)->null(),
            'language_id' => $this->string(5)->null()->comment('ISO 639-1'),
            'currency_id' => $this->char(3)->null()->comment('ISO 4217'),
            'default_payment_method_id' => $this->integer()->unsigned()->null(),
            'default_due_days' => $this->integer()->null(),
            'default_payment_day' => $this->tinyInteger()->unsigned()->null(),
            'default_discount_percent' => $this->decimal(20, 6)->null(),
            'internal_reference' => $this->string(100)->null(),
            'show_trade_name_on_docs' => $this->boolean()->notNull()->defaultValue(false),
            'show_country_on_docs' => $this->boolean()->notNull()->defaultValue(false),
            'accumulate_model_347' => $this->boolean()->notNull()->defaultValue(false),
            'sales_accounting_account_id' => $this->integer()->unsigned()->null(),
            'purchase_accounting_account_id' => $this->integer()->unsigned()->null(),
            'customer_accounting_account_id' => $this->integer()->unsigned()->null(),
            'supplier_accounting_account_id' => $this->integer()->unsigned()->null(),
            'default_sales_tax_id' => $this->integer()->unsigned()->null(),
            'default_purchase_tax_id' => $this->integer()->unsigned()->null(),
            'billing_address_id' => $this->integer()->unsigned()->null(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'created_by' => $this->integer()->unsigned()->null(),
            'updated_by' => $this->integer()->unsigned()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->unsigned()->null(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Índices
        $this->createIndex('idx_contact_tenant', '{{%contact}}', 'tenant_id');
        $this->createIndex('idx_contact_type_role', '{{%contact}}', ['type', 'role']);
        $this->createIndex('idx_contact_nif', '{{%contact}}', 'nif_id_number');
        $this->createIndex('idx_contact_email', '{{%contact}}', 'email');
        $this->createIndex('idx_contact_deleted', '{{%contact}}', 'deleted_at');

        // Foreign Keys
        $this->addForeignKey(
            'fk_contact_tenant',
            '{{%contact}}',
            'tenant_id',
            '{{%account}}',
            'tenant_id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_contact_parent',
            '{{%contact}}',
            'parent_contact_id',
            '{{%contact}}',
            'contact_id',
            'RESTRICT',
            'SET NULL'
        );

        // Comentarios
        $this->addCommentOnTable('{{%contact}}', 'Clientes, proveedores y contactos');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_contact_parent', '{{%contact}}');
        $this->dropForeignKey('fk_contact_tenant', '{{%contact}}');
        $this->dropTable('{{%contact}}');
    }
}
