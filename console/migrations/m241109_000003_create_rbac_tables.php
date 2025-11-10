<?php

use yii\db\Migration;

/**
 * Migración para crear las tablas de RBAC (Role-Based Access Control)
 *
 * Basado en el schema MultiTenantDbManager de Yii2
 */
class m241109_000003_create_rbac_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Tabla auth_rule - Reglas de negocio para permisos
        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary()->null(),
            'created_at' => $this->bigInteger()->unsigned()->null(),
            'updated_at' => $this->bigInteger()->unsigned()->null(),
            'PRIMARY KEY (name)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Tabla auth_item - Roles y permisos
        $this->createTable('{{%auth_item}}', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull()->comment('1=role, 2=permission'),
            'rule_name' => $this->string(64)->null(),
            'description' => $this->text()->null(),
            'data' => $this->binary()->null(),
            'created_at' => $this->bigInteger()->unsigned()->null(),
            'updated_at' => $this->bigInteger()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'updated_by' => $this->integer()->unsigned()->null(),
            'version' => $this->integer()->unsigned()->notNull()->defaultValue(1),
            'is_system' => $this->boolean()->notNull()->defaultValue(false)->comment('Item del sistema, no editable'),
            'display_name' => $this->string(128)->null(),
            'group_name' => $this->string(64)->null(),
            'sort_order' => $this->integer()->null(),
            'PRIMARY KEY (name)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Índices para auth_item
        $this->createIndex('idx_auth_item_type', '{{%auth_item}}', 'type');
        $this->createIndex('idx_auth_item_group', '{{%auth_item}}', 'group_name');

        // Foreign Key a auth_rule
        $this->addForeignKey(
            'fk_auth_item_rule',
            '{{%auth_item}}',
            'rule_name',
            '{{%auth_rule}}',
            'name',
            'CASCADE',
            'CASCADE'
        );

        // Tabla auth_item_child - Jerarquía de roles/permisos
        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Foreign Keys para auth_item_child
        $this->addForeignKey(
            'fk_auth_item_child_parent',
            '{{%auth_item_child}}',
            'parent',
            '{{%auth_item}}',
            'name',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_auth_item_child_child',
            '{{%auth_item_child}}',
            'child',
            '{{%auth_item}}',
            'name',
            'CASCADE',
            'CASCADE'
        );

        // Tabla auth_assignment - Asignaciones de roles a usuarios (multi-tenant)
        $this->createTable('{{%auth_assignment}}', [
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->bigInteger()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'updated_by' => $this->integer()->unsigned()->null(),
            'version' => $this->integer()->unsigned()->notNull()->defaultValue(1),
            'PRIMARY KEY (tenant_id, item_name, user_id)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Foreign Keys para auth_assignment
        $this->addForeignKey(
            'fk_auth_assignment_item',
            '{{%auth_assignment}}',
            'item_name',
            '{{%auth_item}}',
            'name',
            'CASCADE',
            'CASCADE'
        );

        // Tabla auth_audit_log - Log de cambios en RBAC
        $this->createTable('{{%auth_audit_log}}', [
            'id' => $this->bigInteger()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'tenant_id' => $this->integer()->unsigned()->notNull(),
            'actor_user_id' => $this->integer()->unsigned()->null(),
            'action' => $this->string(64)->notNull()->comment('create_role, assign_role, revoke_role, etc.'),
            'item_name' => $this->string(64)->null(),
            'item_type' => $this->smallInteger()->null(),
            'target_user_id' => $this->integer()->unsigned()->null(),
            'data' => $this->json()->null(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Índices para auth_audit_log
        $this->createIndex('idx_auth_audit_tenant', '{{%auth_audit_log}}', 'tenant_id');
        $this->createIndex('idx_auth_audit_action', '{{%auth_audit_log}}', 'action');

        // Comentarios
        $this->addCommentOnTable('{{%auth_item}}', 'Roles y permisos del sistema RBAC');
        $this->addCommentOnTable('{{%auth_item_child}}', 'Jerarquía de roles y permisos');
        $this->addCommentOnTable('{{%auth_assignment}}', 'Asignaciones de roles a usuarios (multi-tenant)');
        $this->addCommentOnTable('{{%auth_audit_log}}', 'Auditoría de cambios en RBAC');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth_audit_log}}');
        $this->dropForeignKey('fk_auth_assignment_item', '{{%auth_assignment}}');
        $this->dropTable('{{%auth_assignment}}');
        $this->dropForeignKey('fk_auth_item_child_parent', '{{%auth_item_child}}');
        $this->dropForeignKey('fk_auth_item_child_child', '{{%auth_item_child}}');
        $this->dropTable('{{%auth_item_child}}');
        $this->dropForeignKey('fk_auth_item_rule', '{{%auth_item}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_rule}}');
    }
}
