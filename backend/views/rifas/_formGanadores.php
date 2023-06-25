<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Rifas */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<?php $formPM = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'ganadoresForm']]); ?>
<div class="rifas-form card-body row">
	<div class="col-12">
		<div id="divPM">
	        <h2>Asignar Ganador</h2>
			<?= $formPM->field($modelPM, 'rifa_id')->hiddenInput(['option' => 'value'])->label(false); ?>

			<?= $formPM->field($modelPM, 'ticket_id',['options'=>['class'=>'col-12 mt-3','style'=>'']])
				->widget(Select2::classname(),[
					'name'          => 'ticket_id', 
					'data'          => ArrayHelper::map($modelTickets, 'id', 'ticket'),
					'options'       => ['placeholder' => 'Seleccione una opción'],
					'pluginOptions' => [
						'allowClear'    => true,
					],
				])
				->label('Número de ticket');
			?>

			<div id="loadSearchTicket" class="text-center" style="display: none;">
				<div class="spinner-border text-danger mt-3" role="status"><span class="visually-hidden"></span></div>
			</div>

			<div id="ticketDetailPM" class="text-center" style="display: none;">
				<table id="table_ticketDetailPM" class="table table-light table-bordered">
					<thead>
						<tr>
							<th scope="col">Folio</th>
					      	<th scope="col">Ticket</th>
					      	<th scope="col">Nombre Completo</th>
					      	<th scope="col">Estado</th>
					      	<th scope="col">Teléfono</th>
					      	<th scope="col">Transacción/Referencia</th>
					      	<th scope="col">Fecha Pago</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<tr>
					  		<th class="text-center t_folio" scope="row">0</th>
					  		<td class="text-center t_ticket">null</td>
					  		<td class="text-center t_name">null</td>
					  		<td class="text-center t_state">null</td>
					  		<td class="text-center t_phone">null</td>
					  		<td class="text-center t_transaction">null</td>
					  		<td class="text-center t_payment">null</td>
					  	</tr>
					  </tbody>
				</table>
			</div>

			<?= $formPM->field($modelPM, 'description',['options'=>['class'=>'col-12 mt-3']])->textarea(['option' => 'value']); ?>
		</div>
	</div>
</div>
<div class=" card-footer" align="right">
	<?=  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("ganadoresForm")']) ?>
    <?= Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$URL_ticketdetail   = Url::to(['rifas/ticketdetail']);
$script = <<< JS
	$("#ganadores-ticket_id").on("change",function(e){
		let ticket_id = $(this).val();
		if(ticket_id == ""){
			//$("#ticketDetailPM").html("");
			$("#ticketDetailPM").hide("");
		}else{
			$.ajax({
				url     : "{$URL_ticketdetail}",
				type    : 'GET',
				dataType: 'json',
				data    : {"id":ticket_id},
				beforeSend: function(data){
					$("#ticketDetailPM").hide();
					$("#loadSearchTicket").show();
				},
				success: function(response) {
					$(".t_ticket").text(response.ticket);
					$(".t_folio").text(response.folio);
					$(".t_phone").text(response.phone);
					$(".t_name").text(response.name+" "+response.lastname);
					$(".t_state").text(response.state);
					$(".t_payment").text(response.date_payment);
					$(".t_transaction").text(response.transaction_number);
					$("#loadSearchTicket").hide();
					$("#ticketDetailPM").show();

				}
			});
		}//end if
	});
JS;
$this->registerJs($script);
?>