<?php

namespace common\requests;

use yii\base\Model;

/**
 * CreateInvoiceRequest - Request validator para crear facturas
 */
class CreateInvoiceRequest extends Model
{
    public $document_type_id;
    public $issue_date;
    public $due_date;
    public $description;
    public $notes;
    public $recipient_id;
    public $currency_id;
    public $items;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['document_type_id', 'issue_date', 'recipient_id'], 'required'],
            [['document_type_id', 'recipient_id'], 'integer'],
            [['issue_date', 'due_date'], 'date', 'format' => 'php:Y-m-d'],
            [['description'], 'string', 'max' => 500],
            [['notes'], 'string'],
            [['currency_id'], 'string', 'length' => 3],
            [['items'], 'required'],
            [['items'], 'validateItems'],
        ];
    }

    /**
     * Valida las líneas de factura
     */
    public function validateItems($attribute, $params)
    {
        if (!is_array($this->items) || empty($this->items)) {
            $this->addError($attribute, 'Debe incluir al menos una línea de factura');
            return;
        }

        foreach ($this->items as $index => $item) {
            if (!isset($item['name']) || empty($item['name'])) {
                $this->addError($attribute, "La línea {$index} debe tener un nombre");
            }

            if (!isset($item['quantity']) || $item['quantity'] <= 0) {
                $this->addError($attribute, "La línea {$index} debe tener una cantidad válida");
            }

            if (!isset($item['unit_price']) || $item['unit_price'] < 0) {
                $this->addError($attribute, "La línea {$index} debe tener un precio válido");
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'document_type_id' => 'Tipo de Documento',
            'issue_date' => 'Fecha de Emisión',
            'due_date' => 'Fecha de Vencimiento',
            'description' => 'Descripción',
            'notes' => 'Notas',
            'recipient_id' => 'Cliente',
            'currency_id' => 'Moneda',
            'items' => 'Líneas de Factura',
        ];
    }
}
