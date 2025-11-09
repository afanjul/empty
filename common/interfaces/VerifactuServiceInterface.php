<?php

namespace common\interfaces;

use common\models\Document;

/**
 * Interface VerifactuServiceInterface
 *
 * Define el contrato para el servicio de Verifactu
 */
interface VerifactuServiceInterface
{
    /**
     * Genera un registro de facturación Verifactu para un documento
     *
     * @param Document $document Documento (factura) para generar registro
     * @param array $options Opciones adicionales
     * @return array Datos del registro generado
     */
    public function generateRecord(Document $document, array $options = []): array;

    /**
     * Firma un registro de facturación
     *
     * @param int $verifactuRecordId ID del registro a firmar
     * @return bool True si se firmó correctamente
     */
    public function signRecord(int $verifactuRecordId): bool;

    /**
     * Genera el código QR para un registro
     *
     * @param int $verifactuRecordId ID del registro
     * @return string URL del código QR
     */
    public function generateQR(int $verifactuRecordId): string;

    /**
     * Obtiene el registro anterior en la cadena
     *
     * @param int $tenantId ID del tenant
     * @return array|null Datos del registro anterior o null si es el primero
     */
    public function getPreviousRecord(int $tenantId): ?array;

    /**
     * Valida la integridad de la cadena de registros
     *
     * @param int $tenantId ID del tenant
     * @param int|null $limit Número de registros a validar (null = todos)
     * @return array Resultados de la validación
     */
    public function validateChain(int $tenantId, ?int $limit = null): array;

    /**
     * Genera un registro de anulación
     *
     * @param Document $document Documento a anular
     * @param array $options Opciones adicionales
     * @return array Datos del registro de anulación
     */
    public function generateCancellationRecord(Document $document, array $options = []): array;
}
