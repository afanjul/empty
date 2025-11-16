<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Account $model */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('Actualizar', ['update', 'id' => $model->tenant_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->tenant_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Está seguro de eliminar esta cuenta?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
        'attributes' => [
            'tenant_id',
            'company_name',
            'tax_id',
            'email:email',
            'phone',
            'address',
            'city',
            'state',
            'postal_code',
            'country',
            [
                'attribute' => 'status',
                'value' => $model->status == 1 ? 'Activo' : 'Inactivo',
            ],
            'currency',
            'timezone',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
