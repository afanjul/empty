<?php

namespace common\dto;

/**
 * InvoiceDTO - Data Transfer Object para facturas
 *
 * Objeto inmutable que representa una factura para transferencia entre capas
 */
readonly class InvoiceDTO
{
    public function __construct(
        public int $documentId,
        public int $tenantId,
        public int $documentTypeId,
        public int $status,
        public ?int $seriesId,
        public ?string $documentNumber,
        public string $issueDate,
        public ?string $dueDate,
        public ?string $description,
        public ?string $notes,
        public string $issuerName,
        public string $issuerTaxId,
        public ?int $recipientId,
        public ?string $recipientName,
        public ?string $recipientEmail,
        public ?string $recipientTaxId,
        public string $currencyId,
        public float $subtotalAmount,
        public float $taxAmount,
        public float $totalAmount,
        public array $items = [],
        public ?VerifactuRecordDTO $verifactuRecord = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    /**
     * Crea un DTO desde un modelo Document
     */
    public static function fromModel(\common\models\Document $document): self
    {
        return new self(
            documentId: $document->document_id,
            tenantId: $document->tenant_id,
            documentTypeId: $document->document_type_id,
            status: $document->status,
            seriesId: $document->document_series_id,
            documentNumber: $document->document_number,
            issueDate: $document->issue_date,
            dueDate: $document->due_date,
            description: $document->description,
            notes: $document->notes,
            issuerName: $document->issuer_name ?? '',
            issuerTaxId: $document->issuer_tax_id ?? '',
            recipientId: $document->recipient_id,
            recipientName: $document->recipient_name,
            recipientEmail: $document->recipient_email,
            recipientTaxId: $document->recipient_tax_id,
            currencyId: $document->document_currency_id,
            subtotalAmount: (float) $document->subtotal_amount,
            taxAmount: (float) $document->tax_amount,
            totalAmount: (float) $document->total_amount,
            items: array_map(
                fn($item) => InvoiceItemDTO::fromModel($item),
                $document->items
            ),
            verifactuRecord: $document->verifactuRecord
                ? VerifactuRecordDTO::fromModel($document->verifactuRecord)
                : null,
            createdAt: $document->created_at,
            updatedAt: $document->updated_at,
        );
    }

    /**
     * Convierte el DTO a array
     */
    public function toArray(): array
    {
        return [
            'document_id' => $this->documentId,
            'tenant_id' => $this->tenantId,
            'document_type_id' => $this->documentTypeId,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'series_id' => $this->seriesId,
            'document_number' => $this->documentNumber,
            'issue_date' => $this->issueDate,
            'due_date' => $this->dueDate,
            'description' => $this->description,
            'notes' => $this->notes,
            'issuer_name' => $this->issuerName,
            'issuer_tax_id' => $this->issuerTaxId,
            'recipient_id' => $this->recipientId,
            'recipient_name' => $this->recipientName,
            'recipient_email' => $this->recipientEmail,
            'recipient_tax_id' => $this->recipientTaxId,
            'currency_id' => $this->currencyId,
            'subtotal_amount' => $this->subtotalAmount,
            'tax_amount' => $this->taxAmount,
            'total_amount' => $this->totalAmount,
            'items' => array_map(fn($item) => $item->toArray(), $this->items),
            'verifactu_record' => $this->verifactuRecord?->toArray(),
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * Obtiene la etiqueta del estado
     */
    public function getStatusLabel(): string
    {
        return match ($this->status) {
            1 => 'Borrador',
            2 => 'Aprobada',
            3 => 'Enviada',
            4 => 'Parcialmente Pagada',
            5 => 'Pagada',
            6 => 'Cancelada',
            default => 'Desconocido',
        };
    }

    /**
     * Verifica si la factura está aprobada
     */
    public function isApproved(): bool
    {
        return $this->status >= 2;
    }

    /**
     * Verifica si tiene registro Verifactu
     */
    public function hasVerifactuRecord(): bool
    {
        return $this->verifactuRecord !== null;
    }
}
