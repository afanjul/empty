<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Contact $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('Actualizar', ['update', 'id' => $model->contact_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->contact_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Está seguro de eliminar este contacto?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
        'attributes' => [
            'contact_id',
            'name',
            'tax_id',
            'email:email',
            'phone',
            'address',
            'city',
            'state',
            'postal_code',
            'country',
            [
                'attribute' => 'contact_type',
                'value' => match($model->contact_type) {
                    1 => 'Cliente',
                    2 => 'Proveedor',
                    3 => 'Ambos',
                    default => 'Desconocido',
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
