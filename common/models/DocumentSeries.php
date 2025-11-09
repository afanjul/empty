<?php

namespace common\models;

/**
 * DocumentSeries Model - Representa una serie de numeración de documentos
 *
 * @property int $document_series_id
 * @property int $tenant_id
 * @property int $document_type_id
 * @property string $name
 * @property string|null $prefix
 * @property string|null $suffix
 * @property bool $reset_annually
 * @property int $padding
 * @property int $last_sequence
 * @property bool $is_default
 * @property string $created_at
 * @property string $updated_at
 */
class DocumentSeries extends TenantActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%document_series}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['document_type_id', 'name'], 'required'],
            [['document_type_id', 'padding', 'last_sequence'], 'integer'],
            [['reset_annually', 'is_default'], 'boolean'],
            [['name'], 'string', 'max' => 200],
            [['prefix', 'suffix'], 'string', 'max' => 50],
            [['padding'], 'integer', 'min' => 1, 'max' => 15],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'document_series_id' => 'ID',
            'document_type_id' => 'Tipo de Documento',
            'name' => 'Nombre',
            'prefix' => 'Prefijo',
            'suffix' => 'Sufijo',
            'reset_annually' => 'Reiniciar Anualmente',
            'padding' => 'Relleno (ceros)',
            'last_sequence' => 'Última Secuencia',
            'is_default' => 'Por Defecto',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Genera el siguiente número de documento
     *
     * @return string Número de documento formateado
     */
    public function getNextNumber(): string
    {
        // Incrementar secuencia
        $this->last_sequence++;

        // Si es reset anual y cambió el año, resetear
        if ($this->reset_annually) {
            $currentYear = date('Y');
            $lastYear = $this->getLastDocumentYear();

            if ($lastYear && $lastYear !== $currentYear) {
                $this->last_sequence = 1;
            }
        }

        // Formatear número
        return $this->formatNumber($this->last_sequence);
    }

    /**
     * Formatea un número de secuencia
     *
     * @param int $sequence Número de secuencia
     * @return string Número formateado
     */
    public function formatNumber(int $sequence): string
    {
        $number = str_pad($sequence, $this->padding, '0', STR_PAD_LEFT);

        $formatted = '';

        if ($this->prefix) {
            $formatted .= $this->prefix;
        }

        $formatted .= $number;

        if ($this->suffix) {
            $formatted .= $this->suffix;
        }

        return $formatted;
    }

    /**
     * Obtiene el año del último documento
     *
     * @return string|null
     */
    protected function getLastDocumentYear(): ?string
    {
        $lastDoc = Document::find()
            ->where(['tenant_id' => $this->tenant_id, 'document_series_id' => $this->document_series_id])
            ->orderBy(['document_id' => SORT_DESC])
            ->one();

        if ($lastDoc) {
            return date('Y', strtotime($lastDoc->issue_date));
        }

        return null;
    }

    /**
     * Relación con documentos
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::class, ['document_series_id' => 'document_series_id']);
    }

    /**
     * Hook before save para validar única serie por defecto por tipo
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Si se marca como por defecto, desmarcar las demás
            if ($this->is_default) {
                DocumentSeries::updateAll(
                    ['is_default' => false],
                    [
                        'tenant_id' => $this->tenant_id,
                        'document_type_id' => $this->document_type_id,
                    ]
                );
            }
            return true;
        }
        return false;
    }
}
