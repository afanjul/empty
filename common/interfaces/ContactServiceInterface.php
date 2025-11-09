<?php

namespace common\interfaces;

use common\dto\ContactDTO;

/**
 * Interface ContactServiceInterface
 *
 * Define el contrato para el servicio de contactos (clientes/proveedores)
 */
interface ContactServiceInterface
{
    /**
     * Crea un nuevo contacto
     *
     * @param array $data Datos del contacto
     * @return ContactDTO DTO del contacto creado
     */
    public function createContact(array $data): ContactDTO;

    /**
     * Actualiza un contacto existente
     *
     * @param int $contactId ID del contacto
     * @param array $data Datos a actualizar
     * @return ContactDTO DTO del contacto actualizado
     */
    public function updateContact(int $contactId, array $data): ContactDTO;

    /**
     * Obtiene un contacto por ID
     *
     * @param int $contactId ID del contacto
     * @return ContactDTO|null DTO del contacto o null si no existe
     */
    public function getContact(int $contactId): ?ContactDTO;

    /**
     * Lista contactos con filtros y paginación
     *
     * @param array $filters Filtros de búsqueda
     * @param int $page Página actual
     * @param int $pageSize Tamaño de página
     * @return array Array con 'items' y 'total'
     */
    public function listContacts(array $filters = [], int $page = 1, int $pageSize = 20): array;

    /**
     * Elimina un contacto (soft delete)
     *
     * @param int $contactId ID del contacto
     * @return bool True si se eliminó correctamente
     */
    public function deleteContact(int $contactId): bool;

    /**
     * Busca contactos por término de búsqueda
     *
     * @param string $query Término de búsqueda
     * @param int $limit Límite de resultados
     * @return array Array de ContactDTO
     */
    public function searchContacts(string $query, int $limit = 10): array;

    /**
     * Valida un NIF/CIF español
     *
     * @param string $nif NIF/CIF a validar
     * @return bool True si es válido
     */
    public function validateNIF(string $nif): bool;
}
