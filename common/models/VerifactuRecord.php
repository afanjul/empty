<?php

namespace common\models;

/**
 * VerifactuRecord Model - Representa un registro de facturación Verifactu
 *
 * @property int $verifactu_record_id
 * @property int $tenant_id
 * @property int $document_id
 * @property string $version
 * @property string $record_type
 * @property string $issuer_nif
 * @property string $invoice_number
 * @property string $issue_date
 * @property string|null $operation_description
 * @property bool $is_first_record
 * @property int|null $previous_record_id
 * @property string|null $previous_hash
 * @property string $hash_algorithm
 * @property string $hash
 * @property string|null $signature
 * @property string|null $signed_at
 * @property string|null $qr_code
 * @property string|null $qr_image_path
 * @property string $generated_at
 * @property string $invoice_type
 * @property float|null $total_base
 * @property float|null $total_tax
 * @property float|null $total_amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Document $document
 * @property-read VerifactuRecord|null $previousRecord
 */
class VerifactuRecord extends TenantActiveRecord
{
    // Tipos de registro
    const TYPE_ALTA = 'alta';
    const TYPE_ANULACION = 'anulacion';

    // Tipos de factura
    const INVOICE_TYPE_F1 = 'F1'; // Factura completa
    const INVOICE_TYPE_F2 = 'F2'; // Factura simplificada
    const INVOICE_TYPE_F3 = 'F3'; // Factura emitida en sustitución de facturas simplificadas facturadas
    const INVOICE_TYPE_R1 = 'R1'; // Factura rectificativa por error fundado en derecho
    const INVOICE_TYPE_R2 = 'R2'; // Factura rectificativa por artículo 80.1, 80.2 y 80.3 LIVA
    const INVOICE_TYPE_R3 = 'R3'; // Factura rectificativa por artículo 80.4 LIVA
    const INVOICE_TYPE_R4 = 'R4'; // Factura rectificativa por artículo 80.6 LIVA
    const INVOICE_TYPE_R5 = 'R5'; // Factura rectificativa en facturas simplificadas

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%verifactu_record}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['document_id', 'issuer_nif', 'invoice_number', 'issue_date', 'hash', 'generated_at', 'invoice_type'], 'required'],
            [['document_id', 'previous_record_id', 'system_info_id'], 'integer'],
            [['is_first_record', 'is_substitution', 'is_subsanation', 'rejection_retry'], 'boolean'],
            [['record_type'], 'in', 'range' => [self::TYPE_ALTA, self::TYPE_ANULACION]],
            [['issue_date'], 'date', 'format' => 'php:Y-m-d'],
            [['generated_at', 'signed_at'], 'safe'],
            [['version'], 'string', 'max' => 10],
            [['issuer_nif'], 'string', 'max' => 50],
            [['invoice_number'], 'string', 'max' => 60],
            [['invoice_type'], 'string', 'max' => 2],
            [['hash_algorithm'], 'string', 'max' => 10],
            [['hash', 'previous_hash'], 'string', 'length' => 64],
            [['signature', 'qr_code'], 'string'],
            [['qr_image_path'], 'string', 'max' => 500],
            [['operation_description'], 'string', 'max' => 500],
            [['total_base', 'total_tax', 'total_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'verifactu_record_id' => 'ID Registro',
            'document_id' => 'Documento',
            'version' => 'Versión',
            'record_type' => 'Tipo de Registro',
            'issuer_nif' => 'NIF Emisor',
            'invoice_number' => 'Número de Factura',
            'issue_date' => 'Fecha de Emisión',
            'hash' => 'Huella/Hash',
            'signature' => 'Firma Electrónica',
            'qr_code' => 'Código QR',
            'generated_at' => 'Generado el',
            'invoice_type' => 'Tipo de Factura',
            'total_amount' => 'Importe Total',
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
     * Relación con registro anterior en la cadena
     */
    public function getPreviousRecord()
    {
        return $this->hasOne(VerifactuRecord::class, ['verifactu_record_id' => 'previous_record_id']);
    }

    /**
     * Relación con registros siguientes en la cadena
     */
    public function getNextRecords()
    {
        return $this->hasMany(VerifactuRecord::class, ['previous_record_id' => 'verifactu_record_id']);
    }

    /**
     * Verifica si el registro está firmado
     */
    public function isSigned(): bool
    {
        return $this->signature !== null && $this->signed_at !== null;
    }

    /**
     * Verifica si el registro tiene código QR generado
     */
    public function hasQRCode(): bool
    {
        return $this->qr_code !== null;
    }

    /**
     * Verifica si es el primer registro de la cadena
     */
    public function isFirstRecord(): bool
    {
        return $this->is_first_record === true;
    }

    /**
     * Verifica si es un registro de alta
     */
    public function isAlta(): bool
    {
        return $this->record_type === self::TYPE_ALTA;
    }

    /**
     * Verifica si es un registro de anulación
     */
    public function isAnulacion(): bool
    {
        return $this->record_type === self::TYPE_ANULACION;
    }

    /**
     * Obtiene el contenido para calcular el hash
     */
    public function getHashContent(): string
    {
        $content = implode('', [
            $this->issuer_nif,
            $this->invoice_number,
            \Yii::$app->formatter->asDate($this->issue_date, 'dd-MM-yyyy'),
            $this->invoice_type,
            number_format($this->total_tax, 2, '.', ''),
            number_format($this->total_amount, 2, '.', ''),
        ]);

        if (!$this->is_first_record && $this->previous_hash !== null) {
            $content .= substr($this->previous_hash, 0, 64);
        }

        return $content;
    }
}
