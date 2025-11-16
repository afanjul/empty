<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\UserForm $model */

$this->title = 'Actualizar Usuario: ' . $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getFullName(), 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
