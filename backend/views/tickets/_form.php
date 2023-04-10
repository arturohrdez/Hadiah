<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
/*use kartik\date\DatePicker;
use kartik\time\TimePicker;*/
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Tickets */
/* @var $form yii\bootstrap4\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'ticketsForm']]); ?>
<div class="tickets-form card-body row">

    <?php echo $form->field($model, 'status',['options'=>['class'=>'col-12 mt-3']])->dropDownList([ 'A' => 'APARTADO', 'P' => 'PAGADO', ], ['prompt' => 'Seleccione una opción']) ?>
    <?php 
        echo $form->field($model, 'date_payment',['options'=>['class'=>'col-12 mt-3']])->widget(DateTimePicker::classname(),[
            'name' => 'date_payment',
            'options' => ['placeholder' => 'Fecha de pago'],
            'convertFormat' => true,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-M-dd H:i:s',
                'todayHighlight' => true
            ]
        ]);
    ?>
</div>
<div class=" card-footer" align="right">
    <?php echo  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("ticketsForm")']) ?>
    <?php echo Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
/*$(function(e){
    $(".field-tickets-date_payment").hide();
});

$("#tickets-status").on("change",function(e){
    let option = $(this).val();
    console.log(option);
    if(option == "A" || option == ""){
        $("#tickets-date_payment").val("");
        $(".field-tickets-date_payment").hide();
    }else{
        $(".field-tickets-date_payment").show();
    }
});*/
JS;
$this->registerJs($script);
?>


