<?php 
use yii\helpers\Html;
use yii\helpers\Url;

echo Html::hiddenInput('page', $value     = $page, ['id' => 'n_page']);
echo Html::hiddenInput('page_end', $value = $page_end, ['id' => 'n_page_end']);

foreach ($tickets_list as $ticket_l) {
	echo '<div class="col-lg-1 col-sm-2 col-3">'.Html::a($ticket_l, $url = null, ['id'=>'tn_'.$ticket_l, 'class' => 'mb-3 btn btn-outline-light btn_ticket','data-tn'=>$ticket_l]).'</div>';	
}//end foreach


$script = <<< JS
	const elements_selected = [];

	$(".btn_ticket").on("click",function(e){
		var tn          = $(this).data("tn");
		var tn_sel      = $("#tn_sel").val();
		var tn_rand     = $("#tn_rand").val();
		//let elements    = [];

		console.log(tn);
		/*console.log(tn_sel);
		console.log(tn_rand);
		console.log(elements);*/

		if(tn_sel.length > 0){

		}else{
			elements_selected.push(tn);
		}//end if

		console.log(elements_selected);
	});

JS;
$this->registerJs($script);
?>