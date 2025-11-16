<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\ContactForm $model */

$this->title = 'Actualizar Contacto: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->contact_id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="contact-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
