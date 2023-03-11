<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Categorias */
/* @var $form yii\bootstrap4\ActiveForm */
?>


    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'categoriasForm']]); ?>

<div class="categorias-form card-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'archivo')->fileInput()?>

    <?= $form->field($model, 'status')->textInput() ?>

</div>
<div class=" card-footer" align="right">
	<?=  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("categoriasForm")']) ?>
    <?= Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>

    <?php ActiveForm::end(); ?>

