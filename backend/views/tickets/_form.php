<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Tickets */
/* @var $form yii\bootstrap4\ActiveForm */
?>


    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'ticketsForm']]); ?>

<div class="tickets-form card-body">
    <?= $form->field($model, 'rifa_id')->textInput() ?>

    <?= $form->field($model, 'ticket')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'date_end')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

</div>
<div class=" card-footer" align="right">
	<?=  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("ticketsForm")']) ?>
    <?= Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>

    <?php ActiveForm::end(); ?>

