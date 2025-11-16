<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DocumentForm $model */

$this->title = 'Actualizar Documento: ' . $model->document_number;
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->document_number, 'url' => ['view', 'id' => $model->document_id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
