<?php  
use yii\helpers\Html;

if(is_null($modelT)):
?>	

<style type="text/css">
	.fancy-content{
		background: #454d55 !important;
	}	
</style>

<div class="col-lg-6" style="width: auto;">
	<div class="row">
		<div class="alert alert-danger mt-3">
			<i class="fas fa-exclamation-circle"></i>&nbsp;&nbsp; EL BOLETO <strong>[<?php echo $ticket ?>]</strong> NO HA SIDO APARTADO O VENDIDO.
		</div>
	</div>
</div>
<?php
die();
endif;
?>

<div class="dark-mode">
	<div class="card mt-3">
		<div class="card-header bg-primary">
			BOLETO NÚMERO <strong>[<?php echo $ticket ?>]</strong>
		</div>
		<div class="card-body">
			<div class="row mt-2">
				<div class="col-7 text-bold">Folio :</div>
				<div class="col-5"><?php echo $modelT->folio; ?></div>
			</div>
			<div class="row mt-2">
				<div class="col-7 text-bold">Ticket :</div>
				<div class="col-5"><?php echo $modelT->ticket; ?></div>
			</div>
			<div class="row mt-2">
				<div class="col-7 text-bold">Estatus :</div>
				<div class="col-5"><?php echo $modelT->status == 'A' ? "APARTADO" : "PAGADO"; ?></div>
			</div>
			<div class="row mt-2">
				<div class="col-7 text-bold">Nombre Completo :</div>
				<div class="col-5"><?php echo $modelT->name." ".$modelT->lastname; ?></div>
			</div>
			<div class="row mt-2">
				<div class="col-7 text-bold">Estado :</div>
				<div class="col-5"><?php echo $modelT->state; ?></div>
			</div>
			<div class="row mt-2">
				<div class="col-7 text-bold">Teléfono :</div>
				<div class="col-5"><?php echo $modelT->phone; ?></div>
			</div>
			<div class="row mt-2">
				<div class="col-7 text-bold">Fecha Apartado :</div>
				<div class="col-5"><?php echo is_null($modelT->date) ? "--/--/--" : date("d-m-Y H:i:s",strtotime($modelT->date)); ?></div>
			</div>
			<div class="row mt-2">
				<div class="col-7 text-bold">Transacción/Referencia :</div>
				<div class="col-5"><?php echo $modelT->transaction_number; ?></div>
			</div>
			<div class="row mt-2">
				<div class="col-7 text-bold">Fecha Pago :</div>
				<div class="col-5"><?php echo is_null($modelT->date_payment) ? "--/--/--" : date("d-m-Y H:i:s",strtotime($modelT->date_payment)); ?></div>
			</div>
		</div>
	</div>
</div>

