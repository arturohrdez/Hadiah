<?php 
use yii\helpers\Html;
use yii\helpers\Url;

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
							<div>Oportunidades:</div>
							<div id="div_oportunities" class="col-12"></div>
							<div class="row mt-3" style="text-align: center;">
								<div id="loadRemove" style="display: none;"></div>
								<div>
									<button id="btnSend" class="btn btn-success bg-gradient data-fancybox-modal" data-type="ajax" data-src="<?php echo Url::to(['site/apartar','id'=>$model->id]) ?>" data-touch="false" style="display: none;">
										<i class="bi bi-plus-square"></i> APARTAR <i class="bi bi-plus-square"></i> 								
									</button>
								</div>
							</div>
						</div>
					</div>

					<div class="row mt-5 overflow-scroll" style="max-height: 300px;">
							<?php 
							$init = $model->ticket_init;
							$end  = $model->ticket_end;

							for ($i=$init; $i <= $end ; $i++) {
								if(!in_array($tickets[$i], $tickets_ac)){
									echo '<div class="col-lg-1 col-sm-2 col-4">'.Html::button($tickets[$i], ['id'=>'tn_'.$tickets[$i], 'class' => 'btn_ticket btn btn-outline-success mb-3','data-tn'=>$tickets[$i]]).'</div>';
								}else{
									echo '<div class="col-lg-1 col-sm-2 col-4">'.Html::button($tickets[$i], ['id'=>'tn_'.$tickets[$i], 'class' => 'btn btn-secondary text-black mb-3']).'</div>';
								}//end if
							}
							?>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>

<?php 
$URL_promos = Url::to(['site/promos']) ;
$URL_remove = Url::to(['site/ticketremove']) ;
?>
<script type="text/javascript">
	function ticketRemove(t){
		var url_r = "<?php echo $URL_remove ?>";
		$.ajax({
			url: url_r,
			type: 'POST',
			data: {"tn":t},
			beforeSend: function(data){
				$(".btn_ticket").attr("disabled",true);
				$(".btn_ticketDel").attr("disabled",true);
				$("#loadRemove").html('<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>');
				$("#btnSend").hide();
				$("#loadRemove").show();
			},
			success: function(response) {
				//Tickets
				var tn_sel = $("#tn_sel").val();
				var exp     = tn_sel.split(',');
				
				//Tickets random
				var tn_rand      = $("#tn_rand").val();
				var exp_rand     = tn_rand.split(',');
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

				$(".btn_ticket").attr("disabled",false);
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
	$(function(e){
		$("#tn_sel").val("");
		$("#tn_rand").val("");
	});

	function promos(elements,tn){
		var url_p = "$URL_promos";
		var elements_ran = $("#tn_rand").val();
		/*console.log(url_p);*/
		return $.ajax({
			url: url_p,
			type: 'POST',
			data: {"id": $model->id,"tickets":elements,"tickets_rnd":elements_ran,"tn":tn},
			beforeSend: function(data){
				$(".btn_ticket").attr("disabled",true);
				$("#div_oportunities").html('<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>');
				$("#btnSend").hide();
			},
			success: function(response) {
	        },
	        error: function() {
	            console.log('Error occured');
	        }
		});
	}//end function

	function oportunities(options){
		let elements         = JSON.parse(options);
		let ticket_ran       = [];
		let div_oportunities = "";

		for (let key in elements) {
			div_oportunities += "<div id='t_n_"+key+"'>"+key+" [";
			for (var i = elements[key].length - 1; i >= 0; i--) {
				$("#tn_"+elements[key][i]).removeClass('btn-outline-success');
				$("#tn_"+elements[key][i]).addClass('btn-success');

				if(i < elements[key].length-1){
					div_oportunities += ",";
				}
				div_oportunities += elements[key][i];

				ticket_ran.push(elements[key][i]);
			}//end foreach
			div_oportunities += "] </div>";
		}//end for

		//tickets_randoms
		$("#tn_rand").val(ticket_ran.join(","));
		$("#div_oportunities").html(div_oportunities);
		$("#btnSend").show();
	}//end function


	$(".btn_ticket").on("click",function(e){
		var tn       = $(this).data("tn");
		var tn_sel   = $("#tn_sel").val();
		var tn_rand  = $("#tn_rand").val();
		let elements = [];
		var promos_  = null;

		//alert(tn_rand);

		if(tn_sel.length > 0){
			var exp  = tn_sel.split(',');
			elements = exp;
			let search_ti = tn_sel.indexOf(tn);
			let search_tr = tn_rand.indexOf(tn);
			if(search_ti == -1 && search_tr == -1){
				elements.push(tn);
				$("#tn_sel").val(elements.join(','));
				promos(elements,tn).done(function(response){
					//Muestra oportunidades
					oportunities(response);
					$(".btn_ticket").attr("disabled",false);
				});
			}//end if
		}else{
			elements.push(tn);
			$("#tn_sel").val(elements.join(','));
			promos(elements,tn).done(function(response){
				//Muestra oportunidades
				oportunities(response);
				$(".btn_ticket").attr("disabled",false);
			});
		}//end if

		//console.log(promos);
		
		//Tickets number
		let n_t = elements.length;
		$(".n_t").text(n_t);

		//Tickets selected
		let t_selectBtn = "";
		for (var i = n_t-1; i >= 0; i--) {
			//console.log(elements[i]);
			t_selectBtn = t_selectBtn + '<button id="t_'+elements[i]+'" class="btn_ticketDel btn btn-danger ml-2" type="button" onclick="ticketRemove(`'+elements[i]+'`)">'+elements[i]+'</button>';
		}//end foreach*
		$(".t_opt").html(t_selectBtn);

		//Show Div Selected
		$("#div_selected").show();
		$(this).removeClass('btn-outline-success');
		$(this).addClass('btn-success');
	});
JS;
$this->registerJs($script);