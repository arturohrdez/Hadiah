<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Rifas */
/* @var $form yii\bootstrap4\ActiveForm */
?>


    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'rifasForm']]); ?>

<div class="rifas-form card-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'terms')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'opportunities')->textInput() ?>

    <?= $form->field($model, 'date_init')->textInput() ?>

    <?= $form->field($model, 'main_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

</div>
<div class=" card-footer" align="right">
	<?=  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("rifasForm")']) ?>
    <?= Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>

    <?php ActiveForm::end(); ?>

