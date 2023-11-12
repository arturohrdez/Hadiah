<?php

use backend\models\Rifas;
use backend\models\Tickets;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GanadoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ganadores';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="loading text-center"></div>
    <div id="divEditForm" class="col-sm-12 col-md-12 col-lg-6 offset-lg-3" style="display: none;"></div>
</div>

<div class="app\models\Ganadores-index">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <?php 
                if(!is_null($modelRifa)){
                ?>
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-widget widget-user" style="margin: 0 !important;">
                                <div class="widget-user-header bg-gradient-primary text-left" style="height: auto !important;">
                                    <h3 class="h1 text-center">
                                        <?php echo $modelRifa->name; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    if($modelRifa->status <> 0){
                    ?>
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-12 pb-3">
                            <?= Html::a('<i class="fas fa-chevron-circle-left"></i>&nbsp;&nbsp;Regresar al listado de Rifas', $url = Url::to(['rifas/index']), ['class' => 'col-lg-6 col-md-12 btn bg-gradient-danger float-left']); ?>
                        </div>
                        <div class="col-lg-6 col-md-12 pb-3">
                            <?= Html::button('<i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Agregar Ganador', ['value' => Url::to('create?rifa_id='.$modelRifa->id), 'class' => 'col-lg-6 col-md-12 btn bg-gradient-danger float-right','id'=>'btnAddForm']) ?>
                        </div>
                    </div>
                    <?php 
                    }//end if
                    ?>
                </div>
                <?php 
                }//end if
                ?>

                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="row-fluid mt-2" align="center">
                        <div class="col-sm-12">
                            <div class="alert bg-teal alert-dismissable">
                               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                               <i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('success') ?>
                           </div>
                       </div>
                   </div>
               <?php endif; ?>

                <?php if (Yii::$app->session->hasFlash('danger')): ?>
                    <div class="row-fluid mt-2" align="center">
                        <div class="col-sm-12">
                            <div class="alert bg-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('danger') ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="card-body pad table-responsive">


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?php echo  GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'label'     => 'Rifa',
                                'attribute' => 'rifa_id',
                                'format'    => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center; width: 10% !important",
                                ],
                                'value'     => function($model){
                                    if(is_null($model->rifa->name)){
                                        return "-";
                                    }else{
                                        return $model->rifa->name;
                                    }
                                },
                                'filter' => Html::activeDropDownList(
                                    $searchModel,
                                    'rifa_id',
                                    ArrayHelper::map(Rifas::find()->all(),'id','name'),
                                    ['class' => 'form-control','prompt'=>'Todos']
                                ),
                            ],
                            [
                                'label'     => 'Ticket',
                                'attribute' => 'ticket_id',
                                'format'    => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center; width: 10% !important",
                                ],
                                'value' => function($model){
                                    return '<strong>'.$model->ticket->ticket.'</strong>';
                                }
                            ],
                            [
                                'label'     => 'Descripción',
                                'attribute' => 'description',
                                'contentOptions' => [
                                    "style" => "text-align: center; width: 20% !important",
                                ],
                            ],
                            [
                                'label' => 'Datos del cliente',
                                'format' => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center; width: 45% !important",
                                ],
                                'value' => function($model){
                                    return '
                                    <table class="table table-light table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Folio</th>
                                                <th scope="col">Ticket</th>
                                                <th scope="col">Nombre Completo</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Teléfono</th>
                                                <th scope="col">Transacción/Referencia</th>
                                                <th scope="col">Fecha Pago</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                                <th class="text-center t_folio" scope="row">'.$model->ticket->folio.'</th>
                                                <td class="text-center t_ticket">'.$model->ticket->ticket.'</td>
                                                <td class="text-center t_name">'.$model->ticket->name." ".$model->ticket->lastname.'</td>
                                                <td class="text-center t_state">'.$model->ticket->state.'</td>
                                                <td class="text-center t_phone">'.$model->ticket->phone.'</td>
                                                <td class="text-center t_transaction">'.$model->ticket->transaction_number.'</td>
                                                <td class="text-center t_payment">'.$model->ticket->date_payment.'</td>
                                            </tr>
                                          </tbody>
                                    </table>
                                    ';
                                }
                            ],
                            [
                                'label'     => 'Tipo de premio',
                                'attribute' => 'type',
                                'format'    => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center; width: 10% !important",
                                ],
                                'value' => function($model){
                                    if($model->type == "PM"){
                                        return '<i class="nav-icon fas fa-fas fa-trophy"></i> <br> Premio Mayor';
                                    }elseif($model->type == "PS"){
                                        return '<i class="fas fa-medal"></i> <br> Presorteo';
                                    }//end if
                                },
                                'filter' => Html::activeDropDownList(
                                    $searchModel,
                                    'type',
                                    ["PM"=>"Premio Mayor", "PS"=>"Presorteo"],
                                    ['class' => 'form-control','prompt'=>'Todos']
                                ),

                            ],

                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'header'        => 'Actions',
                                'contentOptions' => [
                                    "style" => "text-align: center; width: 10% !important",
                                ],
                                'headerOptions' => ['style'=>'text-align:center'],
                                'template'      => '{delete}',
                                'buttons'       => [
                                    'delete'=>function ($url, $model) {
                                        if(!is_null(Yii::$app->request->get('id'))){
                                            if($model->type == "PM"){
                                                $data_confirm = "Eliminar el ganador del premio mayor activará la rifa. ¿Desea continuar?";
                                            }else{
                                                $data_confirm = '¿Está seguro de eliminar este elemento?';
                                            }//end if

                                            return Html::a(
                                                '<i class="fas fa-trash-alt"></i>', 
                                                $url = Url::to(['delete','id' => $model->id]), 
                                                [
                                                    'class'        => 'btn bg-danger btn-sm',
                                                    'title'        => 'Eliminar',
                                                    'data-pajax'   => 0,
                                                    'data-confirm' => $data_confirm,
                                                    'data-method'  => 'post'
                                                ]
                                            );
                                        }//end if
                                    },
                                ]

                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]); ?>


                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
</div>
