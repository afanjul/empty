<?php

namespace common\dto;

/**
 * VerifactuRecordDTO - Data Transfer Object para registros Verifactu
 */
readonly class VerifactuRecordDTO
{
    public function __construct(
        public int $verifactuRecordId,
        public int $tenantId,
        public int $documentId,
        public string $version,
        public string $recordType,
        public string $issuerNif,
        public string $invoiceNumber,
        public string $issueDate,
        public ?string $operationDescription,
        public bool $isFirstRecord,
        public ?int $previousRecordId,
        public ?string $previousHash,
        public string $hashAlgorithm,
        public string $hash,
        public ?string $signature,
        public ?string $signedAt,
        public ?string $qrCode,
        public ?string $qrImagePath,
        public string $generatedAt,
        public string $invoiceType,
        public float $totalBase,
        public float $totalTax,
        public float $totalAmount,
        public ?string $createdAt = null,
    ) {}

    /**
     * Crea un DTO desde un modelo VerifactuRecord
     */
    public static function fromModel(\common\models\VerifactuRecord $record): self
    {
        return new self(
            verifactuRecordId: $record->verifactu_record_id,
            tenantId: $record->tenant_id,
            documentId: $record->document_id,
            version: $record->version,
            recordType: $record->record_type,
            issuerNif: $record->issuer_nif,
            invoiceNumber: $record->invoice_number,
            issueDate: $record->issue_date,
            operationDescription: $record->operation_description,
            isFirstRecord: (bool) $record->is_first_record,
            previousRecordId: $record->previous_record_id,
            previousHash: $record->previous_hash,
            hashAlgorithm: $record->hash_algorithm,
            hash: $record->hash,
            signature: $record->signature,
            signedAt: $record->signed_at,
            qrCode: $record->qr_code,
            qrImagePath: $record->qr_image_path,
            generatedAt: $record->generated_at,
            invoiceType: $record->invoice_type,
            totalBase: (float) $record->total_base,
            totalTax: (float) $record->total_tax,
            totalAmount: (float) $record->total_amount,
            createdAt: $record->created_at,
        );
    }

    /**
     * Convierte el DTO a array
     */
    public function toArray(): array
    {
        return [
            'verifactu_record_id' => $this->verifactuRecordId,
            'tenant_id' => $this->tenantId,
            'document_id' => $this->documentId,
            'version' => $this->version,
            'record_type' => $this->recordType,
            'issuer_nif' => $this->issuerNif,
            'invoice_number' => $this->invoiceNumber,
            'issue_date' => $this->issueDate,
            'operation_description' => $this->operationDescription,
            'is_first_record' => $this->isFirstRecord,
            'previous_record_id' => $this->previousRecordId,
            'previous_hash' => $this->previousHash,
            'hash_algorithm' => $this->hashAlgorithm,
            'hash' => $this->hash,
            'signature' => $this->signature,
            'signed_at' => $this->signedAt,
            'qr_code' => $this->qrCode,
            'qr_image_path' => $this->qrImagePath,
            'generated_at' => $this->generatedAt,
            'invoice_type' => $this->invoiceType,
            'total_base' => $this->totalBase,
            'total_tax' => $this->totalTax,
            'total_amount' => $this->totalAmount,
            'created_at' => $this->createdAt,
            'is_signed' => $this->isSigned(),
            'has_qr' => $this->hasQR(),
        ];
    }

    /**
     * Verifica si está firmado
     */
    public function isSigned(): bool
    {
        return $this->signature !== null && $this->signedAt !== null;
    }

    /**
     * Verifica si tiene QR
     */
    public function hasQR(): bool
    {
        return $this->qrCode !== null;
    }
}
