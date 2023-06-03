	
const elements_selected = [];
const elements_random   = [];

function ticketParse(tn){
	let parseNTicket = tn.toString();
	return parseNTicket;
}//end function

function formatTicket(tn,dig){
	var tn_st = "";
	var dig_  = dig.length;
	tn_st     = tn.toString().padStart(dig_, '0');
	return tn_st;
}//end function

function reloadTicketsInfo(){
	let jTickets = JSON.stringify(elements_selected);
	$("#tn_sel").val(jTickets);

	//Tickets Count
	let n_t = elements_selected.length;
	$(".n_t").text(n_t);

	//Tickets selected
	let t_selectBtn = "";
	for (var i = n_t-1; i >= 0; i--) {
		t_selectBtn = t_selectBtn + '<button id="t_'+elements_selected[i]+'" class="btn_ticketDel btn btn-danger ml-2" type="button" onclick="ticketRemove(`'+elements_selected[i]+'`)">'+elements_selected[i]+'</button>';
	}//end foreach
	$(".t_opt").html(t_selectBtn);

	//Ticekts Randoms
	let n_r = elements_random.length;
	if(n_r > 0){
		let div_oportunities = '<div id="lbl_oportunities">Oportunidades:</div>';

		for (var i = elements_random.length - 1; i >= 0; i--) {
			for (let key in elements_random[i]) {
				div_oportunities += "<div id='t_n_"+key+"'>"+key+" [";
				div_oportunities += elements_random[i][key].join(",");
				div_oportunities += "] </div>";
			}//end for
		}//end for

		//tickets_randoms
		let jRandoms = JSON.stringify(elements_random);
		$("#tn_rand").val(jRandoms);
		$("#div_oportunities").html(div_oportunities);
		$("#div_oportunities").show();
	}//end if

	//Show Div Selected
	$("#div_selected").show();
	$("#btnSend").show();
	return true;
}//end if

function ticketRemove(t){
	/*var url_r   = "<?php echo $URL_remove ?>";
	var rifa_id = "<?php echo $model->id ?>";*/
	let ticket_r = elements_selected.indexOf(ticketParse(t));
	if (ticket_r > -1) {
		elements_selected.splice(ticket_r, 1);
		console.log(elements_selected);
		//Tickets Count
		let n_t = elements_selected.length;
		$(".n_t").text(n_t);
		if(n_t == 0){
			$("#div_selected").hide();
		}//end if

		$("#t_"+t).remove();
		$("#tn_"+t).removeClass('disabled btn-light');
		$("#tn_"+t).addClass('btn-outline-light');
	}//end if
}//end function

function disableTickets(){
	let n_t = elements_selected.length;
	if(n_t > 0){
		for (var i = n_t-1; i >= 0; i--) {
			$("#tn_"+elements_selected[i]).removeClass('btn-outline-light');
			$("#tn_"+elements_selected[i]).addClass('btn-light');
			$("#tn_"+elements_selected[i]).addClass('disabled');
			//console.log(elements_selected[i]) 
		}//end foreach
	}//end if

	let n_r = elements_random.length;
	if(n_r > 0){
		for (var i = n_r - 1; i >= 0; i--) {
			for (let k in elements_random[i]) {
				console.log(elements_random[i][key]);
			}//end for
		}//end for
	}//end if
}//end function



