<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Contactos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Crear Contacto', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'contact_id',
            'name',
            'email:email',
            'phone',
            'tax_id',
            [
                'attribute' => 'contact_type',
                'value' => function($model) {
                    return match($model->contact_type) {
                        1 => 'Cliente',
                        2 => 'Proveedor',
                        3 => 'Ambos',
                        default => 'Desconocido',
                    };
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y H:i'],
            ],

            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>
