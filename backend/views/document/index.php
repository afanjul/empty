<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Crear Documento', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'document_id',
            'document_number',
            [
                'attribute' => 'document_type_id',
                'value' => function($model) {
                    return match($model->document_type_id) {
                        1 => 'Factura',
                        2 => 'Ticket',
                        3 => 'Nota de Crédito',
                        4 => 'Pedido',
                        5 => 'Proforma',
                        default => 'Desconocido',
                    };
                },
            ],
            'recipient_name',
            [
                'attribute' => 'issue_date',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'total_amount',
                'format' => ['currency', 'EUR'],
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusLabel();
                },
            ],

            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>
