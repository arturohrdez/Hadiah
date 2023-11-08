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
    
    <?= $form->field($model, 'ticket_init',['options'=>['class'=>'col-lg-3 col-sm-12 mt-3']])->textInput() ?>
    <?= $form->field($model, 'ticket_end',['options'=>['class'=>'col-lg-3 col-sm-12 mt-3']])->textInput() ?>
    <!-- <?//=$form->field($model, 'price',['options'=>['class'=>'col-lg-4 col-sm-12 mt-3']])->textInput()->label('Precio por boleto') ?> -->

    <?php 
        $hrs[null] = "Selecciona una opción";
        for ($i=1; $i <=24 ; $i++) { 
            $hrs[$i] = $i;
        }//end for
        echo $form->field($model, 'time_apart',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->dropDownList($hrs)->label('Duración de apartado del boleto (Hrs.)');
    ?>
    
    <?= $form->field($model, 'date_init',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3','style'=>'float: left;']])->widget(DatePicker::classname(),[
            'name' => 'date_init', 
            'value' => date('Y-m-d'),
            'options' => ['placeholder' => 'Seleccione la fecha'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ])
    ?>
    
    <?php 
    /*$presorteos = [];
    for ($i=0; $i <= 10 ; $i++) {
        if($i == 0){
            $presorteos[$i] = "No Aplica";
        }else{
            $presorteos[$i] = $i;
        }//end if
    }//end for*/
    ?>
    <!-- <?//= $form->field($model, 'presorteos',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->dropDownList($presorteos)->label('¿Número de presorteos?'); ?> -->
    <?= $form->field($model, 'state',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->dropDownList(Yii::$app->params['states'], ['prompt' => 'Seleccione una opción'])?>   

    <?= $form->field($model, 'banner',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->dropDownList([ '1' => 'Si', '0' => 'No', ], ['prompt' => 'Seleccione una opción'])->label('¿Mostra en el banner princial?')?>   
    <?= $form->field($model, 'status',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->dropDownList([ '1' => 'EN JUEGO','2' => 'PAUSAR','0' => 'TERMINAR', ], ['prompt' => 'Seleccione una opción'])?>   
    <div class="clearfix"></div>
    <div class="row">
        <?= $form->field($model, 'imagen',['options'=>['class'=>'col-12 mt-3 bg-light']])->fileInput()->label('<div>Imagen: </div> <div class=" alert-warning" style="padding:4px; border-radius: 2px;"><small><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Tamaño de Imagen: 1000px X 1000px (Ancho x Alto)</small></div>',['class'=>'col-12']) ?>
        <div id="preview" class="col-12 mt-3" align="center"></div>
    </div>

    <!-- <?//= $form->field($model, 'main_image',['options'=>['class'=>'col-lg-6 col-sm-12 mt-3']])->textInput(['maxlength' => true]) ?> -->

</div>

<div class="clearfix"></div>
<hr>
<div class="promos-form card-body row">
    <div class="col-12">
        <h2>Oportunidades</h2>
    </div>
    <div class="col-12">
        <div class="alert alert-info">
            Número de oportunidades que el sistema otorgará al usurio, por cada boleto seleccionado. <br>
            <strong>NOTA: Si la rifa no aplica oportunidades el campo debe estar vacío.</strong>
        </div>
    </div>
    <?= $form->field($modelPromos, 'id')->hiddenInput(['option' => 'value'])->label(false); ?>
    <?= $form->field($modelPromos, 'rifa_id')->hiddenInput(['option' => 'value'])->label(false); ?>
    <?= $form->field($modelPromos, 'buy_ticket')->hiddenInput(['value' => '1'])->label(false); ?>
    <?= $form->field($modelPromos, 'get_ticket',['options'=>['class'=>'col-2 mt-3']])->textInput(['option' => 'value']); ?>
    <div id="infoOportunidades" class="col-10 text-center mt-5" style="display: none;">
        <div class="alert alert-warning"> 
            <span class="compraBoleto"></span><span class="oportunidadesBoleto"></span>
        </div>
    </div>
</div>

<div class=" card-footer" align="right">
	<?=  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("rifasForm")']) ?>
    <?= Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
$script = <<< JS

    $(function(e){
        var preview_img = '/$model->main_image';
        image = document.createElement('img');
        image.src = preview_img;
        image.classList.add('img-fluid');
        preview.innerHTML = '';
        preview.append(image);
        //alert(preview_img);
    });

    document.getElementById("rifas-imagen").onchange = function(e) {
        if(e.target.files[0] === undefined){
            document.getElementById('preview').innerHTML = "";
        }else{
            let reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = function(){
                let preview = document.getElementById('preview'),
                    image = document.createElement('img');

                image.src = reader.result;
                image.classList.add('img-fluid');

                preview.innerHTML = '';
                preview.append(image);
            };
        }
    }

    /*$("#promos-buy_ticket").on("keyup",function(e){
        let nt = $(this).val();
        if(nt != ""){
            $(".compraBoleto").text(nt+" Boleto(s) te da ");
            $("#infoOportunidades").show();
        }else{
            $("#infoOportunidades").hide();
        }
    });*/

    $("#promos-get_ticket").on("keyup change",function(e){
        let boleto        = $("#promos-buy_ticket").val();
        let oportunidades = $(this).val();
        if(oportunidades != ""){
            console.log(oportunidades);
            oportunidades = parseInt(oportunidades);
            let nt = parseInt($("#promos-buy_ticket").val());
            let op = nt + oportunidades;
            $(".compraBoleto").text(nt+" Boleto te da ");
            $(".oportunidadesBoleto").text(op + " oportunidades.");
            $("#infoOportunidades").show();
        }else{
            $("#infoOportunidades").hide();
        }
    });
JS;
$this->registerJs($script);

