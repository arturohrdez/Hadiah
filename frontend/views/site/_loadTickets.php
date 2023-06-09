<?php 
use yii\helpers\Html;
use yii\helpers\Url;


$URL_random    = Url::to(['site/ticketsrandom']);
if (\Yii::$app->session->has('oportunities')) {
	$oportunidades = \Yii::$app->session->get('oportunities');
} else {
	$oportunidades = 0;
}//end if

echo Html::hiddenInput('page', $value     = $page, ['id' => 'n_page']);
echo Html::hiddenInput('page_end', $value = $page_end, ['id' => 'n_page_end']);

foreach ($tickets_list as $ticket_l) {
	echo '<div class="col-lg-1 col-sm-2 col-3">'.Html::a($ticket_l, $url = null, ['id'=>'tn_'.$ticket_l, 'class' => 'mb-3 btn btn-outline-light btn_ticket','data-tn'=>$ticket_l]).'</div>';	
}//end foreach

$script = <<< JS
	var url_ran       = '{$URL_random}';
	var oportunidades = '{$oportunidades}';

	$(function(e){
		disableTicketRnd();
	});

	$(".btn_ticket").on("click",function(e){
		var tn          = ticketParse($(this).data("tn"));
		var tn_sel      = $("#tn_sel").val();
		var tn_rand     = $("#tn_rand").val();

		let search_ti = elements_selected.indexOf(tn);
		if(search_ti == -1){
			if(oportunidades > 0){
				$.ajax({
					url : "{$URL_random}",
					type: "POST",
					data: {'tn':tn},
					beforeSend: function(){
						$("#tn_"+tn).attr('disabled',true);
						$("#tn_"+tn).removeClass('btn-outline-light');
						$("#tn_"+tn).addClass('btn-light');
						$("#tn_"+tn).addClass('disabled');
						$("#load_tickets").show();
						$("#btnSend").hide();
						$("#div_selected").show();
					},
					success: function (response) {
						elements_selected.push(tn);
						elements_random.push(response.tickets_play_ls);
						disableTicketRnd();
						reloadTicketsInfo();
						$("#load_tickets").hide();
					}
				});	
			}else{
				elements_selected.push(tn);
				$("#tn_"+tn).attr('disabled',true);
				$("#tn_"+tn).removeClass('btn-outline-light');
				$("#tn_"+tn).addClass('btn-light');
				$("#tn_"+tn).addClass('disabled');
				reloadTicketsInfo();
			}//end if
		}//end if
	});
JS;
$this->registerJs($script);
?>