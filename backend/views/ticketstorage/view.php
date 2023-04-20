<?php
use backend\models\Ticketstorage;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Ticketstorage */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ticketstorages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row-fluid">
    <div class="col-xs-12">
        <div class="card card-danger">
            <div class="card-header">
                <h1 class="card-title"><strong>&nbsp;&nbsp;&nbsp;<?=Html::encode($model->name) ?></strong></h1>
            </div>
            <div class="contact-view card-body">
                <div class="col-12 pt-3">
                    <?php echo DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            [
                                'label'     => 'Rifa',
                                'attribute' => 'rifa_id',
                                'contentOptions' => ['style'=>'text-align: center'],
                                'format'    =>'html',
                                'value'     => function($model){
                                    if(is_null($model->rifa->name)){
                                        return "-";
                                    }else{
                                        return "<h3 class='text-danger font-weight-bold'>".$model->rifa->name."</h3>";
                                    }//end if
                                }//end function
                            ],
                            [
                                'label'          => 'Boleto(s)',
                                'attribute'      => 'ticket',
                                'contentOptions' => ['style'=>'text-align: center'],
                                'format'         =>'html',
                                'value' => function($model){
                                    if(is_null($model->parent_id)){
                                        $oportunidades = Ticketstorage::find()->where(['parent_id'=>$model->id])->all();
                                        if(!empty($oportunidades)){
                                            $op_s = "";
                                            foreach ($oportunidades as $oportunidad) {
                                                $op_s .= "{$oportunidad->ticket},";
                                            }//end foreach
                                            $op_str = "(".trim($op_s, ',').")";
                                            return '<div class="right badge badge-danger" style="font-size: 17px;">'.$model->ticket." - ".$op_str.'</div>';
                                        }else{
                                            return '<div class="right badge badge-danger" style="font-size: 17px;">'.$model->ticket.'</div>';
                                        }//end if
                                    }else{
                                        $oportunidad = Tickets::findOne($model->parent_id);
                                        return '<div class="right badge badge-danger" style="font-size: 17px;">'.$oportunidad->ticket." - (".$model->ticket.')</div>';
                                    }//end if
                                }//end function
                            ],
                            [
                                'attribute' => 'folio',
                                'contentOptions' => ['style'=>'text-align: center'],
                            ],
                            [
                                'attribute' => 'name',
                                'contentOptions' => ['style'=>'text-align: center'],
                            ],
                            [
                                'attribute' => 'lastname',
                                'contentOptions' => ['style'=>'text-align: center'],
                            ],
                            [
                                'attribute' => 'phone',
                                'contentOptions' => ['style'=>'text-align: center'],
                            ],
                            [
                                'attribute' => 'state',
                                'contentOptions' => ['style'=>'text-align: center'],
                            ],
                            //'type',
                            [
                                'attribute' => 'date',
                                'format'    => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center",
                                ],
                                'value'     =>function($model){
                                    //return Yii::$app->formatter->asDateTime($model->date_payment);
                                    return date('d/m/Y H:i:s',strtotime($model->date));
                                }
                            ],
                            [
                                'attribute' => 'date_payment',
                                'format'    => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center",
                                ],
                                'value'     =>function($model){
                                    //return Yii::$app->formatter->asDateTime($model->date_payment);
                                    return date('d/m/Y H:i:s',strtotime($model->date_payment));
                                }
                            ],
                            [
                                'attribute' => 'transaction_number',
                                'format'    => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center",
                                ],
                                'value'     =>function($model){
                                    if($model->type_sale == "store"){
                                        return "N/A";
                                    }else{
                                        return $model->transaction_number;
                                    }
                                }
                            ],
                            [
                                'attribute' => 'type_sale',
                                'format'    => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center",
                                ],
                                'value'     =>function($model){
                                    if($model->type_sale == "store"){
                                        return "Tienda Física";
                                    }elseif($model->type_sale == "online"){
                                        return "En Línea";
                                    }
                                }
                            ]
                            /*[
                                'label'          => 'Estatus',
                                'attribute'      => 'status',
                                'format'         => 'html',
                                'contentOptions' => ['style'=>'text-align: center'],
                                'value'          => function($model){
                                    if($model->status == 'A'){
                                        return '<div class="right badge badge-warning" style="font-size: 15px;">APARTADO</div>';
                                    }elseif($model->status == "P"){
                                        return '<div class="right badge badge-success" style="font-size: 15px;">PAGADO</div>';
                                    }//end if
                                },
                            ]*/
                            //'status',
                            //'parent_id',
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
    /*** Action Button Edit View ***/
    $(".btnUpdateView").on("click",function(e){
        $("#divEditForm").hide(function(e){});
        $("#btnAddForm").show(function(e){});
        $("#divEditForm").load($(this).attr('value'),function(e){
            $("#divEditForm").slideDown('slow');
        });
    });

    /*** Action Button Cancel-Close View ***/
    $(".cancelView").on("click",function(e){
         $("#divEditForm").slideUp(function(e){});
    });
</script>

