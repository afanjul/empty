<?php

namespace common\services;

use common\interfaces\AuditServiceInterface;
use Yii;

/**
 * AuditService - Servicio de auditoría (placeholder)
 *
 * Este servicio debe ampliarse con la lógica completa de auditoría
 */
class AuditService implements AuditServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function log(string $eventType, string $modelClass, string|int|null $modelId = null, array $data = []): bool
    {
        // TODO: Implementar registro en audit_log table
        Yii::info("Audit log: {$eventType} - {$modelClass}:{$modelId}", __METHOD__);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getLog(array $filters = [], int $page = 1, int $pageSize = 50): array
    {
        // TODO: Implementar consulta de audit_log
        return [
            'items' => [],
            'total' => 0,
            'page' => $page,
            'page_size' => $pageSize,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getModelHistory(string $modelClass, string|int $modelId): array
    {
        // TODO: Implementar historial del modelo
        return [];
    }
}
