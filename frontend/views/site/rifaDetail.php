<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

$this->title = $model->name;
$this->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
$this->registerMetaTag(['property' => 'og:type', 'content' => '']);
$this->registerMetaTag(['property' => 'og:image', 'content' => Url::to('/backend/web/'.$model->main_image, true)]);
$this->registerMetaTag(['property' => 'og:url', 'content' => Url::to('/',true)]);
$this->registerMetaTag(['property' => 'og:description', 'content' => 'Rifas PabMan - Apuesta poco y ganas mucho.']);

echo newerton\fancybox3\FancyBox::widget([
    'target' => '.data-fancybox-modal',
    'config' => [
		'clickSlide'   => false,
		'clickOutside' => false,
    ]
]);

//COLORS
$sitetheme_          = $siteConfig->theme;
$sitetitlecolor_     = $siteConfig->titlecolor;
$sitefontcolor_      = $siteConfig->fontcolor;

?>


<section id="blog" class="blog mt-5">
	<div class="container" data-aos="fade-up">
		<div class="row">
			<div class="col-lg-12 entries">
				<article class="entry">
					<div class="row <?php echo !empty($sitetitlecolor_) ? $sitetitlecolor_ : "text-danger"; ?> text-center pt-3 pb-3" style="border: 3px; border-style: dashed double;">
						<h1 class="fw-bold">
							<?php echo $model->name; ?>
						</h1>
						<div class="fs-2 mt-3">
							<?php 
								$diassemana = Yii::$app->params["diassemana"];
								$meses      = Yii::$app->params["meses"];
								echo $diassemana[date('w',strtotime($model->date_init))]." ".date('d',strtotime($model->date_init))." de ".$meses[date('n',strtotime($model->date_init))-1]. " de ".date('Y',strtotime($model->date_init)) ; 
							?>
						</div>
					</div>
					<div class="row entry-img text-center mt-3">
						<!--<img src="<?php //echo Url::base()."/backend/web/".$model->main_image; ?>" alt="" class="img-fluid">-->
						<img src="<?php echo Yii::$app->params["baseUrlBack"].$model->main_image; ?>" alt="" class="img-fluid">
					</div>
					<div class="row <?php echo !empty($sitefontcolor_) ? $sitefontcolor_ : "text-primary";  ?> mt-5" style="border: 3px; border-style: dashed double;">
						<div class="text-center fw-bold fs-4 pt-3">
							<?php echo nl2br($model->terms); ?>
						</div>
						<div class="text-center fw-bold fs-5 pt-5">
							<?php echo nl2br($model->description); ?>
						</div>
					</div>
					
					<div class="row bg-success pt-3 pb-3 mt-5">
						<div class="col-12 fs-2 text-center text-white fw-bold">
							<i class="bi bi-arrow-down-circle-fill"></i> SELECCIONA ABAJO TU NÚMERO DE LA SUERTE <i class="bi bi-arrow-down-circle-fill"></i>
						</div>
						<div class="pb-3 d-flex justify-content-center bd-highlight">
							<div id="ticket_s_m" class="col-6 text-center" style="display: none;">
								<div class="alert alert-success p-2">
									<strong><i class="bi bi-ticket-perforated-fill"></i> BOLETO DISPONIBLE</strong>
								</div>
							</div>
							<div class="clearix"></div>
							<div id="ticket_e_m" class="col-6 text-center" style="display: none;">
								<div class="alert alert-danger p-2">
									<strong><i class="bi bi-ticket-perforated-fill"></i> BOLETO NO DISPONIBLE</strong>
								</div>
							</div>
							<div class="clearix"></div>
							<div class="col-12 col-lg-6 text-center mt-3">
								<?php echo  Html::input('number','ticket_serarch',null, $options=['class'=>'form-control','style'=>'display: none;','max'=>$model->ticket_end,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'id'=>'ticket_s','placeholder'=>'BUSCAR BOLETO','autocomplete'=>'off']) ?>
								<?php echo  Html::button("¡LO QUIERO!", ['id' => 'btn_addticket','class'=>'btn btn-warning mt-2','style'=>'font-weight: bold; display: none;']); ?>
							</div>
						</div>
					</div>

					<!-- <div class="row pt-3 pb-3 bg-gradient bg-primary">
						
					</div> -->

					<div id="div_selected" class="row pt-3 pb-2 bg-black text-warning"  style="display: none;">
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
								<?php echo Html::img("@web/images/suerte.gif", ['class' => 'img-fluid','width'=>'100','height'=>'100']); ?>
							</div>

							<div id="div_oportunities" class="col-12 overflow-auto" style="max-height: 200px; display: none;"></div>
							<div class="row mt-3" style="text-align: center;">
								<div>
									<button id="btnSend" class="btn btn-success bg-gradient pl-5 pr-5 data-fancybox-modal" data-type="ajax" data-src="<?php echo Url::to(['site/apartar','id'=>$model->id]) ?>" data-touch="false" style="display: none;">
										APARTAR
									</button>
								</div>
							</div>
						</div>
					</div>
					<div id="list_tickets" class="row bg-success pt-3 overflow-auto" style="max-height: 500px;">
						<div id="loading_tickets_list" class="col-12 text-center mb-5" style="display: none;">
							<strong class="fs-3 text-light">Generando boletos, por favor espere ...</strong><br>
							<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>
						</div>
					</div>

					<?php 
					//Pagniación
					/*if($pages > 1){
					?>
					<div id="paginatorH" class="row bg-success pt-3 pb-3 overflow-auto" style="display: none;">
						<div id="sPagesH" class="col-12 text-center pb-2" style="display: none;">
							<span class="text-white">Página <span id="sPageA">A</span> de <span id="sPageZ">X</span> </span>
						</div>
						<div class="col text-right">
							<button class="btn btn-light" id="btn-back-page" data-page=""> &laquo; Atrás</button>
						</div>
						<div class="col text-left">
							<button class="btn btn-light" id="btn-next-page" data-page="">Siguiente &raquo;</button>
						</div>
					</div>
					<div id="paginatorF" class="row bg-success overflow-auto" style="display: none; max-height: 150px;">
						<div class="col-12 text-center pb-2">
							<?php 
							for ($i=1; $i <= $pages; $i++) {
							?>
								<a id="pageH<?php echo $i-1; ?>" class="btn pageItem link-light btn-sm" href="javascript:0;" data-page="<?php echo $i-1; ?>"><?php echo $i ?></a>
							<?php
							}//end for
							?>
						</div>
					</div>
					<?php 
					}*///end if
					?>
				</article>
			</div>
		</div>
	</div>
