<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\UserForm $model */
/** @var yii\bootstrap5\ActiveForm $form */

$isNewRecord = $model->isNewRecord;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'is_active')->checkbox() ?>
        </div>
    </div>

    <?php if ($isNewRecord): ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Deje los campos de contraseña vacíos si no desea cambiarla.
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'is_superadmin')->checkbox() ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
