<?php 
use yii\helpers\Html;
?>
<section id="breadcrumbs" class="breadcrumbs">
	<div class="container">
		<div class="d-flex justify-content-between align-items-center">
			<h2><?php echo $model->name; ?></h2>
			<ol>
				<li><a href="/">Home</a></li>
				<li>Comprar Boletos</li>
			</ol>
		</div>
	</div>
</section>

<section id="blog" class="blog">
	<div class="container" data-aos="fade-up">
		<div class="row">
			<div class="col-lg-12 entries">
				<article class="entry">
					<div class="entry-img">
						<img src="<?php echo Yii::$app->params["baseUrlBack"].$model->main_image; ?>" alt="" class="img-fluid">
					</div>
					<h2 class="entry-title fs-1 text-danger">
						<?php echo $model->name; ?>
					</h2>
					<div class="entry-content">
						<blockquote>
							<p class="fs-3">
								<?php 
									$diassemana = ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado"];
									$meses      = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
									echo $diassemana[date('w',strtotime($model->date_init))]." ".date('d',strtotime($model->date_init))." de ".$meses[date('n',strtotime($model->date_init))-1]. " del ".date('Y',strtotime($model->date_init)) ; 
								?>
							</p>
						</blockquote>
						<p>
							<div class="alert alert-warning text-center fs-3">
								<?php echo nl2br($model->terms); ?>
							</div>
						</p>
						<p>
							<div class="alert alert-info text-center fs-3">
								<?php echo nl2br($model->description); ?>
							</div>
						</p>
					</div>
					<div class="clearfix">
						<hr>
					</div>
					<div class="row mt-5 bg-primary">
						<div class="col-12 fs-2 text-center text-white p-2">
							<i class="bi bi-arrow-down-circle-fill"></i> SELECCIONA ABAJO TU NÚMERO DE LA SUERTE <i class="bi bi-arrow-down-circle-fill"></i>
						</div>
					</div>

					<div class="row mt-5">
							<?php 
							$init = $model->ticket_init;
							$end  = $model->ticket_end;
							for ($i=$init; $i <= $end ; $i++) { 
								echo '<div class="col-lg-1 col-sm-2 col-4">'.Html::button($tickets[$i], ['class' => 'btn btn-success mb-3']).'</div>';
							}
							?>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>
<?php 
/*echo "<pre>";
var_dump($model->attributes);
echo "</pre>";*/
?>