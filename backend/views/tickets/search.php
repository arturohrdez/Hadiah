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

                                <div id="listTickets" class="text-center mt-2" style="display: none;">
                                    <?php
                                        echo Select2::widget([
                                            'id'            => 'tickets_number',
                                            'name'          => 'tickets_number',
                                            'data'          => [],
                                            'options'       => ['placeholder' => '--Seleccione una opción--'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                            ],
                                        ]);
                                    ?>
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
$URL_rifas       = Url::to(['rifas/view']);
$URL_listtickets = Url::to(['tickets/listtickets']);
//$URL_tickets = Url::to(['tickets/createtickets']);
//$URL_searcht = Url::to(['tickets/searchticket']);
//$URL_remove = Url::to(['tickets/ticketremove']);
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
		}else{
			$.ajax({
				url     : "{$URL_rifas}",
				type    : 'GET',
				dataType: 'HTML',
				data    : {"id":rifa_id,"sales":true},
				beforeSend: function(data){
					$("#rifaDetail").show();
					$("#rifaDetail").html('<div class="spinner-border text-danger mt-3" role="status"><span class="visually-hidden"></span></div>');
					//$("#listTickets").show();
				},
				success: function(response) {
					$("#rifaDetail").html(response);
				},
                complete: function(){
                    $.ajax({
                        url     : "{$URL_listtickets}",
                        type    : 'GET',
                        dataType: 'HTML',
                        data    : {"rifa_id":rifa_id},
                        beforeSend: function(data){},
                        success: function(response) {},
                    });
                    //console.log(response);
                    //alert("entra");
                }
			});
		}
		//alert("entra -->"+rifa_id);
	});

JS;
$this->registerJs($script);
?>