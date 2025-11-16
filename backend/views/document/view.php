<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Document $model */

$this->title = 'Documento #' . $model->document_number;
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?php if ($model->canBeEdited()): ?>
                <?= Html::a('Actualizar', ['update', 'id' => $model->document_id], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->document_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Está seguro de eliminar este documento?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
        'attributes' => [
            'document_id',
            'document_number',
            [
                'attribute' => 'document_type_id',
                'value' => match($model->document_type_id) {
                    1 => 'Factura',
                    2 => 'Ticket',
                    3 => 'Nota de Crédito',
                    4 => 'Pedido',
                    5 => 'Proforma',
                    default => 'Desconocido',
                },
            ],
            [
                'attribute' => 'status',
                'value' => $model->getStatusLabel(),
            ],
            'issue_date:date',
            'due_date:date',
            'description',
            'recipient_name',
            'recipient_tax_id',
            [
                'attribute' => 'subtotal_amount',
                'format' => ['currency', 'EUR'],
            ],
            [
                'attribute' => 'discount_amount',
                'format' => ['currency', 'EUR'],
            ],
            [
                'attribute' => 'tax_amount',
                'format' => ['currency', 'EUR'],
            ],
            [
                'attribute' => 'total_amount',
                'format' => ['currency', 'EUR'],
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
