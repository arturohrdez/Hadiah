<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Buscador de tickets';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="container-fluid">
    <div class="loading text-center"></div>
    <div id="divEditForm" class="col-lg-8 col-12 offset-lg-2">
    	<div class="tickets-sales">
    		<div class="row-fluid">
    			<div class="col-sm-12">
    				<div class="card card-danger">
    					<div class="card-header">
    						<h1 class="card-title"><strong><i class="fas fa-search"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></strong></h1>
    						<!-- <button type="button" class="btn close text-white" onclick='closeForm("ticketsForm")'>×</button> -->
    					</div>
    					<div class="col-12 pt-3">
    						<div class="tickets-form card-body">
    							<?php echo Html::label("RIFAS", $for = 'rifa_id', ['class' => 'form-label']); ?>
    							<?php
    								echo Select2::widget([
    									'id'=>'rifa_id',
									    'name' => 'rifa_id',
									    'data' => ArrayHelper::map($modelRifas, 'id', 'name'),
									    'options' => ['placeholder' => '--Seleccione una opción--'],
									    'pluginOptions' => [
									        'allowClear' => true,
									    ],
									]);
    							?>
    							<div id="rifaDetail" class="text-center" style="display: none;">
    								<div></div>
    							</div>

                                <div id="divTicketSearch" class="text-center mt-2" style="display: none;">
                                	<div class="row bg-gradient-info">
    									<div class="col-12 fs-1 text-center text-white p-2">
    										<div class="alert font-weight-bold">
    											<h5>
    												INGRESE UN BOLETO ENTRE <br> <span id="init" class="right badge badge-danger"></span> <span class="right badge badge-danger">Y</span> <span id="end" class="right badge badge-danger"></span>
    											</h5>
    										</div>
    									</div>
    								</div>
                                	<div class="row">
                                		<div class="col-12">
                                			<?php echo  Html::input('number','ticket_search',null, $options=['class'=>'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'id'=>'ticket_s','placeholder'=>'NÚMERO DE BOLETO','autocomplete'=>'off']) ?>
                                		</div>
                                	</div>
                                	<div class="row"> 
                                		<div class="col-12">
											<?php echo  Html::button(" <i class='fas fa-search'></i> BUSCAR", ['id' => 'btn_searchticket','class'=>'btn btn-warning mt-2','style'=>'font-weight: bold; display: none;']); ?>
										</div>
                                	</div>
                                </div>
    						</div>
    						<div class=" card-footer" align="right">
                                &nbsp;
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>

<?php 
$URL_rifas        = Url::to(['rifas/view']);
$URL_searchTicket = Url::to(['rifas/searchticket']);
?>

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
			$("#btn_searchticket").show();
		}else{
			$("#btn_searchticket").hide();
		}//end if
	});

	$("#rifa_id").on("change",function(e){
		let rifa_id = $(this).val();
		if(rifa_id == ""){
			$("#rifaDetail").html('');
			$("#rifaDetail").hide('');
		}else{
			$.ajax({
				url     : "{$URL_rifas}",
				type    : 'GET',
				dataType: 'HTML',
				data    : {"id":rifa_id,"sales":true},
				beforeSend: function(data){
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
					$("#divTicketSearch").show();
				}
			});
		}
		//alert("entra -->"+rifa_id);
	});

	$("#btn_searchticket").on("click",function(){
		let tn_s    = $("#ticket_s").val();
		let max     = $("#t_end").val();
		let rifa_id = $("#rifa_id").val();

		if(tn_s != ""){
			if(tn_s > max){
				$.fancybox.open({
		            type: 'html',
		            content: '<div class="row"><div clas="col-12"><div class="alert alert-danger">El número de boleto es mayor a '+max+'</div></div></div>',
		            autoSize: true,
		        });
				return false;
			}//end if

			$.ajax({
				url : "{$URL_searchTicket}",
				type: 'POST',
				dataType: 'HTML',
				data: {"id":rifa_id,"tn_s":tn_s},
				beforeSend: function(data){},
				success: function(response) {
					$.fancybox.open({
					    // Otras configuraciones...
					    type: 'html',
					    content: response,
					    bgColor: '#ff0000'
					});
				}
			});


			console.log(max);
			console.log(tn_s);
		}//end if

		/*$.fancybox.open({
            // Configuración de FancyBox
            // Por ejemplo, puedes especificar el contenido que se mostrará en la ventana emergente
            type: 'html',
            content: '<div clas="col-12"><h2>Contenido de FancyBox</h2></div>',
            autoSize: true,
        });*/
	});

JS;
$this->registerJs($script);
?>