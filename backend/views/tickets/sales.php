<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="loading text-center"></div>
    <div id="divEditForm" class="col-12">
    	<div class="tickets-sales">
    		<div class="row-fluid">
    			<div class="col-sm-12">
    				<div class="card card-danger">
    					<div class="card-header">
    						<h1 class="card-title"><strong><i class="fas fa-cart-arrow-down"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></strong></h1>
    						<!-- <button type="button" class="btn close text-white" onclick='closeForm("ticketsForm")'>×</button> -->
    					</div>
    					<div class="col-12 pt-3">
    						<div class="tickets-form card-body">
    							<?php echo Html::label("RIFAS ACTIVAS", $for = 'rifa_id', ['class' => 'form-label']); ?>
    							<?php
    								echo Html::dropDownList(
    									'rifa_id',
    									$selection = null,
    									ArrayHelper::map($modelRifas,'id','name'),
    									[
    										'id'=>'rifa_id',
    										'class' => 'form-control',
    										'prompt'=>'-- SELECCIONE UNA OPCIÓN --'
    									]);
    							?>
    							<div id="rifaDetail" class="text-center" style="display: none;">
    								<div></div>
    							</div>
    							<div id="ticketsPlay" style="display: none;">
    								<div class="row bg-primary">
    									<div class="col-12 fs-1 text-center text-white p-2">
    										<h2><i class="fas fa-arrow-alt-circle-down"></i> SELECCIONA ABAJO LOS NÚMEROS DE LA SUERTE <i class="fas fa-arrow-alt-circle-down"></i></h2>
    										<div class="alert alert-warning font-weight-bold">
    											<h5>
    												INGRESE UNO O VARIOS BOLETOS "SEPARADOS POR COMAS" ENTRE 0001 Y 89888
    											</h5>
    											<p>
    												Ej. 234,334,223,556,33334
    											</p>
    										</div>
    									</div>
    								</div>
    								<div class="row bg-primary pt-3 pb-3">
	    								<div class="col-lg-9 col-12 text-center">
											<?php echo  Html::input('number','ticket_serarch',null, $options=['class'=>'form-control','id'=>'ticket_s','placeholder'=>'BUSCAR BOLETO','autocomplete'=>'off']) ?>
										</div>
										<div class="col-lg-3 col-12 text-center">
											<?php echo  Html::button("¡LO QUIERO!", ['id' => 'btn_addticket','class'=>'btn btn-warning col-12','style'=>'font-weight: bold; display: block;']); ?>
										</div>
									</div>
    							</div>
    						</div>
    						<div class=" card-footer" align="right">

    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>

<?php 
$URL_rifas = Url::to(['rifas/view']);
$script = <<< JS
	/*$(function(e){
		alert("esta entrando");
	});*/
	$("#rifa_id").on("change",function(e){
		let rifa_id = $(this).val();
		if(rifa_id == ""){
			$("#rifaDetail").html('');
			$("#rifaDetail").hide('');
			$("#ticketsPlay").hide();
			$("#ticket_s").val('');
		}else{
			$.ajax({
				url     : "{$URL_rifas}",
				type    : 'GET',
				dataType: 'HTML',
				data    : {"id":rifa_id,"sales":true},
				beforeSend: function(data){
					$("#ticketsPlay").hide();
					$("#ticket_s").val('');
					$("#rifaDetail").show();
					$("#rifaDetail").html('<div class="spinner-border text-danger mt-3" role="status"><span class="visually-hidden"></span></div>');
				},
				success: function(response) {
					$("#rifaDetail").html(response);
					$("#ticketsPlay").show();
				}
			});
		}
		//alert("entra -->"+rifa_id);
	});
JS;
$this->registerJs($script);
?>