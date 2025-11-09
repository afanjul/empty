<?php

namespace common\requests;

use yii\base\Model;

/**
 * UpdateInvoiceRequest - Request validator para actualizar facturas
 */
class UpdateInvoiceRequest extends Model
{
    public $issue_date;
    public $due_date;
    public $description;
    public $notes;
    public $recipient_id;
    public $items;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['recipient_id'], 'integer'],
            [['issue_date', 'due_date'], 'date', 'format' => 'php:Y-m-d'],
            [['description'], 'string', 'max' => 500],
            [['notes'], 'string'],
            [['items'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'issue_date' => 'Fecha de Emisión',
            'due_date' => 'Fecha de Vencimiento',
            'description' => 'Descripción',
            'notes' => 'Notas',
            'recipient_id' => 'Cliente',
            'items' => 'Líneas de Factura',
        ];
    }
}
