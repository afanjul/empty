<?php

namespace common\models;

/**
 * DocumentItem Model - Representa una línea de documento (factura)
 *
 * @property int $document_item_id
 * @property int $tenant_id
 * @property int $document_id
 * @property int $position
 * @property int $item_type
 * @property string $name
 * @property string|null $description
 * @property string|null $sku
 * @property float $quantity
 * @property float $unit_price
 * @property float|null $line_subtotal
 * @property int|null $discount_type
 * @property float|null $discount_value
 * @property float|null $discount_amount
 * @property float|null $line_total_excl_tax
 * @property float|null $tax_amount
 * @property float|null $line_total_incl_tax
 * @property int $lock_version
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Document $document
 */
class DocumentItem extends TenantActiveRecord
{
    // Tipos de item
    const TYPE_PRODUCT = 1;
    const TYPE_SERVICE = 2;
    const TYPE_ADJUSTMENT = 3;

    // Tipos de descuento
    const DISCOUNT_TYPE_PERCENT = 1;
    const DISCOUNT_TYPE_AMOUNT = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%document_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['document_id', 'position', 'item_type', 'name'], 'required'],
            [['document_id', 'position', 'item_type', 'discount_type'], 'integer'],
            [['item_type'], 'in', 'range' => [self::TYPE_PRODUCT, self::TYPE_SERVICE, self::TYPE_ADJUSTMENT]],
            [['name'], 'string', 'max' => 200],
            [['description'], 'string'],
            [['sku'], 'string', 'max' => 100],
            [['quantity', 'unit_price', 'line_subtotal', 'discount_value', 'discount_amount',
              'line_total_excl_tax', 'tax_amount', 'line_total_incl_tax'], 'number'],
            [['quantity'], 'number', 'min' => 0.000000001],
            [['unit_price'], 'number', 'min' => 0],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'document_item_id' => 'ID',
            'document_id' => 'Documento',
            'position' => 'Posición',
            'item_type' => 'Tipo',
            'name' => 'Nombre',
            'description' => 'Descripción',
            'sku' => 'SKU/Código',
            'quantity' => 'Cantidad',
            'unit_price' => 'Precio Unitario',
            'line_subtotal' => 'Subtotal',
            'discount_amount' => 'Descuento',
            'line_total_excl_tax' => 'Total sin IVA',
            'tax_amount' => 'IVA',
            'line_total_incl_tax' => 'Total con IVA',
        ];
    }

    /**
     * Relación con documento
     */
    public function getDocument()
    {
        return $this->hasOne(Document::class, ['document_id' => 'document_id']);
    }

    /**
     * Calcula los totales de la línea
     *
     * @param float $taxRate Tasa de impuesto (ej: 21 para 21%)
     */
    public function calculateTotals(float $taxRate = 21.0): void
    {
        // Calcular subtotal
        $this->line_subtotal = $this->quantity * $this->unit_price;

        // Calcular descuento si aplica
        if ($this->discount_type && $this->discount_value) {
            if ($this->discount_type === self::DISCOUNT_TYPE_PERCENT) {
                $this->discount_amount = $this->line_subtotal * ($this->discount_value / 100);
            } else {
                $this->discount_amount = $this->discount_value;
            }
        } else {
            $this->discount_amount = 0;
        }

        // Total sin impuestos
        $this->line_total_excl_tax = $this->line_subtotal - $this->discount_amount;

        // Calcular impuesto
        $this->tax_amount = $this->line_total_excl_tax * ($taxRate / 100);

        // Total con impuestos
        $this->line_total_incl_tax = $this->line_total_excl_tax + $this->tax_amount;
    }

    /**
     * Hook before save para calcular totales
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Recalcular totales si han cambiado cantidad o precio
            if ($this->isAttributeChanged('quantity') || $this->isAttributeChanged('unit_price') ||
                $this->isAttributeChanged('discount_value')) {
                $this->calculateTotals();
            }
            return true;
        }
        return false;
    }
}
