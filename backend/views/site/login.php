<?php

/** @var yii\web\View $this */
/** @var backend\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>

<div class="site-login">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

                    <p class="text-center text-muted mb-4">Por favor complete los siguientes campos para ingresar:</p>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                        ],
                    ]); ?>

                        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'correo@ejemplo.com']) ?>

                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => '••••••••']) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
                        ]) ?>

                        <div class="form-group mt-4">
                            <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>

                    <div class="text-center mt-3">
                        <small class="text-muted">¿Olvidó su contraseña? Contacte al administrador.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.site-login {
    margin-top: 5rem;
}
.card {
    border: none;
    border-radius: 10px;
}
</style>
