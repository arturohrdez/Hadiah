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
                                   return $modelGanadorPM->rifa->name;
                                }
                            ],
                            [
                            	'label' => "TICKET GANADOR",
                            	'attribute' => 'ticket_id',
                                'format' => 'html',
                                'contentOptions' => ['align'=> 'center'],
                                'value' => function($modelGanadorPM){
                                   return "<div>
                                   			<strong> 
                                   				<div class='right badge badge-warning' style='font-size:150%''>".$modelGanadorPM->ticket->ticket."</div></<strong> 
                                   				<br><br> 
                                   				*** GANADOR *** <br> ".$modelGanadorPM->ticket->name." ".$modelGanadorPM->ticket->lastname." 
                                   				<br> 
                                   				*** ESTADO *** <br> ".$modelGanadorPM->ticket->state." 
                                   				<br>
                                   				*** Teléfono *** <br> ".$modelGanadorPM->ticket->phone."
                                   				"."<div>";
                                }
                            ],
                            [
                            	'label' => "DETALLES",
                            	'attribute' => 'description',
                                'format' => 'html',
                                'contentOptions' => ['align'=> 'center'],
                                'value' => function($modelGanadorPM){
                                   return $modelGanadorPM->description;
                                }
                            ]
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="card-footer text-center">
                <?=  Html::button('Cerrar',['value'=>'','class'=>'btn btn-sm btn-success cancelView', 'title'=>'Cerrer']) ?>
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