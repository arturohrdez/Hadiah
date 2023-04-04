<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Punto de Venta';
$this->params['breadcrumbs'][] = $this->title;

echo newerton\fancybox3\FancyBox::widget([
    'target' => '.data-fancybox-modal',
    'config' => [
		'clickSlide'   => false,
		'clickOutside' => false,
    ]
]);
?>

<div class="container-fluid">
    <div class="loading text-center"></div>
    <div id="divEditForm" class="col-lg-8 col-12 offset-lg-2">
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
    									<div id="ticket_e_m" class="col-12 text-center" style="display: none;">
											<div class="alert alert-danger ">
												<strong>BOLETO NO DISPONIBLE</strong>
											</div>
										</div>
	    								<div class="col-12 text-center">
											<?php echo  Html::input('number','ticket_serarch',null, $options=['class'=>'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'id'=>'ticket_s','placeholder'=>'BUSCAR BOLETO','autocomplete'=>'off']) ?>
										</div>
										<div class="col-12 text-center">
											<?php echo  Html::button("¡LO QUIERO!", ['id' => 'btn_addticket','class'=>'btn btn-warning mt-2','style'=>'font-weight: bold; display: none;']); ?>
										</div>
									</div>
									<div id="div_selected" class="row pt-3 pb-2 bg-black" style="display: none;">
										<div id="div_options" class="col-12 text-white text-center">
											<p class="fs-3 text-warning">
												<span class="n_t">0</span> - Boletos Seleccionados
											</p>
											<p class="t_opt"><button class='btn_ticketDel'></button></p>
											<p class="fs-5 text-warning">
												Para eliminar haz clic en el boleto.
											</p>

											<div id="load_tickets" class="col-12" style="display: none;">
												<div class="spinner-border text-danger" role="status"><span class="visually-hidden"></span></div>
											</div>

											<div id="div_oportunities" class="col-12" style="display: none;"></div>
											<div class="row mt-3" style="text-align: center;">
												<div class="col-12">
													<button id="btnSend" class="btn btn-success bg-gradient pl-5 pr-5 data-fancybox-modal" data-type="ajax" data-src="<?php echo Url::to(['tickets/pagar']) ?>" data-touch="false" style="display: none;">
														PAGAR BOLETO(S)
													</button>
												</div>
											</div>
											
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
$URL_tickets = Url::to(['tickets/createtickets']);
$URL_searcht = Url::to(['tickets/searchticket']);
$URL_remove = Url::to(['tickets/ticketremove']);
?>

<script type="text/javascript">
	function ticketRemove(t){
		var url_r = "<?php echo $URL_remove ?>";
		$.ajax({
			url: url_r,
			type: 'POST',
			data: {"tn":t},
			beforeSend: function(data){
				//$(".btn_ticket").attr("disabled",true);
				//$(".btn_ticketDel").attr("disabled",true);
				$("#btnSend").hide();
				$("#load_tickets").show();
			},
			success: function(response) {
				if(response.status == true){
					let elements = Object.keys(response.tickets_play);
					let n_t = elements.length;
					$(".n_t").text(n_t);

					if(n_t == 0){
						$("#div_selected").hide();
					}//end if
					$("#t_"+t).remove();
					$("#t_n_"+t).remove();
				}//end if

				//$(".btn_ticket").attr("disabled",false);
				$(".btn_ticketDel").attr("disabled",false);
				$("#load_tickets").hide();
				$("#btnSend").show();
	        },
	        error: function() {
	            console.log('Error occured');
	        }
		});
	}//end function
</script>

<?php
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
					$.ajax({
						url: '{$URL_tickets}',
						type: 'GET',
						data: {"id": rifa_id},
					})
					.always(function() {
						console.log("complete");
					});
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
					$("#div_selected").hide();

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
					$("#ticket_e_m").hide();
					$("#btnSend").hide();
					$("#btn_addticket").attr("disabled",true);
					$("#btn_addticket").html("Buscando Boleto..");
				},
				success: function(response) {
					$("#btn_addticket").html("¡LO QUIERO!");
					$("#btn_addticket").attr("disabled",false);
					$("#ticket_s").val('');

					if(response.status == true){
						//Tickets Count
						let elements = Object.keys(response.tickets_play);
						let n_t = elements.length;
						$(".n_t").text(n_t);

						//Tickets selected
						let t_selectBtn = "";
						for (var i = n_t-1; i >= 0; i--) {
							t_selectBtn = t_selectBtn + '<button id="t_'+elements[i]+'" class="btn_ticketDel btn btn-danger ml-2" type="button" onclick="ticketRemove(`'+elements[i]+'`)">'+elements[i]+'</button>';
						}//end foreach
						$(".t_opt").html(t_selectBtn);

						if(response.promos == true){
							let oportunities = Object.entries(response.tickets_play);
							let ticket_ran       = [];
							let div_oportunities = '<div id="lbl_oportunities">Oportunidades:</div>';
							oportunities.forEach(([key, value]) => {
								div_oportunities += "<div id='t_n_"+key+"'>"+key+" [";
								for (var i = value.length - 1; i >= 0; i--) {

									if(i < value.length-1){
										div_oportunities += ",";
									}
									div_oportunities += value[i];

									ticket_ran.push(value[i]);
								}//end foreach
								div_oportunities += "] </div>";
							});

							//tickets_randoms
							$("#div_oportunities").html(div_oportunities);
							$("#div_oportunities").show();
						}//end if

						//Show Div Selected
						$("#div_selected").show();
						$("#btnSend").show();
					}else{
						$("#btnSend").show();
						$("#btn_addticket").hide();
						$("#ticket_e_m").show();
					}//end if
				}
			});
		}//end if

	});
JS;
$this->registerJs($script);
?>