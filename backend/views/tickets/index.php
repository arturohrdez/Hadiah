<?php


use backend\models\Rifas;
use backend\models\Tickets;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TicketsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Boletos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="loading text-center"></div>
    <div id="divEditForm" class="col-sm-12 col-md-12 col-lg-6 offset-lg-3" style="display: none;"></div>
</div>

<div class="backend\models\Tickets-index">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <!-- <div class="col-6 float-right pb-3">
                        <?//= Html::button('<i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Agregar Tickets', ['value' => Url::to('create'), 'class' => 'btn bg-gradient-danger float-right','id'=>'btnAddForm']) ?>
                    </div> -->
                </div>

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


                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            //'rifa_id',
                           [
                                'label'     => 'Rifa',
                                'attribute' => 'rifa_id',
                                'format'    =>'html',
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
                                'label'          => 'Boleto',
                                'attribute'      => 'ticket',
                                'contentOptions' => ['style'=>'text-align: center'],
                            ],
                            [
                                'label'          => 'Oportunidades',
                                'contentOptions' => ['style'=>'text-align: center'],
                                'format'         =>'html',
                                'value'          => function($model){
                                    $oportunidades = Tickets::find()->where(['parent_id'=>$model->id])->all();
                                    if(!empty($oportunidades)){
                                        $op_s = "";
                                        foreach ($oportunidades as $oportunidad) {
                                            $op_s .= "{$oportunidad->ticket},";
                                        }//end foreach
                                        $op_str = "(".trim($op_s, ',').")";
                                        return $op_str;
                                    }else{
                                        return "N/A";
                                    }//end if
                                }//end function
                            ],
                            //'date',
                            //'date_end',
                            [
                                'attribute'      => 'name',
                                'contentOptions' => ['style'=>'text-align: center']
                            ],
                            [
                                'attribute'      => 'lastname',
                                'contentOptions' => ['style'=>'text-align: center']
                            ],
                            [
                                'attribute'      => 'phone',
                                'contentOptions' => ['style'=>'text-align: center']
                            ],
                            //'state',
                            //'type',
                            //'status',
                            [
                                'label'          => 'Estatus',
                                'attribute'      => 'status',
                                'format'         => 'html',
                                'contentOptions' => ['style'=>'text-align: center'],
                                'value'          => function($model){
                                    if($model->status == 'A'){
                                        return '<div class="right badge badge-warning">APARTADO</div>';
                                    }elseif($model->status == "P"){
                                        return '<div class="right badge badge-success">PAGADO</div>';
                                    }//end if
                                },
                                'filter' =>  Html::activeDropDownList($searchModel,'status',['A'=>'APARTADO','P'=>'PAGADO'],['class' => 'form-control','prompt'=>'Todos'])
                            ],
                            //'parent_id',

                            [
                                'class'          => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'header'         => 'Actions',
                                'headerOptions'  => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                                'template'       => '{update}',
                                'buttons'        => [
                                    /*'view'=>function($url,$model){
                                        return Html::button('<i class="fas fa-eye"></i>',['value'=>Url::to(['view', 'id' => $model->id]), 'class' => 'btn bg-teal btn-sm btnViewForm', 'title'=>'Consultar']);
                                    },*/
                                    'update'=>function ($url, $model) {
                                        if($model->status == "A"){
                                            return Html::button('<i class="fas fa-edit"></i>',['value'=>Url::to(['update','id' => $model->id]), 'class' => 'btn bg-teal btn-sm btnUpdateForm','title'=>'Editar']);
                                        }else{
                                            return Html::button('<i class="fas fa-eye"></i>',['value'=>Url::to(['view', 'id' => $model->id]), 'class' => 'btn bg-teal btn-sm btnViewForm', 'title'=>'Consultar']);
                                        }
                                    },
                                    /*'delete'=>function ($url, $model) {
                                        return Html::a('<i class="fas fa-trash-alt"></i>', $url = Url::to(['delete','id' => $model->id]), ['class' => 'btn bg-danger btn-sm','title'=>'Eliminar','data-pajax'=>0, 'data-confirm'=>'¿Está seguro de eliminar este elemento?','data-method'=>'post']);
                                    },*/
                                ]

                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]); ?>

                    <?php Pjax::end(); ?>

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
