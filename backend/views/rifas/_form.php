<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Rifas */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'rifasForm']]); ?>

<div class="rifas-form card-body row">
    <?= $form->field($model, 'name',['options'=>['class'=>'col-sm-12 mt-3']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'terms',['options'=>['class'=>' col-lg-6 col-sm-12 mt-3']])->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'ticket_init',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->textInput() ?>
    <?= $form->field($model, 'ticket_end',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->textInput() ?>

    
    <?= $form->field($model, 'date_init',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3','style'=>'float: left;']])->widget(DatePicker::classname(),[
            'name' => 'date_init', 
            'value' => date('d-M-Y'),
            'options' => ['placeholder' => 'Seleccione la fecha de inicio'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-M-yyyy',
                'todayHighlight' => true
            ]
        ])
    ?>
    <?= $form->field($model, 'main_image',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->dropDownList([ '1' => 'Activo', '0' => 'Inactivo', ], ['prompt' => 'Seleccione una opción'])?>   
</div>

<div class="clearfix"></div>
<hr>
<div class="promos-form card-body row">
    <div class="col-12">
        <h2>Promoción</h2>
    </div>
    <?= $form->field($modelPromos, 'id')->hiddenInput(['option' => 'value'])->label(false); ?>
    <?= $form->field($modelPromos, 'rifa_id')->hiddenInput(['option' => 'value'])->label(false); ?>
    <?= $form->field($modelPromos, 'get_ticket',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->textInput(['option' => 'value']); ?>
    <?= $form->field($modelPromos, 'buy_ticket',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->textInput(['option' => 'value']); ?>
</div>

<div class=" card-footer" align="right">
	<?=  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("rifasForm")']) ?>
    <?= Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>

    <?php ActiveForm::end(); ?>

