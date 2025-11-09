<?php

use yii\db\Migration;

/**
 * Migración para crear las tablas específicas de VERIFACTU
 *
 * Estas tablas almacenan:
 * - Registros de facturación (hash encadenado, firma, QR)
 * - Información del sistema informático
 * - Certificados digitales
 * - Envíos a AEAT
 * - Eventos de auditoría
 */
class m241109_000006_create_verifactu_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Tabla verifactu_system_info - Información del sistema informático
        $this->createTable('{{%verifactu_system_info}}', [
            'system_info_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string(100)->notNull()->comment('Nombre del sistema'),
            'nif' => $this->string(50)->notNull()->comment('NIF del fabricante'),
            'id_number' => $this->string(30)->notNull()->comment('Identificador del sistema'),
            'version' => $this->string(50)->notNull(),
            'installation_number' => $this->string(100)->null(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        $this->createIndex('idx_system_tenant', '{{%verifactu_system_info}}', 'tenant_id');
        $this->addForeignKey('fk_system_tenant', '{{%verifactu_system_info}}', 'tenant_id', '{{%account}}', 'tenant_id', 'RESTRICT', 'CASCADE');

        // Tabla verifactu_certificate - Certificados digitales para firma
        $this->createTable('{{%verifactu_certificate}}', [
            'certificate_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string(200)->notNull(),
            'certificate_pem' => $this->text()->notNull()->comment('Certificado en formato PEM (encriptado)'),
            'private_key_pem' => $this->text()->notNull()->comment('Clave privada en formato PEM (encriptada)'),
            'passphrase' => $this->string(255)->null()->comment('Passphrase encriptada'),
            'issuer' => $this->string(255)->null(),
            'subject' => $this->string(255)->null(),
            'serial_number' => $this->string(100)->null(),
            'valid_from' => $this->dateTime()->null(),
            'valid_to' => $this->dateTime()->null(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'created_by' => $this->integer()->unsigned()->null(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        $this->createIndex('idx_cert_tenant', '{{%verifactu_certificate}}', 'tenant_id');
        $this->createIndex('idx_cert_active', '{{%verifactu_certificate}}', 'is_active');
        $this->addForeignKey('fk_cert_tenant', '{{%verifactu_certificate}}', 'tenant_id', '{{%account}}', 'tenant_id', 'RESTRICT', 'CASCADE');

        // Tabla verifactu_record - Registros de facturación Verifactu
        $this->createTable('{{%verifactu_record}}', [
            'verifactu_record_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'document_id' => $this->integer()->unsigned()->notNull(),

            // Identificación del registro
            'version' => $this->string(10)->notNull()->defaultValue('1.0'),
            'record_type' => $this->string(20)->notNull()->comment('alta, anulacion'),

            // Identificación de la factura (IDFactura)
            'issuer_nif' => $this->string(50)->notNull(),
            'invoice_number' => $this->string(60)->notNull(),
            'issue_date' => $this->date()->notNull(),
            'operation_description' => $this->string(500)->null(),

            // Encadenamiento
            'is_first_record' => $this->boolean()->notNull()->defaultValue(false),
            'previous_record_id' => $this->integer()->unsigned()->null(),
            'previous_issuer_nif' => $this->string(50)->null(),
            'previous_invoice_number' => $this->string(60)->null(),
            'previous_issue_date' => $this->date()->null(),
            'previous_hash' => $this->string(64)->null()->comment('Primeros 64 chars del hash anterior'),

            // Sistema informático
            'system_info_id' => $this->integer()->unsigned()->null(),

            // Hash y firma
            'hash_algorithm' => $this->string(10)->notNull()->defaultValue('01')->comment('01=SHA-256'),
            'hash' => $this->string(64)->notNull()->comment('Hash del registro'),
            'signature' => $this->text()->null()->comment('Firma electrónica XAdES'),
            'signed_at' => $this->dateTime()->null(),

            // Código QR
            'qr_code' => $this->text()->null()->comment('Contenido del código QR'),
            'qr_image_path' => $this->string(500)->null()->comment('Ruta a la imagen del QR'),

            // Timestamp de generación
            'generated_at' => $this->dateTime()->notNull()->comment('FechaHoraHusoGenRegistro'),

            // Metadatos adicionales de Verifactu
            'invoice_type' => $this->string(2)->notNull()->comment('F1=factura completa, F2=simplificada, etc.'),
            'rectification_type' => $this->string(1)->null()->comment('S=sustitución, D=diferencias'),
            'is_substitution' => $this->boolean()->notNull()->defaultValue(false),
            'is_subsanation' => $this->boolean()->notNull()->defaultValue(false),
            'rejection_retry' => $this->boolean()->notNull()->defaultValue(false),

            // Importes para Verifactu
            'total_base' => $this->decimal(12, 2)->null(),
            'total_tax' => $this->decimal(12, 2)->null(),
            'total_amount' => $this->decimal(12, 2)->null(),

            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Índices verifactu_record
        $this->createIndex('idx_vf_tenant_doc', '{{%verifactu_record}}', ['tenant_id', 'document_id']);
        $this->createIndex('idx_vf_invoice', '{{%verifactu_record}}', ['issuer_nif', 'invoice_number', 'issue_date']);
        $this->createIndex('idx_vf_hash', '{{%verifactu_record}}', 'hash');
        $this->createIndex('idx_vf_generated', '{{%verifactu_record}}', 'generated_at');

        // Foreign Keys verifactu_record
        $this->addForeignKey('fk_vf_tenant', '{{%verifactu_record}}', 'tenant_id', '{{%account}}', 'tenant_id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_vf_document', '{{%verifactu_record}}', 'document_id', '{{%document}}', 'document_id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_vf_previous', '{{%verifactu_record}}', 'previous_record_id', '{{%verifactu_record}}', 'verifactu_record_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_vf_system', '{{%verifactu_record}}', 'system_info_id', '{{%verifactu_system_info}}', 'system_info_id', 'NO ACTION', 'NO ACTION');

        // Tabla verifactu_submission - Envíos a AEAT
        $this->createTable('{{%verifactu_submission}}', [
            'submission_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'submission_type' => $this->string(20)->notNull()->comment('voluntary, requirement'),

            // Referencia de requerimiento (si aplica)
            'requirement_reference' => $this->string(18)->null(),
            'is_final_submission' => $this->boolean()->notNull()->defaultValue(false),

            // Estado del envío
            'status' => $this->string(20)->notNull()->comment('pending, sent, accepted, rejected, error'),
            'submitted_at' => $this->dateTime()->null(),

            // Respuesta de AEAT
            'response_code' => $this->string(50)->null(),
            'response_message' => $this->text()->null(),
            'response_csv' => $this->string(100)->null()->comment('Código Seguro de Verificación'),
            'response_data' => $this->json()->null(),

            // Reintentos
            'retry_count' => $this->integer()->notNull()->defaultValue(0),
            'last_retry_at' => $this->dateTime()->null(),
            'next_retry_at' => $this->dateTime()->null(),

            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Índices verifactu_submission
        $this->createIndex('idx_submission_tenant', '{{%verifactu_submission}}', 'tenant_id');
        $this->createIndex('idx_submission_status', '{{%verifactu_submission}}', 'status');
        $this->createIndex('idx_submission_next_retry', '{{%verifactu_submission}}', 'next_retry_at');

        $this->addForeignKey('fk_submission_tenant', '{{%verifactu_submission}}', 'tenant_id', '{{%account}}', 'tenant_id', 'RESTRICT', 'CASCADE');

        // Tabla pivot verifactu_submission_record - Relación N:M entre submissions y records
        $this->createTable('{{%verifactu_submission_record}}', [
            'submission_id' => $this->integer()->unsigned()->notNull(),
            'verifactu_record_id' => $this->integer()->unsigned()->notNull(),
            'PRIMARY KEY (submission_id, verifactu_record_id)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        $this->addForeignKey('fk_sr_submission', '{{%verifactu_submission_record}}', 'submission_id', '{{%verifactu_submission}}', 'submission_id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_sr_record', '{{%verifactu_submission_record}}', 'verifactu_record_id', '{{%verifactu_record}}', 'verifactu_record_id', 'CASCADE', 'CASCADE');

        // Tabla verifactu_event - Registros de eventos (auditoría de Verifactu)
        $this->createTable('{{%verifactu_event}}', [
            'event_id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'version' => $this->string(10)->notNull()->defaultValue('1.0'),
            'event_type' => $this->string(2)->notNull()->comment('R=detección anomalías, E=exportación'),
            'event_data' => $this->json()->notNull(),
            'hash' => $this->string(64)->notNull(),
            'generated_at' => $this->dateTime()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        $this->createIndex('idx_event_tenant', '{{%verifactu_event}}', 'tenant_id');
        $this->createIndex('idx_event_type', '{{%verifactu_event}}', 'event_type');
        $this->createIndex('idx_event_generated', '{{%verifactu_event}}', 'generated_at');
        $this->addForeignKey('fk_event_tenant', '{{%verifactu_event}}', 'tenant_id', '{{%account}}', 'tenant_id', 'RESTRICT', 'CASCADE');

        // Comentarios
        $this->addCommentOnTable('{{%verifactu_record}}', 'Registros de facturación Verifactu con hash encadenado');
        $this->addCommentOnTable('{{%verifactu_submission}}', 'Envíos de registros a AEAT');
        $this->addCommentOnTable('{{%verifactu_event}}', 'Registros de eventos de Verifactu');
        $this->addCommentOnTable('{{%verifactu_certificate}}', 'Certificados digitales para firma electrónica');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%verifactu_event}}');
        $this->dropTable('{{%verifactu_submission_record}}');
        $this->dropTable('{{%verifactu_submission}}');
        $this->dropTable('{{%verifactu_record}}');
        $this->dropTable('{{%verifactu_certificate}}');
        $this->dropTable('{{%verifactu_system_info}}');
    }
}
