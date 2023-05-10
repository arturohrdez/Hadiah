<?php 
use yii\helpers\Html;
use yii\helpers\Url;

echo Html::hiddenInput('page', $value     = $page, ['id' => 'n_page']);
echo Html::hiddenInput('page_end', $value = $page_end, ['id' => 'n_page_end']);

foreach ($tickets_list as $ticket_l) {
	echo '<div class="col-lg-1 col-sm-2 col-3">'.Html::a($ticket_l, $url = null, ['id'=>'tn_'.$ticket_l, 'class' => 'mb-3 btn btn-outline-light btn_ticket','data-tn'=>$ticket_l]).'</div>';	
}//end foreach


$script = <<< JS
	$(function(e){
		let n_t = elements_selected.length;
		for (var i = n_t-1; i >= 0; i--) {
			$("#tn_"+elements_selected[i]).removeClass('btn-outline-light');
			$("#tn_"+elements_selected[i]).addClass('btn-light');
			$("#tn_"+elements_selected[i]).addClass('disabled');
			//console.log(elements_selected[i])
		}//end foreach
	});


	$(".btn_ticket").on("click",function(e){
		var tn          = $(this).data("tn");
		var tn_sel      = $("#tn_sel").val();
		var tn_rand     = $("#tn_rand").val();

		let search_ti = elements_selected.indexOf(tn);
		if(search_ti == -1){
			elements_selected.push(tn);
			let jTickets = JSON.stringify(elements_selected)

			
			//$("#tn_sel").val(jTickets);
			//$("#btn-abrir-modal").attr("data-ts",jTickets);
			//Tickets Count
			let n_t = elements_selected.length;
			$(".n_t").text(n_t);	

			//Tickets selected
			let t_selectBtn = "";
			for (var i = n_t-1; i >= 0; i--) {
				t_selectBtn = t_selectBtn + '<button id="t_'+elements_selected[i]+'" class="btn_ticketDel btn btn-danger ml-2" type="button" onclick="ticketRemove(`'+elements_selected[i]+'`)">'+elements_selected[i]+'</button>';
			}//end foreach
			$(".t_opt").html(t_selectBtn);

			//Show Div Selected
			$("#div_selected").show();

			$("#tn_"+tn).removeClass('btn-outline-light');
			$("#tn_"+tn).addClass('btn-light');
			$(this).addClass('disabled');
			$("#btnSend").show();
		}//end if
		//console.log(elements_selected);
	});

JS;
$this->registerJs($script);
?>