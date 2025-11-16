<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AccountForm $model */

$this->title = 'Actualizar Cuenta: ' . $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->company_name, 'url' => ['view', 'id' => $model->tenant_id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
