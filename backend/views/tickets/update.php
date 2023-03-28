<?php

use backend\models\Rifas;
use backend\models\Tickets;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\models\Tickets */

$this->title = 'Update Tickets: ' . $model->ticket;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tickets-update">
    <div class="row-fluid">
        <div class="col-sm-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h1 class="card-title"><strong><i class="nav-icon fas fa-edit"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></strong></h1>
                    <button type="button" class="btn close text-white" onclick='closeForm("ticketsForm")'>×</button>
                </div>
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
                                        return $model->rifa->name;
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
                                        $oportunidades = Tickets::find()->where(['parent_id'=>$model->id])->all();
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
                            ],
                            //'status',
                            //'parent_id',
                        ],
                    ]) ?>

                    <?php 
                        echo $this->render('_form', [
                            'model' => $model
                        ]);
                    ?>
                </div>
                
                <!-- <?//=$this->render('_form', ['model' => $model]) ?> -->
            </div>
            <!--.card-->
        </div>    
    </div>
</div>