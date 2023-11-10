<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ganadores */
/* @var $form yii\bootstrap4\ActiveForm */
?>


    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'ganadoresForm']]); ?>

<div class="ganadores-form card-body">
    <?= $form->field($model, 'rifa_id')->textInput() ?>

    <?= $form->field($model, 'ticket_id')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

</div>
<div class=" card-footer" align="right">
	<?=  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("ganadoresForm")']) ?>
    <?= Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>

    <?php ActiveForm::end(); ?>

