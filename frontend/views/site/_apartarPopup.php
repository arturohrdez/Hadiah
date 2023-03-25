<?php
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$ticket_n = count(Yii::$app->session->get('tickets_play_all')); 
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
?>
<div id="modal" class="col-lg-7 col-md-9 col-sm-9">
	<div class="container">
		<div class="col-12 text-center fw-bold">
			<div class="fs-3">LLENA TUS DATOS Y DA CLICK EN APARTAR</div>
		</div>
		<div class="col-12 text-center mt-2">
			<div class="text-danger fs-5 fw-bold">
				<?php echo $ticket_n; ?> - BOLETO(S) SELECCIONADO(S)
			</div>
		</div>
		<div class="col-12 mt-3">
			<?php $form = ActiveForm::begin(['id' => 'ticketForm']); ?>
			<?php echo $form->field($modelTicket,'phone')->textInput(['placeholder'=>'TELÉFONO - WHATSAPP (10 digítos)'])->label(false); ?>
			<?php echo $form->field($modelTicket,'name')->textInput(['placeholder'=>'NOMBRE(S)'])->label(false); ?>
			<?php echo $form->field($modelTicket,'lastname')->textInput(['placeholder'=>'APELLIDOS'])->label(false); ?>
			<?php echo $form->field($modelTicket, 'state')->dropDownList($states, ['placeholder' => 'ESTADO'])->label(false); ?>
			<div class="col-12 text-center text-success fw-bold">
				¡Al finalizar serás redirigido a whatsapp para enviar la información de tu boleto!
			</div>
			<div class="col-12 text-center text-danger fw-bold mt-3">
				Tu boleto sólo dura 24 horas apartado
			</div>
			<div class="form-group text-center mt-3">
				<?php echo  Html::submitButton('<i class="bi bi-check-circle-fill"></i>  APARTAR ', ['class' => 'btn pl-5 pr-5 btn-success']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	/*$(function(e){
		$("#arr_tickets").val($("#tn_sel").val());
	});*/
</script>
