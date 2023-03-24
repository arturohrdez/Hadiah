<?php 
use yii\helpers\Html;
use yii\helpers\Url;

foreach ($tickets_list as $ticket_l) {
	foreach ($ticket_l as $tickets) {
		if(!in_array($tickets, $tickets_ac)){
			echo '<div class="col-lg-1 col-sm-2 col-4">'.Html::button($tickets, ['id'=>'tn_'.$tickets, 'class' => 'btn_ticket btn btn-outline-success mb-3','data-tn'=>$tickets]).'</div>';
		}else{
			echo '<div class="col-lg-1 col-sm-2 col-4">'.Html::button($tickets, ['id'=>'tn_'.$tickets, 'class' => 'btn bg-black btn-secondary text-black mb-3']).'</div>';
		}//end if
	}//end foreach
}//end foreach

$URL_promos  = Url::to(['site/promos']);
$script = <<< JS

	function promos(elements,tn,tn_rand){
		var url_p        = "$URL_promos";
		var elements_ran = tn_rand;

		return $.ajax({
			url: url_p,
			type: 'POST',
			data: {"id": $model->id,"tickets":elements,"tickets_rnd":elements_ran,"tn":tn},
			beforeSend: function(data){
				//$(".btn_ticket").attr("disabled",true);
				$("#load_tickets").show();
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
		let elements         = options;
		let ticket_ran       = [];
		let div_oportunities = '<div id="lbl_oportunities">Oportunidades:</div>';

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
		$("#div_oportunities").show();
	}//end function

	$(".btn_ticket").on("click",function(e){
		var tn       = $(this).data("tn");
		var tn_sel   = $("#tn_sel").val();
		var tn_rand  = $("#tn_rand").val();
		let elements = [];

		if(tn_sel.length > 0){
			var exp  = tn_sel.split(',');
			elements = exp;
			let search_ti = tn_sel.indexOf(tn);
			let search_tr = tn_rand.indexOf(tn);
			if(search_ti == -1 && search_tr == -1){
				elements.push(tn);
				$("#tn_sel").val(elements.join(','));
				promos(elements,tn,tn_rand).done(function(response){
					promos_         = JSON.parse(response);
					if(promos_.status == true){
						oportunities(promos_.tickets_play);
					}else{
						if(promos_.status == "NA"){
							alert("Error 403 (Forbidden)");
							return false;
						}
					}//end if

					//Muestra oportunidades
					//$(".btn_ticket").attr("disabled",false);
					$("#load_tickets").hide()
					$("#btnSend").show();
				});
			}//end if
		}else{
			elements.push(tn);
			$("#tn_sel").val(elements.join(','));
			promos(elements,tn,tn_rand).done(function(response){
				promos_         = JSON.parse(response);
				if(promos_.status == true){
					oportunities(promos_.tickets_play);
				}else{
					if(promos_.status == "NA"){
						alert("Error 403 (Forbidden)");
						return false;
					}
				}//end if

				//Muestra oportunidades
				$("#load_tickets").hide();
				$("#btnSend").show();
			});
		}//end if
		
		//Tickets Count
		let n_t = elements.length;
		$(".n_t").text(n_t);	

		//Tickets selected
		let t_selectBtn = "";
		for (var i = n_t-1; i >= 0; i--) {
			t_selectBtn = t_selectBtn + '<button id="t_'+elements[i]+'" class="btn_ticketDel btn btn-danger ml-2" type="button" onclick="ticketRemove(`'+elements[i]+'`)">'+elements[i]+'</button>';
		}//end foreach
		$(".t_opt").html(t_selectBtn);

		//Show Div Selected
		$("#div_selected").show();
		$(this).removeClass('btn-outline-success');
		$(this).addClass('btn-success');
	});
JS;
$this->registerJs($script);
?>