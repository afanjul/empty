<?php

namespace common\models;

/**
 * Document Model - Representa un documento (factura, ticket, nota de crédito, etc.)
 *
 * @property int $document_id
 * @property int $tenant_id
 * @property int $document_type_id
 * @property int $status
 * @property int|null $document_series_id
 * @property int|null $sequence_number
 * @property string|null $document_number
 * @property string $issue_date
 * @property string|null $due_date
 * @property string|null $description
 * @property string|null $notes
 * @property string|null $issuer_name
 * @property string|null $issuer_tax_id
 * @property int|null $recipient_id
 * @property string|null $recipient_name
 * @property string|null $recipient_tax_id
 * @property string $base_currency_id
 * @property string $document_currency_id
 * @property float $exchange_rate
 * @property float|null $subtotal_amount
 * @property float|null $discount_amount
 * @property float|null $tax_amount
 * @property float|null $total_amount
 * @property int $lock_version
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Contact|null $recipient
 * @property-read DocumentItem[] $items
 * @property-read VerifactuRecord|null $verifactuRecord
 */
class Document extends TenantActiveRecord
{
    // Estados del documento
    const STATUS_DRAFT = 1;
    const STATUS_APPROVED = 2;
    const STATUS_SENT = 3;
    const STATUS_PARTIALLY_PAID = 4;
    const STATUS_PAID = 5;
    const STATUS_CANCELLED = 6;

    // Tipos de documento
    const TYPE_INVOICE = 1;
    const TYPE_SALES_RECEIPT = 2;
    const TYPE_CREDIT_NOTE = 3;
    const TYPE_SALES_ORDER = 4;
    const TYPE_PROFORMA = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%document}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['document_type_id', 'issue_date', 'base_currency_id', 'document_currency_id'], 'required'],
            [['document_type_id', 'status', 'recipient_id', 'sequence_number'], 'integer'],
            [['issue_date', 'due_date'], 'date', 'format' => 'php:Y-m-d'],
            [['description'], 'string', 'max' => 500],
            [['notes'], 'string'],
            [['document_number'], 'string', 'max' => 100],
            [['issuer_name', 'recipient_name'], 'string', 'max' => 200],
            [['issuer_tax_id', 'recipient_tax_id'], 'string', 'max' => 50],
            [['base_currency_id', 'document_currency_id'], 'string', 'length' => 3],
            [['exchange_rate'], 'number', 'min' => 0.0000000001],
            [['subtotal_amount', 'discount_amount', 'tax_amount', 'total_amount'], 'number'],
            [['status'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_APPROVED, self::STATUS_SENT, self::STATUS_PARTIALLY_PAID, self::STATUS_PAID, self::STATUS_CANCELLED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'document_id' => 'ID',
            'document_type_id' => 'Tipo de Documento',
            'status' => 'Estado',
            'document_number' => 'Número',
            'issue_date' => 'Fecha de Emisión',
            'due_date' => 'Fecha de Vencimiento',
            'description' => 'Descripción',
            'notes' => 'Notas',
            'recipient_name' => 'Cliente',
            'recipient_tax_id' => 'NIF/CIF Cliente',
            'subtotal_amount' => 'Subtotal',
            'tax_amount' => 'IVA',
            'total_amount' => 'Total',
        ];
    }

    /**
     * Relación con contacto (cliente/destinatario)
     */
    public function getRecipient()
    {
        return $this->hasOne(Contact::class, ['contact_id' => 'recipient_id']);
    }

    /**
     * Relación con líneas de documento
     */
    public function getItems()
    {
        return $this->hasMany(DocumentItem::class, ['document_id' => 'document_id'])
            ->orderBy(['position' => SORT_ASC]);
    }

    /**
     * Relación con registro Verifactu
     */
    public function getVerifactuRecord()
    {
        return $this->hasOne(VerifactuRecord::class, ['document_id' => 'document_id']);
    }

    /**
     * Relación con serie de documento
     */
    public function getSeries()
    {
        return $this->hasOne(DocumentSeries::class, ['document_series_id' => 'document_series_id']);
    }

    /**
     * Obtiene el nombre del estado
     */
    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'Borrador',
            self::STATUS_APPROVED => 'Aprobada',
            self::STATUS_SENT => 'Enviada',
            self::STATUS_PARTIALLY_PAID => 'Parcialmente Pagada',
            self::STATUS_PAID => 'Pagada',
            self::STATUS_CANCELLED => 'Cancelada',
            default => 'Desconocido',
        };
    }

    /**
     * Verifica si es una factura (no ticket ni nota de crédito)
     */
    public function isInvoice(): bool
    {
        return $this->document_type_id === self::TYPE_INVOICE;
    }

    /**
     * Verifica si el documento está aprobado
     */
    public function isApproved(): bool
    {
        return $this->status >= self::STATUS_APPROVED;
    }

    /**
     * Verifica si el documento está cancelado
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Verifica si el documento puede ser editado
     */
    public function canBeEdited(): bool
    {
        return $this->status === self::STATUS_DRAFT && !$this->isDeleted();
    }

    /**
     * Verifica si el documento puede ser aprobado
     */
    public function canBeApproved(): bool
    {
        return $this->status === self::STATUS_DRAFT && count($this->items) > 0;
    }
}