</section>

<?php 
$digitos         = strlen($model->ticket_end);
$URL_remove      = Url::to(['site/ticketremove']);
$URL_tickets     = Url::to(['site/loadtickets']);
$URL_showtickets = Url::to(['site/showtickets']);
$URL_searcht     = Url::to(['site/searchticket']);
$URL_apartar     = Url::to(['site/apartar','id'=>$model->id]);
$URL_random      = Url::to(['site/ticketsrandom']);

if (\Yii::$app->session->has('oportunities')) {
	$oportunidades = \Yii::$app->session->get('oportunities');
} else {
	$oportunidades = 0;
}//end if
?>

<!-- <script type="text/javascript">
	function ticketRemove(t){
		var oportunidades = '<?php //echo $oportunidades;?>';

		var tn = ticketParse(t);
		let ticket_r = elements_selected.indexOf(tn);
		if (ticket_r > -1) {
			if(oportunidades > 0){
				let tr = elements_random[ticket_r][tn];
				$.ajax({
					url : "<?php //echo $URL_remove;?>",
					type: "POST",
					async: true,
					data: {'tn':tn,'tr':tr},
					beforeSend: function(e){
						$(".btn_ticketDel").addClass('disabled');
						$("#load_tickets").show();
					},
					success: function (response) {
						if(response.status == true){
							elements_selected.splice(ticket_r, 1);
							elements_random.splice(ticket_r, 1);
							reloadTicketsInfo();
							enableTicketsRnd(tr);

							$("#t_"+tn).remove();
							$("#tn_"+tn).removeClass('disabled btn-light');
							$("#tn_"+tn).addClass('btn-outline-light');
							$(".btn_ticketDel").removeClass('disabled');
							$("#load_tickets").hide();
						}//end if
					}
				});	
			}else{
				elements_selected.splice(ticket_r, 1);
				console.log(elements_selected);
				//Tickets Count
				let n_t = elements_selected.length;
				$(".n_t").text(n_t);
				if(n_t == 0){
					$("#div_selected").hide();
				}//end if

				$("#t_"+tn).remove();
				$("#tn_"+tn).removeClass('disabled btn-light');
				$("#tn_"+tn).addClass('btn-outline-light');

				reloadTicketsInfo();
			}//end if

		}//end if
	}//end function
