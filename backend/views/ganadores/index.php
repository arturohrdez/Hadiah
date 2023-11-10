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
                <div class="card-header">
                    <div class="col-6 float-right pb-3">
                        <?= Html::button('<i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Agregar Ganador', ['value' => Url::to('create'), 'class' => 'btn bg-gradient-danger float-right','id'=>'btnAddForm']) ?>
                    </div>
                </div>
                <div class="card-body pad table-responsive">


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
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
                                    "style" => "text-align: center; width: 200px !important",
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
                                    "style" => "text-align: center; width: 150px !important",
                                ],
                                'value' => function($model){
                                    return '<strong>'.$model->ticket->ticket.'</strong>';
                                }
                            ],
                            [
                                'label' => 'Datos del cliente',
                                'format' => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center; width: 50% !important",
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
                                        return "Presorteo";
                                    }//end if
                                },
                                'filter' => Html::activeDropDownList(
                                    $searchModel,
                                    'type',
                                    ["PM"=>"Premio Mayor", "PS"=>"Presorteo"],
                                    ['class' => 'form-control','prompt'=>'Todos']
                                ),

                            ],
                            //'description',
                            //'type',

                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'header'        => 'Actions',
                                'headerOptions' => ['style'=>'text-align:center'],
                                'template'      => '{view} {update} {delete}',
                                'buttons'       => [
                                    'view'=>function($url,$model){
                                        return Html::button('<i class="fas fa-eye"></i>',['value'=>Url::to(['view', 'id' => $model->id]), 'class' => 'btn bg-teal btn-sm btnViewForm', 'title'=>'Consultar']);
                                    },
                                    'update'=>function ($url, $model) {
                                        return Html::button('<i class="fas fa-edit"></i>',['value'=>Url::to(['update','id' => $model->id]), 'class' => 'btn bg-teal btn-sm btnUpdateForm','title'=>'Editar']);
                                    },
                                    'delete'=>function ($url, $model) {
                                        return Html::a('<i class="fas fa-trash-alt"></i>', $url = Url::to(['delete','id' => $model->id]), ['class' => 'btn bg-danger btn-sm','title'=>'Eliminar','data-pajax'=>0, 'data-confirm'=>'¿Está seguro de eliminar este elemento?','data-method'=>'post']);
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
