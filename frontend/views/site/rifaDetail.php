<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

echo newerton\fancybox3\FancyBox::widget([
    'target' => '.data-fancybox-modal'
]);
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
					<div class="entry-img text-center">
						<img src="<?php echo Yii::$app->params["baseUrlBack"].$model->main_image; ?>" alt="" class="img-fluid">
					</div>
					<h2 class="entry-title fs-1 text-danger text-center">
						<?php echo $model->name; ?>
					</h2>
					<div class="entry-content">
						<p>
							<div class="entry-title text-danger text-center fs-2">
								<?php 
									$diassemana = ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado"];
									$meses      = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
									echo $diassemana[date('w',strtotime($model->date_init))]." ".date('d',strtotime($model->date_init))." de ".$meses[date('n',strtotime($model->date_init))-1]. " del ".date('Y',strtotime($model->date_init)) ; 
								?>
							</div>
						</p>
						<p>
							<div class="alert alert-warning text-center fs-5">
								<?php echo nl2br($model->terms); ?>
							</div>
						</p>
						<p>
							<div class="alert alert-info text-center fs-5">
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

					<div class="row pt-3 pb-3 bg-primary">
						<div class="d-flex justify-content-center bd-highlight">
							<div class="col-6 text-center">
								<?php echo  Html::input('number','ticket_serarch',null, $options=['class'=>'form-control','maxlength'=>10,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'id'=>'ticket_s','placeholder'=>'NUM. BOLETO','autocomplete'=>'off']) ?>
								<?php echo  Html::button("BUSCAR BOLETO", ['id'=>'btn_ticket_search','class' => 'btn btn-danger mt-2','style'=>'font-weight: bold;']); ?>
							</div>
						</div>
					</div>

					<div id="div_selected" class="row pt-3 pb-2 bg-black" style="display: none;">
						<?php echo Html::hiddenInput('tn_sel', $value = null, ['id'=>'tn_sel']); ?>
						<?php echo Html::hiddenInput('tn_rand', $value = null, ['id'=>'tn_rand']); ?>

						<div id="div_options" class="col-12 text-white text-center">
							<p class="fs-3 text-warning">
								<span class="n_t">0</span> - Boletos Seleccionados
							</p>
							<p class="t_opt"><button class='btn_ticketDel'></button></p>
							<p class="fs-5 text-warning">
								Para eliminar haz clic en el boleto.
							</p>

							<div id="load_tickets" class="col-12" style="display: none;">
								<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
							</div>

							<div id="div_oportunities" class="col-12" style="display: none;"></div>
							<div class="row mt-3" style="text-align: center;">
								<div>
									<button id="btnSend" class="btn btn-success bg-gradient data-fancybox-modal" data-type="ajax" data-src="<?php echo Url::to(['site/apartar','id'=>$model->id]) ?>" data-touch="false" style="display: none;">
										<i class="bi bi-plus-square"></i> APARTAR <i class="bi bi-plus-square"></i> 								
									</button>
								</div>
							</div>
						</div>
					</div>

					<div id="list_tickets" class="row mt-5 overflow-scroll" style="max-height: 300px;">
						<div id="loading_tickets_list" class="col-12 text-center mb-5" style="display: none;">
							<strong class="fs-3">Generando Boletos ...</strong><br>
							<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>

<?php 
$digitos     = strlen($model->ticket_end);
$URL_remove  = Url::to(['site/ticketremove']);
$URL_tickets = Url::to(['site/loadtickets']);
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
				$(".btn_ticketDel").attr("disabled",true);
				$("#btnSend").hide();
				$("#load_tickets").show();
			},
			success: function(response) {
				$("#load_tickets").hide();

				//Tickets
				var tn_sel = $("#tn_sel").val();
				var exp     = tn_sel.split(',');
				var pos_del = exp.indexOf(t);
				if(pos_del > -1){
					exp.splice(pos_del, 1);
					$("#tn_sel").val(exp.join(','));

					let n_t = exp.length;
					$(".n_t").text(n_t);
					if(n_t == 0){
						$("#div_selected").hide();
					}//end if

					$("#t_"+t).remove();
					$("#tn_"+t).removeClass('btn-success');
					$("#tn_"+t).addClass('btn-outline-success');
				}//end if
				
				//Tickets random
				var tn_rand      = $("#tn_rand").val();
				var exp_rand     = tn_rand.split(',');
				if(exp_rand != ""){
					/*console.log("entra");
					console.log(exp_rand);*/

					var pos_del_rand = null;
					let ticketRandomRemove = JSON.parse(response);
					$("#t_n_"+t).remove();
					for (let key in ticketRandomRemove) {
						pos_del_rand = exp_rand.indexOf(ticketRandomRemove[key]);
						if(pos_del_rand > -1){
							exp_rand.splice(pos_del_rand, 1);
							$("#tn_rand").val(exp_rand.join(','));

							
							$("#tn_"+ticketRandomRemove[key]).removeClass('btn-success');
							$("#tn_"+ticketRandomRemove[key]).addClass('btn-outline-success');
						}//end if
					}//end for
				}//end if

				//$(".btn_ticket").attr("disabled",false);
				$(".btn_ticketDel").attr("disabled",false);
				$("#loadRemove").html("");
				$("#loadRemove").hide();
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
	function loadTickets(){
		$.ajax({
			url : "$URL_tickets",
			type: "POST",
			dataType: "HTML",
			data: {"id":$model->id},
			beforeSend: function(){
				$("#loading_tickets_list").show();
				//console.log("beforeSend");
			},
			success: function (data) {
				$("#list_tickets").html(data);
				$("#loading_tickets_list").hide();
			}//sucess
		});
	}//

	$(function(e){
		$("#tn_sel").val("");
		$("#tn_rand").val("");
		loadTickets();
	});

	//Format Number
	$("#ticket_s").on("keyup",function(e){
		let n = $(this).val();
		let i = n.replace(/^(0+)/g, '');
		let f = "";
		if(n != ""){
			f = i.padStart({$digitos},"0");
			$(this).val(f);
		}//end if
	});

JS;
$this->registerJs($script);