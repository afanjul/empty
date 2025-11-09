<?php

namespace common\interfaces;

/**
 * Interface AuditServiceInterface
 *
 * Define el contrato para el servicio de auditoría
 */
interface AuditServiceInterface
{
    /**
     * Registra un evento de auditoría
     *
     * @param string $eventType Tipo de evento
     * @param string $modelClass Clase del modelo afectado
     * @param string|int|null $modelId ID del modelo afectado
     * @param array $data Datos adicionales del evento
     * @return bool True si se registró correctamente
     */
    public function log(string $eventType, string $modelClass, string|int|null $modelId = null, array $data = []): bool;

    /**
     * Obtiene el log de auditoría con filtros
     *
     * @param array $filters Filtros de búsqueda
     * @param int $page Página actual
     * @param int $pageSize Tamaño de página
     * @return array Array con 'items' y 'total'
     */
    public function getLog(array $filters = [], int $page = 1, int $pageSize = 50): array;

    /**
     * Obtiene el historial de un modelo específico
     *
     * @param string $modelClass Clase del modelo
     * @param string|int $modelId ID del modelo
     * @return array Array de eventos de auditoría
     */
    public function getModelHistory(string $modelClass, string|int $modelId): array;
}
