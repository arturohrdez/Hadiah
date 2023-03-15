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

					<div id="div_selected" class="row pt-3 pb-2 bg-black" style="display: none;">
						<?php echo Html::hiddenInput('tn_sel', $value = "",['id'=>'tn_sel']); ?>
						<div id="div_options" class="col-12 text-white text-center">
							<p class="fs-3 text-warning">
								<span class="n_t">0</span> - Boletos Seleccionados
							</p>
							<p class="t_opt"><button class='btn_ticketDel'></button></p>
							<p class="fs-5 text-warning">
								Para eliminar haz clic en el boleto.
							</p>
						</div>
					</div>

					<div class="row mt-5">
							<?php 
							$init = $model->ticket_init;
							$end  = $model->ticket_end;
							for ($i=$init; $i <= $end ; $i++) { 
								echo '<div class="col-lg-1 col-sm-2 col-4">'.Html::button($tickets[$i], ['class' => 'btn_ticket btn btn-outline-success mb-3','data-tn'=>$tickets[$i]]).'</div>';
							}
							?>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>



<?php 
$script = <<< JS
	$(function(e){
		var tn_sel = $("#tn_sel").val("");
	});




	$(".btn_ticket").on("click",function(e){
		var tn     = $(this).data("tn");
		var tn_sel = $("#tn_sel").val();

		let elements = [];
		if(tn_sel.length > 0){
			var exp  = tn_sel.split(',');
			elements = exp;
			elements.push(tn);
			$("#tn_sel").val(elements.join(','));
		}else{
			elements.push(tn);
			$("#tn_sel").val(elements.join(','));
		}//end if

		let n_t = elements.length;
		$(".n_t").text(n_t);

		let t_selectBtn = "";
		for (var i = n_t-1; i >= 0; i--) {
			//console.log(elements[i]);
			t_selectBtn = t_selectBtn + "<button class='btn_ticketDel btn btn-danger ml-2' type='button' data-tn='"+elements[i]+"'>"+elements[i]+"</button>";
		}//end foreach*

		$(".t_opt").html(t_selectBtn);

		//console.log(t_selectBtn)

		$("#div_selected").show();
		$(this).removeClass('btn-outline-success');
		$(this).addClass('btn-success');
	});

	$(".btn_ticketDel").on("click",function(e){
		alert("entra");
		/*var tn     = $(this).data("tn");
		var tn_sel = $("#tn_sel").val();

		var exp  = tn_sel.split(',');
		let pos_del = tn_sel.indexOf(tn) // (pos) es la posición para abreviar

		console.log(exp)
		console.log(pos_del)*/
	});
JS;
$this->registerJs($script);