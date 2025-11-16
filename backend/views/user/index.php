<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'email:email',
            'first_name',
            'last_name',
            [
                'attribute' => 'is_superadmin',
                'value' => function($model) {
                    return $model->is_superadmin ? 'Sí' : 'No';
                },
            ],
            [
                'attribute' => 'is_active',
                'value' => function($model) {
                    return $model->is_active ? 'Activo' : 'Inactivo';
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
