<?php 
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php
foreach ($tickets_list as $ticket_l) {
	echo '<div class="col-lg-1 col-sm-2 col-3">'.Html::a($ticket_l, $url = null, ['id'=>'tn_'.$ticket_l, 'class' => 'free  btn_ticket text-white','data-tn'=>$ticket_l]).'</div>';	
}//end foreach
?>
