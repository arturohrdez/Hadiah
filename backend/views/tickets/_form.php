<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Tickets */
/* @var $form yii\bootstrap4\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'ticketsForm']]); ?>
<div class="tickets-form card-body">
  
    <?= $form->field($model, 'status',['options'=>['class'=>'col-12']])->dropDownList([ 'A' => 'APARTADO', 'P' => 'PAGADO', ], ['prompt' => 'Seleccione una opción']) ?>
</div>
<div class=" card-footer" align="right">
    <?=  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("ticketsForm")']) ?>
    <?= Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
