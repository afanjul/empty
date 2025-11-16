<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('Actualizar', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->user_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Está seguro de eliminar este usuario?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
        'attributes' => [
            'user_id',
            'email:email',
            'first_name',
            'last_name',
            [
                'attribute' => 'is_superadmin',
                'value' => $model->is_superadmin ? 'Sí' : 'No',
            ],
            [
                'attribute' => 'is_active',
                'value' => $model->is_active ? 'Activo' : 'Inactivo',
            ],
            'last_login_at:datetime',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