</script> -->
<?php 
$script = <<< JS
	showTickets();
	function showTickets(){
		$.ajax({
			url : "$URL_showtickets",
			type: "GET",
			data: {'rifa_id':{$model->id}},
			dataType: "html",
			beforeSend: function(){
				$("#loading_tickets_list").show();
			},
			success: function (data) {
				$("#ticket_s").show();
				$("#list_tickets").html(data);
				return false;
			}
		});
	}//end function

	/* 
	function showTickets(){
		$.ajax({
			url : "$URL_showtickets",
			type: "GET",
			data: {'page':0,'tickets_end':{$model->ticket_end}},
			dataType: "html",
			beforeSend: function(){
				$("#loading_tickets_list").show();
			},
			success: function (data) {
				$("#ticket_s").show();
				$("#list_tickets").html(data);
				let page = $("#n_page").val();
				let next_page = parseInt(page)+1;

				if(page == 0){
					$("#btn-back-page").addClass('disabled');
					$("#btn-back-page").attr('data-page',page);
				}else{
					let back_page = parseInt(page)-1;
					$("#btn-back-page").attr('data-page',back_page);
					$("#btn-back-page").removeClass('disabled');
				}//end if
				$("#btn-next-page").attr('data-page',next_page);

				$("#paginatorH").show();
				$("#paginatorF").show();
				return false;
			}
		});
	}//end function

	function paginator(page){
		$.ajax({
			url : "$URL_showtickets",
			type: "GET",
			data: {'page':page,'tickets_end':{$model->ticket_end}},
			dataType: "html",
			beforeSend: function(){
				$("#list_tickets").html('<div id="loading_tickets_list" class="col-12 text-center mb-5"><strong class="fs-3 text-light">Generando boletos, por favor espere ...</strong><br><div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div></div>')
				//console.log("llamando tickets");
			},
			success: function (data) {
				$("#list_tickets").html(data);
				let page = $("#n_page").val();
				let next_page = parseInt(page)+1;

				if(page == 0){
					$("#btn-back-page").addClass('disabled');
					$("#btn-back-page").attr('data-page',page);
				}else{
					let back_page = parseInt(page)-1;
					$("#btn-back-page").attr('data-page',back_page);
					$("#btn-back-page").removeClass('disabled');
				}//end if

				let page_end = $("#n_page_end").val();
				if(next_page > page_end){
					$("#btn-next-page").attr('data-page',page);
					$("#btn-next-page").addClass('disabled');
				}else{
					$("#btn-next-page").attr('data-page',next_page);
					$("#btn-next-page").removeClass('disabled');
				}//end if

				$("#sPageA").text(parseInt(page) + 1);
				$("#sPageZ").text(parseInt(page_end) + 1);

				$("#paginatorH").show();
				$("#sPagesH").show();
				return false;
			}
		});
	}

	$("#btn-next-page, #btn-back-page").on("click",function(e){
		$(".pageItem").removeClass("activePage");
		let page  = $(this).attr('data-page');
		$("#btn-next-page").addClass('disabled');
		$("#btn-back-page").addClass('disabled');
		paginator(page);
		$("#pageH"+page).addClass("activePage");
	});

	$(".pageItem").on("click",function(e){
		e.preventDefault();
		$(".pageItem").removeClass("activePage");
		let page  = $(this).attr('data-page');
		$("#btn-next-page").addClass('disabled');
		$("#btn-back-page").addClass('disabled');
		paginator(page);
		$(this).addClass("activePage");
	});

	//Format Number
	$("#ticket_s").on("keyup change",function(e){
		let n = $(this).val();
		let i = n.replace(/^(0+)/g, '');
		let f = "";
		let a = parseFloat(n);

		if(n != "" && a > 0){
			f = i.padStart({$digitos},"0");
			$(this).val(f);
			$("#btn_addticket").show();
		}else{
			$("#btn_addticket").hide();
		}//end if
	});

	$("#btn_addticket").on("click",function(e){
		let tn_s = $("#ticket_s").val();
		if(tn_s != ""){
			tn_s           = ticketParse(tn_s);
			var resSearchT = searchTickets(tn_s);

			if(!resSearchT){
				$("#ticket_e_m").show();
				$("#btn_addticket").hide();
				$("#ticket_s").val('');
				return false;
			}//end if

			$.ajax({
				url : "{$URL_searcht}",
				type: 'POST',
				async: false,
				data: {"id":{$model->id},"tn_s":tn_s,"max":{$model->ticket_end}},
				beforeSend: function(data){
					//$("#ticket_s_m").hide();
					$("#ticket_e_m").hide();
					$("#btn_addticket").attr("disabled",true);
					$("#btn_addticket").html("Verficando Boleto..");
				},
				success: function(response) {
					$("#btn_addticket").html("¡LO QUIERO!");
					$("#btn_addticket").attr("disabled",false);

					if(response.status == true){
						if(oportunidades > 0){
							$.ajax({
								url : "{$URL_random}",
								type: "POST",
								data: {'tn':tn_s},
								beforeSend: function(){
									$("#tn_"+tn_s).attr('disabled',true);
									$("#tn_"+tn_s).removeClass('btn-outline-light');
									$("#tn_"+tn_s).addClass('btn-light');
									$("#tn_"+tn_s).addClass('disabled');
									$("#load_tickets").show();
									$("#btnSend").hide();
									$("#div_selected").show();
								},
								success: function (response) {
									elements_selected.push(tn_s);
									elements_random.push(response.tickets_play_ls);
									disableTicketRnd();
									reloadTicketsInfo();
									$("#load_tickets").hide();
								}
							});
						}else{
							elements_selected.push(tn_s);
							reloadTicketsInfo();
						}//end if
					}else{
						$("#ticket_e_m").show();
					}//end if
					$("#btn_addticket").hide();
					$("#ticket_s").val('');
				}
			});
		}//end if
	}); */
JS;
$this->registerJs($script);