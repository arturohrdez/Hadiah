	
const elements_selected = [];
const elements_random   = [];

/*function ticketsRn(tn,opt,max,tickets){
	let tickets_arr    = tickets;
	var tickets_random = generarNumerosAleatorios(opt,1,max,tickets_arr);

	console.log(tickets_random);
}//end function*/

/*function generarNumerosAleatorios(cantidad, minimo, maximo, tickets) {
	console.log(tickets);


	var numerosAleatorios = [];	
	for (var i = 1; i <= cantidad; i++) {
		var n  = Math.floor(Math.random() * (maximo - minimo + 1)) + minimo;
		var n_ = formatTicket(n,maximo.toString());

		//Busca los aleatorios dentro del conjunto de tickets
		var p = tickets.indexOf(n_);
		//elements_random.push(ticketParse(n_));
		//return false;
		//numerosAleatorios.push(n_);
	}//end for

	return "entra";
	//return numerosAleatorios;
}//end function*/

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



