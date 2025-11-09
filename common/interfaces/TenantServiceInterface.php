<?php

namespace common\interfaces;

use common\dto\TenantDTO;

/**
 * Interface TenantServiceInterface
 *
 * Define el contrato para el servicio de gestión de tenants
 */
interface TenantServiceInterface
{
    /**
     * Crea un nuevo tenant
     *
     * @param array $data Datos del tenant
     * @return TenantDTO DTO del tenant creado
     */
    public function createTenant(array $data): TenantDTO;

    /**
     * Actualiza un tenant existente
     *
     * @param int $tenantId ID del tenant
     * @param array $data Datos a actualizar
     * @return TenantDTO DTO del tenant actualizado
     */
    public function updateTenant(int $tenantId, array $data): TenantDTO;

    /**
     * Obtiene un tenant por ID
     *
     * @param int $tenantId ID del tenant
     * @return TenantDTO|null DTO del tenant o null si no existe
     */
    public function getTenant(int $tenantId): ?TenantDTO;

    /**
     * Obtiene la configuración de Verifactu de un tenant
     *
     * @param int $tenantId ID del tenant
     * @return array Configuración de Verifactu
     */
    public function getVerifactuConfig(int $tenantId): array;

    /**
     * Actualiza la configuración de Verifactu de un tenant
     *
     * @param int $tenantId ID del tenant
     * @param array $config Configuración de Verifactu
     * @return bool True si se actualizó correctamente
     */
    public function updateVerifactuConfig(int $tenantId, array $config): bool;
}
