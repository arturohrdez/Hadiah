<section id="breadcrumbs" class="breadcrumbs">
	<div class="container">
		<div class="d-flex justify-content-center align-items-center">
			<h1 class="fw-bold">INFORMACIÓN DE TU BOLETO</h1>
		</div>
	</div>
</section>

<section class="pricing">
	<div class="container" data-aos="fade-up">
		<div class="row">
			<?php 
			if(!$status){
				?>
				<div class="col-lg-12 entries text-center">
					<div class="alert">
						<h1 class="text-center text-danger fs-1">Boleto <?php echo $ticket; ?> no vendido</h1>
					</div>
					<div class="mt-5">
						<a class="btn btn-primary" href="/">Ir al Inicio</a>
					</div>
				</div>
				<?php
			}else{//end if
			?>
			<div class="d-flex justify-content-center">
				<div class="col-md-12 col-lg-7 mt-md-0">
					<div class="box">
						<h3>&nbsp;</h3>
						<?php 
						if($modelTicket->status == "P"){
						?>
						<span class="advanced">PAGADO</span>
						<?php 
						}//end if
						?>

						<div class="row pt-4" style="border-top: 5px dashed black;">
							<div class="col-md-4 col-12 fw-bold">BOLETO :</div>
							<div class="col-md-8 col-12 fw-bold text-danger"><?php echo $modelTicket->ticket; ?></div>
						</div>
						<?php 
						if(!empty($oportunidades)){
							?>
							<div class="row mt-4 pb-4" style="border-bottom: 5px dashed black;">
								<div class="col-md-4 col-12 fw-bold">OPORTUNIDADES :</div>
								<div class="col-md-8 col-12 fw-bold text-danger">
									<?php 
									$op_s = "";
									foreach ($oportunidades as $oportunidad) {
										$op_s .= "{$oportunidad->ticket},";
									}//end foreach
									echo "(".trim($op_s, ',').")";
									?>
								</div>
							</div>
							<?php
						}//end if
						?>
						<div class="row mt-4">
							<div class="col-md-4 col-12 fw-bold">SORTEO :</div>
							<div class="col-md-8 col-12 fw-bold text-danger"><?php echo strtoupper($model->name); ?></div>
						</div>
						<div class="row mt-4">
							<div class="col-md-4 col-12 fw-bold">NOMBRE :</div>
							<div class="col-md-8 col-12 fw-bold text-danger"><?php echo strtoupper($modelTicket->name); ?></div>
						</div>
						<div class="row mt-4">
							<div class="col-md-4 col-12 fw-bold">APELLIDO(S) :</div>
							<div class="col-md-8 col-12 fw-bold text-danger"><?php echo strtoupper($modelTicket->lastname); ?></div>
						</div>
						<div class="row mt-4">
							<div class="col-md-4 col-12 fw-bold">ESTADO :</div>
							<div class="col-md-8 col-12 fw-bold text-danger"><?php echo strtoupper($modelTicket->state); ?></div>
						</div>
						<div class="row mt-4">
							<div class="col-md-4 col-12 fw-bold">PAGADO :</div>
							<div class="col-md-8 col-12 fw-bold text-danger">
								<?php 
									if($modelTicket->status == "P"){
										echo "PAGADO";
									}else{
										echo "NO PAGADO";
									}//end if
								?>		
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-4 col-12 fw-bold">COMPRA :</div>
							<div class="col-md-8 col-12 fw-bold text-danger">
								<?php 
									if($modelTicket->status == "P"){
										echo $modelTicket->date_payment;
									}else{
										echo "-----";
									}//end if
								?>		
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-12">
								<img src="<?php echo Yii::$app->params["baseUrlBack"].$model->main_image; ?>" alt="" class="img-fluid">
							</div>
						</div>
						<div class="btn-wrap text-danger fw-bold">
							¡MUCHA SUERTE!
						</div>
					</div>
				</div>
			</div>
			
			<?php 
			}//end if
			?>
		</div>
	</div>
</section>
