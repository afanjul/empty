<?php

namespace common\interfaces;

use common\dto\InvoiceDTO;
use common\models\Document;

/**
 * Interface InvoiceServiceInterface
 *
 * Define el contrato para el servicio de facturas
 */
interface InvoiceServiceInterface
{
    /**
     * Crea una nueva factura
     *
     * @param array $data Datos de la factura
     * @return InvoiceDTO DTO de la factura creada
     */
    public function createInvoice(array $data): InvoiceDTO;

    /**
     * Actualiza una factura existente
     *
     * @param int $documentId ID del documento
     * @param array $data Datos a actualizar
     * @return InvoiceDTO DTO de la factura actualizada
     */
    public function updateInvoice(int $documentId, array $data): InvoiceDTO;

    /**
     * Obtiene una factura por ID
     *
     * @param int $documentId ID del documento
     * @return InvoiceDTO|null DTO de la factura o null si no existe
     */
    public function getInvoice(int $documentId): ?InvoiceDTO;

    /**
     * Lista facturas con filtros y paginación
     *
     * @param array $filters Filtros de búsqueda
     * @param int $page Página actual
     * @param int $pageSize Tamaño de página
     * @return array Array con 'items' y 'total'
     */
    public function listInvoices(array $filters = [], int $page = 1, int $pageSize = 20): array;

    /**
     * Elimina una factura (soft delete)
     *
     * @param int $documentId ID del documento
     * @return bool True si se eliminó correctamente
     */
    public function deleteInvoice(int $documentId): bool;

    /**
     * Aprueba una factura y genera registro Verifactu
     *
     * @param int $documentId ID del documento
     * @return InvoiceDTO DTO de la factura aprobada
     */
    public function approveInvoice(int $documentId): InvoiceDTO;

    /**
     * Genera el PDF de una factura
     *
     * @param int $documentId ID del documento
     * @return string Ruta al archivo PDF generado
     */
    public function generatePDF(int $documentId): string;

    /**
     * Envía una factura por email
     *
     * @param int $documentId ID del documento
     * @param string|null $email Email del destinatario (null = email del cliente)
     * @return bool True si se envió correctamente
     */
    public function sendByEmail(int $documentId, ?string $email = null): bool;

    /**
     * Calcula los totales de una factura
     *
     * @param array $items Líneas de la factura
     * @param array $taxes Impuestos aplicables
     * @return array Array con subtotal, tax, total, etc.
     */
    public function calculateTotals(array $items, array $taxes = []): array;
}
