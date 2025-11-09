<?php

namespace common\dto;

/**
 * InvoiceItemDTO - Data Transfer Object para líneas de factura
 */
readonly class InvoiceItemDTO
{
    public function __construct(
        public ?int $documentItemId,
        public int $position,
        public int $itemType,
        public string $name,
        public ?string $description,
        public ?string $sku,
        public float $quantity,
        public float $unitPrice,
        public float $lineSubtotal,
        public ?float $discountAmount,
        public float $lineTotalExclTax,
        public float $taxAmount,
        public float $lineTotalInclTax,
    ) {}

    /**
     * Crea un DTO desde un modelo DocumentItem
     */
    public static function fromModel(\common\models\DocumentItem $item): self
    {
        return new self(
            documentItemId: $item->document_item_id,
            position: $item->position,
            itemType: $item->item_type,
            name: $item->name,
            description: $item->description,
            sku: $item->sku,
            quantity: (float) $item->quantity,
            unitPrice: (float) $item->unit_price,
            lineSubtotal: (float) $item->line_subtotal,
            discountAmount: $item->discount_amount ? (float) $item->discount_amount : null,
            lineTotalExclTax: (float) $item->line_total_excl_tax,
            taxAmount: (float) $item->tax_amount,
            lineTotalInclTax: (float) $item->line_total_incl_tax,
        );
    }

    /**
     * Convierte el DTO a array
     */
    public function toArray(): array
    {
        return [
            'document_item_id' => $this->documentItemId,
            'position' => $this->position,
            'item_type' => $this->itemType,
            'name' => $this->name,
            'description' => $this->description,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'unit_price' => $this->unitPrice,
            'line_subtotal' => $this->lineSubtotal,
            'discount_amount' => $this->discountAmount,
            'line_total_excl_tax' => $this->lineTotalExclTax,
            'tax_amount' => $this->taxAmount,
            'line_total_incl_tax' => $this->lineTotalInclTax,
        ];
    }
}
