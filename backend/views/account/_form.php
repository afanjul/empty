<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\AccountForm $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'tax_id')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList([1 => 'Activo', 0 => 'Inactivo']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
