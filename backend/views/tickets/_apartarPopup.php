<?php
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$ticket_n = count(Yii::$app->session->get('tickets_play_all_B')); 
$states = [	
	''                    => 'SELECCIONAR UNA OPCIÓN',
	'Aguascalientes'      => 'Aguascalientes',
	'Baja California'     => 'Baja California',
	'Baja California Sur' => 'Baja California Sur',
	'Campeche'            => 'Campeche',
	'Coahuila'            => 'Coahuila',
	'Colima'              => 'Colima',
	'Chiapas'             => 'Chiapas',
	'Chihuahua'           => 'Chihuahua',
	'cdmx'                => 'CDMX',
	'Durango'             => 'Durango',
	'Guanajuato'          => 'Guanajuato',
	'Guerrero'            => 'Guerrero',
	'Hidalgo'             => 'Hidalgo',
	'Jalisco'             => 'Jalisco',
	'Estado de México'    => 'Estado de México',
	'Michoacán'           => 'Michoacán',
	'Morelos'             => 'Morelos',
	'Nayarit'             => 'Nayarit',
	'Nuevo León'          => 'Nuevo León',
	'Oaxaca'              => 'Oaxaca',
	'Puebla'              => 'Puebla',
	'Querétaro'           => 'Querétaro',
	'Quintana'            => 'Quintana Roo',
	'San Luis Potosí'     => 'San Luis Potosí',
	'Sinaloa'             => 'Sinaloa',
	'Sonora'              => 'Sonora',
	'Tabasco'             => 'Tabasco',
	'Tamaulipas'          => 'Tamaulipas',
	'Tlaxcala'            => 'Tlaxcala',
	'Veracruz'            => 'Veracruz',
	'Yucatán'             => 'Yucatán',
	'Zacatecas'           => 'Zacatecas'
];

$state_ = $modelRifa->state;
if($state_ != "all"){
	$states = [$states[$state_] => $states[$state_]];
}
?>
<div id="modal" class="col-lg-4 col-md-9 col-sm-9">
	<div class="container">
		<div class="col-12 text-center fw-bold">
			<h1>LLENA LOS DATOS Y DA CLICK EN PAGAR</h1>
		</div>
		<div class="col-12 text-center mt-2">
			<div class="text-danger fw-bold">
				<h3><?php echo $ticket_n; ?> - BOLETO(S) SELECCIONADO(S)</h3>
			</div>
		</div>
		<div class="col-12 mt-3">
			<?php 
				$form = ActiveForm::begin([
					'id'                     => 'ticketForm',
					'enableClientValidation' => true,
					'enableAjaxValidation'   => false,
					'action' => ['/tickets/pagar'],
				]); 
			?>
			<?php echo $form->field($modelTicket, 'rifa_id')->hiddenInput(['value'=>$modelRifa->id])->label(false); ?>
			<?php echo $form->field($modelTicket,'phone')->textInput(['placeholder'=>'TELÉFONO - WHATSAPP (10 digítos)'])->label(false); ?>
			<?php echo $form->field($modelTicket,'name')->textInput(['placeholder'=>'NOMBRE(S)'])->label(false); ?>
			<?php echo $form->field($modelTicket,'lastname')->textInput(['placeholder'=>'APELLIDOS'])->label(false); ?>
			<?php echo $form->field($modelTicket, 'state')->dropDownList($states, ['placeholder' => 'ESTADO'])->label(false); ?>
			<div id="divBtnA" class="form-group text-center mt-3">
				<?php echo  Html::submitButton('<i class="bi bi-check-circle-fill"></i>  PAGAR ', ['id'=>'btnAparta','class' => 'btn pl-5 pr-5 btn-success']) ?>
			</div>

			<div id="divMsg" class="col-12 text-center text-danger fw-bold mt-3" style="display: none;"></div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>

<?php
$URL_sendwp = Url::to(['tickets/sendwp']);
$script = <<< JS
	$('#ticketForm').on('beforeSubmit', function(e) {
		var form     = $(this);
		var formData = form.serialize();

    	$.ajax({
	        url : form.attr("action"),
	        type: form.attr("method"),
	        data: formData,
	        beforeSend: function(data){
	        	$("#btnAparta").hide();
	        	$("#divBtnA").html('<div class="spinner-border text-success" role="status"><span class="visually-hidden"></span></div>');
	        },
	        success: function (data) {
	        	//console.log(data)
	        	$("#divBtnA").html('').hide();
	        	if(data.status == false){
	        		$("#divMsg").html('<div class="alert alert-danger">Lo sentimos el boleto: <strong>'+data.tickets_duplicados+'</strong> fue seleccionado por alguien más. Por favor intente con otro.</div>');
	        		$("#divMsg").show();
	        	}else if(data.status == true){
	        		$("#divMsg").html('<div class="alert alert-success">¡FELICIDADES! Los Boletos han sido registrados con éxito. <br> ¡POR FAVOR NO CIERRE ESTA VENTANA!.');
	        		$("#divMsg").show();

	        		//
	        		setTimeout(function(e){
		        		$.ajax({
		        			url: "{$URL_sendwp}",
		        			type: "POST",
		        			data: {"id":data.rifaId,"name":data.name,"lastname":data.lastname,"phone":data.phone},
		        			beforeSend: function(data){
		        				$("#divMsg").html('<div class="alert alert-success">Redirigiendo a Whatsapp...</div>');
		        			},
		        			success: function (data) {
		        				//console.log(data);
								window.location.href = data.link;
		        			},
		        		});
					}, 3000);
	        		
	        	}//end if
	        },
	        error: function () {
	            alert("Something went wrong");
	        }
	    });
	}).on('submit', function(e){
	    e.preventDefault();
	});
JS;
$this->registerJs($script);
