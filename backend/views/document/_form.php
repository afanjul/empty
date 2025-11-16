<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Contact;
use common\models\Document;

/** @var yii\web\View $this */
/** @var backend\models\DocumentForm $model */
/** @var yii\bootstrap5\ActiveForm $form */

// Get list of contacts for dropdown
$contacts = ArrayHelper::map(
    Contact::find()->where(['deleted_at' => null])->orderBy(['name' => SORT_ASC])->all(),
    'contact_id',
    'name'
);
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'document_type_id')->dropDownList([
                Document::TYPE_INVOICE => 'Factura',
                Document::TYPE_SALES_RECEIPT => 'Ticket',
                Document::TYPE_CREDIT_NOTE => 'Nota de Crédito',
                Document::TYPE_SALES_ORDER => 'Pedido',
                Document::TYPE_PROFORMA => 'Proforma',
            ], ['prompt' => 'Seleccione un tipo']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList([
                Document::STATUS_DRAFT => 'Borrador',
                Document::STATUS_APPROVED => 'Aprobada',
                Document::STATUS_SENT => 'Enviada',
                Document::STATUS_PARTIALLY_PAID => 'Parcialmente Pagada',
                Document::STATUS_PAID => 'Pagada',
                Document::STATUS_CANCELLED => 'Cancelada',
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'document_number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'issue_date')->input('date') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'due_date')->input('date') ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <h4 class="mt-4">Información del Cliente</h4>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'recipient_id')->dropDownList($contacts, ['prompt' => 'Seleccione un contacto']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'recipient_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'recipient_tax_id')->textInput(['maxlength' => true]) ?>

    <h4 class="mt-4">Importes</h4>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'subtotal_amount')->textInput(['type' => 'number', 'step' => '0.01']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'discount_amount')->textInput(['type' => 'number', 'step' => '0.01']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'tax_amount')->textInput(['type' => 'number', 'step' => '0.01']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'total_amount')->textInput(['type' => 'number', 'step' => '0.01']) ?>
        </div>
    </div>

    <?= $form->field($model, 'notes')->textarea(['rows' => 4]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
