<?php

use backend\models\Rifas;
use backend\models\Ticketstorage;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use yii\widgets\Pjax;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TicketstorageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ticketstorages';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="loading text-center"></div>
    <div id="divEditForm" class="col-sm-12 col-md-12 col-lg-6 offset-lg-3" style="display: none;"></div>
</div>

<div class="backend\models\Ticketstorage-index">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <!-- <div class="col-6 float-right pb-3">
                        <?php// Html::button('<i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Agregar Ticketstorage', ['value' => Url::to('create'), 'class' => 'btn bg-gradient-danger float-right','id'=>'btnAddForm']) ?>
                    </div> -->
                </div>
                <div class="card-body pad table-responsive">


                    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?php Pjax::begin(['id' => 'my-pjax-ticketstorage']); ?>
                    <?php echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
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
                                    ArrayHelper::map(Rifas::find()->where(['status'=>1])->all(),'id','name'),
                                    ['class' => 'form-control','prompt'=>'Todos']
                                ),
                            ],
                            [
                                'label'          => 'Boletos / Oportunidades',
                                'attribute'      => 'ticket',
                                'contentOptions' => ['style'=>'text-align: center'],
                                'value'     => function($model){
                                    $oportunidades = Ticketstorage::find()->where(['parent_id'=>$model->id])->all();
                                    if(!empty($oportunidades)){
                                        $op_s = "";
                                        foreach ($oportunidades as $oportunidad) {
                                            $op_s .= "{$oportunidad->ticket},";
                                        }//end foreach
                                        $op_str = "(".trim($op_s, ',').")";

                                        return $model->ticket." / ".$op_str;
                                    }else{
                                        return $model->ticket;
                                    }//end if

                                },
                            ],
                            [
                                'attribute'      => 'name',
                                'contentOptions' => ['style'=>'text-align: center']
                            ],
                            [
                                'attribute'      => 'lastname',
                                'contentOptions' => ['style'=>'text-align: center']
                            ],
                            [
                                'label' => 'Fecha Apartado',
                                'attribute' => 'date',
                                'format'    => 'html',
                                'contentOptions' => [
                                    "style" => "text-align: center",
                                ],
                                'value'     =>function($model){
                                    //return Yii::$app->formatter->asDateTime($model->date);
                                    return date('d/m/Y H:i:s',strtotime($model->date));
                                },
                                'filter' => DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'date',
                                    'options' => ['class' => 'form-control'],
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true
                                    ]                                    
                                ]),
                            ],

                            [
                                'class'          => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'header'         => 'Actions',
                                'headerOptions'  => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                                'template'       => '{view}',
                                'buttons'        => [
                                    'view'=>function($url,$model){
                                        return Html::button('<i class="fas fa-eye"></i>',['value'=>Url::to(['view', 'id' => $model->id]), 'class' => 'btn bg-teal btn-sm btnViewForm', 'title'=>'Consultar']);
                                    },
                                    /*'update'=>function ($url, $model) {
                                        return Html::button('<i class="fas fa-edit"></i>',['value'=>Url::to(['update','id' => $model->id]), 'class' => 'btn bg-teal btn-sm btnUpdateForm','title'=>'Editar']);
                                    },
                                    'delete'=>function ($url, $model) {
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
