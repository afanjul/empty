<?php

use yii\db\Migration;

/**
 * Migración para crear las tablas principales de documentos (facturas)
 * Incluye: document_type, document_series, document, document_item
 */
class m241109_000005_create_document_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Tabla document_type
        $this->createTable('{{%document_type}}', [
            'document_type_id' => $this->tinyInteger()->unsigned()->notNull(),
            'code' => $this->string(50)->notNull()->unique(),
            'name' => $this->string(100)->notNull(),
            'PRIMARY KEY (document_type_id)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Insertar tipos de documento
        $this->batchInsert('{{%document_type}}', ['document_type_id', 'code', 'name'], [
            [1, 'invoice', 'Factura'],
            [2, 'sales_receipt', 'Ticket/Recibo'],
            [3, 'credit_note', 'Nota de Crédito'],
            [4, 'sales_order', 'Pedido de Venta'],
            [5, 'proforma', 'Proforma'],
            [6, 'waybill', 'Albarán'],
            [7, 'estimate', 'Presupuesto'],
            [8, 'purchase', 'Factura de Compra'],
            [9, 'purchase_order', 'Pedido de Compra'],
            [10, 'purchase_refund', 'Devolución de Compra'],
        ]);

        // Tabla document_series
        $this->createTable('{{%document_series}}', [
            'document_series_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'document_type_id' => $this->tinyInteger()->unsigned()->notNull(),
            'name' => $this->string(200)->notNull(),
            'prefix' => $this->string(50)->null(),
            'suffix' => $this->string(50)->null(),
            'reset_annually' => $this->boolean()->notNull()->defaultValue(true),
            'padding' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(6),
            'last_sequence' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'is_default' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        $this->createIndex('idx_series_tenant_type', '{{%document_series}}', ['tenant_id', 'document_type_id']);
        $this->addForeignKey('fk_series_tenant', '{{%document_series}}', 'tenant_id', '{{%account}}', 'tenant_id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_series_type', '{{%document_series}}', 'document_type_id', '{{%document_type}}', 'document_type_id', 'NO ACTION', 'NO ACTION');

        // Tabla document (facturas, tickets, etc.)
        $this->createTable('{{%document}}', [
            'document_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'document_type_id' => $this->tinyInteger()->unsigned()->notNull(),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1)->comment('1=draft,2=approved,3=sent,4=partially_paid,5=paid,6=cancelled'),
            'document_series_id' => $this->integer()->unsigned()->null(),
            'document_parent_id' => $this->integer()->unsigned()->null(),
            'sequence_number' => $this->integer()->unsigned()->null(),
            'document_number' => $this->string(100)->null(),
            'issue_date' => $this->date()->notNull(),
            'due_date' => $this->date()->null(),
            'description' => $this->string(500)->null(),
            'notes' => $this->text()->null(),

            // Emisor
            'issuer_name' => $this->string(200)->null(),
            'issuer_tax_id' => $this->string(50)->null(),
            'issuer_address' => $this->string(200)->null(),
            'issuer_city' => $this->string(100)->null(),
            'issuer_postal_code' => $this->string(20)->null(),
            'issuer_country_id' => $this->char(2)->null(),

            // Destinatario
            'recipient_id' => $this->integer()->unsigned()->null(),
            'recipient_name' => $this->string(200)->null(),
            'recipient_email' => $this->string(200)->null(),
            'recipient_tax_id' => $this->string(50)->null(),
            'recipient_code' => $this->string(100)->null(),

            // Dirección de facturación
            'billing_address' => $this->string(200)->null(),
            'billing_city' => $this->string(100)->null(),
            'billing_postal_code' => $this->string(20)->null(),
            'billing_country_id' => $this->char(2)->null(),
            'billing_name' => $this->string(200)->null(),
            'billing_phone' => $this->string(50)->null(),
            'billing_email' => $this->string(200)->null(),

            // Moneda
            'base_currency_id' => $this->char(3)->notNull(),
            'document_currency_id' => $this->char(3)->notNull(),
            'exchange_rate' => $this->decimal(20, 10)->notNull()->defaultValue(1),

            // Importes
            'subtotal_amount' => $this->decimal(20, 4)->null(),
            'discount_amount' => $this->decimal(20, 4)->null(),
            'charge_amount' => $this->decimal(20, 4)->null(),
            'tax_amount' => $this->decimal(20, 4)->null(),
            'total_amount' => $this->decimal(20, 4)->null(),
            'base_total_amount' => $this->decimal(20, 4)->null()->comment('Total en moneda base'),

            // Control de concurrencia
            'lock_version' => $this->integer()->unsigned()->notNull()->defaultValue(0),

            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'created_by' => $this->integer()->unsigned()->null(),
            'updated_by' => $this->integer()->unsigned()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->unsigned()->null(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Índices document
        $this->createIndex('idx_doc_tenant_type', '{{%document}}', ['tenant_id', 'document_type_id']);
        $this->createIndex('idx_doc_number', '{{%document}}', 'document_number');
        $this->createIndex('idx_doc_status', '{{%document}}', 'status');
        $this->createIndex('idx_doc_issue_date', '{{%document}}', 'issue_date');
        $this->createIndex('idx_doc_recipient', '{{%document}}', 'recipient_id');
        $this->createIndex('idx_doc_deleted', '{{%document}}', 'deleted_at');

        // Foreign Keys document
        $this->addForeignKey('fk_doc_tenant', '{{%document}}', 'tenant_id', '{{%account}}', 'tenant_id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_doc_type', '{{%document}}', 'document_type_id', '{{%document_type}}', 'document_type_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_doc_series', '{{%document}}', 'document_series_id', '{{%document_series}}', 'document_series_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_doc_recipient', '{{%document}}', 'recipient_id', '{{%contact}}', 'contact_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_doc_parent', '{{%document}}', 'document_parent_id', '{{%document}}', 'document_id', 'NO ACTION', 'NO ACTION');

        // Tabla document_item (líneas de documento)
        $this->createTable('{{%document_item}}', [
            'document_item_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'document_id' => $this->integer()->unsigned()->notNull(),
            'position' => $this->smallInteger()->unsigned()->notNull(),
            'item_type' => $this->tinyInteger()->unsigned()->notNull()->comment('1=product,2=service,3=adjustment'),
            'name' => $this->string(200)->notNull(),
            'description' => $this->text()->null(),
            'sku' => $this->string(100)->null(),
            'quantity' => $this->decimal(20, 9)->notNull()->defaultValue(1),
            'unit_price' => $this->decimal(20, 6)->notNull()->defaultValue(0),
            'line_subtotal' => $this->decimal(20, 4)->null(),
            'discount_type' => $this->tinyInteger()->unsigned()->null(),
            'discount_value' => $this->decimal(20, 4)->null(),
            'discount_amount' => $this->decimal(20, 4)->null(),
            'line_total_excl_tax' => $this->decimal(20, 4)->null(),
            'tax_amount' => $this->decimal(20, 4)->null(),
            'line_total_incl_tax' => $this->decimal(20, 4)->null(),

            'lock_version' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'created_by' => $this->integer()->unsigned()->null(),
            'updated_by' => $this->integer()->unsigned()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->unsigned()->null(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Índices document_item
        $this->createIndex('idx_item_document', '{{%document_item}}', 'document_id');
        $this->createIndex('idx_item_tenant', '{{%document_item}}', 'tenant_id');

        // Foreign Keys document_item
        $this->addForeignKey('fk_item_tenant', '{{%document_item}}', 'tenant_id', '{{%account}}', 'tenant_id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_item_document', '{{%document_item}}', 'document_id', '{{%document}}', 'document_id', 'RESTRICT', 'CASCADE');

        // Comentarios
        $this->addCommentOnTable('{{%document}}', 'Documentos (facturas, tickets, notas de crédito, etc.)');
        $this->addCommentOnTable('{{%document_item}}', 'Líneas de documento');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%document_item}}');
        $this->dropTable('{{%document}}');
        $this->dropTable('{{%document_series}}');
        $this->dropTable('{{%document_type}}');
    }
}
