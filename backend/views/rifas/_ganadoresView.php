<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

$this->title = "Ganadores";
$this->params['breadcrumbs'][] = ['label' => 'Rifas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="row-fluid">
    <div class="col-xs-12">
        <div class="card card-warning">
            <div class="card-header">
                <h1 class="card-title"><strong>&nbsp;&nbsp;&nbsp;GANADORES RIFA: <?=Html::encode($modelGanadorPM->rifa->name) ?></strong></h1>
            </div>
            <div class="contact-view card-body">
                <div class="col-12" align="right">
                    <!-- <?//= Html::button('<i class="fas fa-edit"></i>', ['value'=>Url::to(['update','id' => $model->id]),'class' => 'btn bg-teal btn-sm btnUpdateView', 'title'=>'Editar']) ?> -->
                    <!-- <?/*= Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => '¿Está seguro de eliminar este elemento?',
                                'method' => 'post',
                            ],
                        ])*/ ?> -->
                </div>
                <div class="col-12 pt-3">
                   <?= DetailView::widget([
                        'model' => $modelGanadorPM,
                        'attributes' => [
                        	[
                                'label' => 'RIFA',
                                'attribute' => 'rifa_id',
                                'format' => 'html',
                                'contentOptions' => ['align'=> 'center'],
                                'value' => function($modelGanadorPM){
                                   return "<div class='h3'>".$modelGanadorPM->rifa->name."</div>";
                                }
                            ],
                            [
                            	'label' => "TICKET GANADOR",
                            	'attribute' => 'ticket_id',
                                'format' => 'html',
                                'contentOptions' => ['align'=> 'center'],
                                'value' => function($modelGanadorPM){
                                   return "<div><strong><div class='right badge badge-warning' style='font-size:150%'>".$modelGanadorPM->ticket->ticket."</div></<strong><div>";
                                }
                            ],
                            [
                            	'label' => "DETALLES",
                            	'attribute' => 'description',
                                'format' => 'html',
                                'contentOptions' => ['align'=> 'center'],
                                'value' => function($modelGanadorPM){

                                    $status = "";
                                    if($modelGanadorPM->ticket->status == 'A'){
                                        $status = '<div class="right badge badge-warning" style="font-size: 15px;">APARTADO</div>';
                                    }elseif($modelGanadorPM->ticket->status == "P"){
                                        $status = '<div class="right badge badge-success" style="font-size: 15px;">PAGADO</div>';
                                    }//end if

                                   return "<div class='h6'>
                                                <table class='col-12'>
                                                    <tbody>
                                                        <tr>
                                                            <td>Nombre: </td>
                                                            <td>".$modelGanadorPM->ticket->name." ".$modelGanadorPM->ticket->lastname."</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estado: </td>
                                                            <td>".$modelGanadorPM->ticket->state."</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Teléfono: </td>
                                                            <td>".$modelGanadorPM->ticket->phone."</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fecha Pago: </td>
                                                            <td>".date("d/m/Y H:i:s",strtotime($modelGanadorPM->ticket->date_payment))."</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Número de transacción/referencia: </td>
                                                            <td>".$modelGanadorPM->ticket->transaction_number."</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estatus: </td>
                                                            <td>".$status."</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>";
                                }
                            ]
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="card-footer text-center">
                <?=  Html::button('ACEPTAR',['value'=>'','class'=>'btn btn-sm btn-primary cancelView', 'title'=>'ACEPTAR']) ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /*** Action Button Cancel-Close View ***/
    $(".cancelView").on("click",function(e){
         $("#divEditForm").slideUp(function(e){});
    });
</script>