<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="loading text-center"></div>
    <div id="divEditForm" class="col-8 offset-lg-2">
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
    												INGRESE UN BOLETO ENTRE <br> <span id="init" class="right badge badge-info"></span> <span class="right badge badge-info">Y</span> <span id="end" class="right badge badge-info"></span>
    											</h5>
    										</div>
    									</div>
    								</div>
    								<div class="row bg-primary pt-3 pb-3">
	    								<div class="col-12 text-center">
											<?php echo  Html::input('number','ticket_serarch',null, $options=['class'=>'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'id'=>'ticket_s','placeholder'=>'BUSCAR BOLETO','autocomplete'=>'off']) ?>
										</div>
										<div class="col-12 text-center">
											<?php echo  Html::button("¡LO QUIERO!", ['id' => 'btn_addticket','class'=>'btn btn-warning mt-2','style'=>'font-weight: bold; display: none;']); ?>
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
$URL_rifas   = Url::to(['rifas/view']);
$URL_searcht = Url::to(['tickets/searchticket']);
$script = <<< JS
	/*$(function(e){
		alert("esta entrando");
	});*/

	//Format Number
	$("#ticket_s").on("keyup change",function(e){
		let d = $("#t_digit").val();
		let n = $(this).val();
		let i = n.replace(/^(0+)/g, '');
		let f = "";
		let a = parseFloat(n);

		if(n != "" && a > 0){
			f = i.padStart(d,"0");
			$(this).val(f);
			$("#btn_addticket").show();
		}else{
			$("#btn_addticket").hide();
		}//end if
	});

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

					let i = $("#t_init").val();
					let n = $("#t_digit").val();
					let f = i.padStart(n,"0");
					
					$("#init").html(f);
					$("#end").text($("#t_end").val());
					$("#ticketsPlay").show();
				}
			});
		}
		//alert("entra -->"+rifa_id);
	});

	$("#btn_addticket").on("click",function(e){
		let tn_s    = $("#ticket_s").val();
		let max     = $("#t_end").val();
		let rifa_id = $("#rifa_id").val();
		if(tn_s != ""){
			$.ajax({
				url : "{$URL_searcht}",
				type: 'POST',
				data: {"id":rifa_id,"tn_s":tn_s,"max":max},
				beforeSend: function(data){
					//$("#ticket_s_m").hide();
					//$("#ticket_e_m").hide();
					$("#btn_addticket").attr("disabled",true);
					$("#btn_addticket").html("Buscando Boleto..");
				},
				success: function(response) {
					$("#btn_addticket").html("¡LO QUIERO!");
					$("#btn_addticket").attr("disabled",false);
					$("#ticket_s").val('');
					console.log(response);

					/*if(response.status == true){
						$("#tn_"+tn_s).trigger('click');
					}else{
						$("#ticket_e_m").show();
					}//end if
					$("#btn_addticket").hide();
					$("#ticket_s").val('');*/
				}
			});
		}//end if

	});
JS;
$this->registerJs($script);
?>