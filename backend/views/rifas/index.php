<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap4\ButtonDropdown;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RifasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rifas';
$this->params['breadcrumbs'][] = $this->title;
echo newerton\fancybox3\FancyBox::widget([
    'target' => '.data-fancybox',
]);

?>

<div class="container-fluid">
    <div class="loading text-center"></div>
    <div id="divEditForm" class="col-sm-12 col-md-12 col-lg-8 offset-lg-2" style="display: none;"></div>
</div>

<div class="backend\models\Rifas-index">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <div class="col-6 float-right pb-3">
                            <?= Html::button('<i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Crear Nueva Rifa', ['value' => Url::to('create'), 'class' => 'btn bg-gradient-danger float-right','id'=>'btnAddForm']) ?>
                        </div>
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


                        <?php //Pjax::begin(); ?>
                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                //'id',
                                'name',
                                [
                                    'label'          => 'Imagen',
                                    'attribute'      => 'main_image',
                                    'format'         => 'html',
                                    'contentOptions' => [
                                        "style" => "text-align: center; width: 50px !important",
                                    ],
                                    'value'     =>function($model){
                                        return Html::a(Html::img(Url::base()."/".$model->main_image,['height'=>'100']),Url::base()."/".$model->main_image,['title'=>'Ver Imagen','class' => 'data-fancybox']);
                                    }

                                ],
                                [
                                    'label'     => 'Descripción',
                                    'attribute' => 'description',
                                    'contentOptions' => ['style'=>'text-align: center; max-width: 100px !important;'],
                                ],
                                [
                                    'label'     => 'Terminos y Condiciones',
                                    'attribute' => 'terms',
                                    'contentOptions' => ['style'=>'text-align: center; max-width: 150px !important;'],
                                    'format'         => 'html',
                                    'value' => function($model){
                                        return nl2br($model->terms);
                                    }
                                ],
                                //'ticket_init',
                                //'ticket_end',
                                //'opportunities',
                                //'date_init',
                                //'main_image',

                                [
                                    'label'          => 'Estatus',
                                    'attribute'      => 'status',
                                    'format'         => 'html',
                                    'contentOptions' => ['style'=>'text-align: center;'],
                                    'value'          => function($model){
                                        if($model->status == 1){
                                            return '<div class="right badge badge-success">EN JUEGO</div>';
                                        }//end if
                                        if($model->status == 0){
                                            return '<div class="right badge badge-danger">TERMINADA</div>';
                                        }//end if
                                        if($model->status == 2){
                                            return '<div class="right badge badge-warning">EN PAUSA</div>';
                                        }//end if
                                    },
                                    'filter' =>  Html::activeDropDownList($searchModel,'status',[1=>'EN JUEGO',0=>'TERMINADA'],['class' => 'form-control','prompt'=>'Todos'])
                                ],

                                [
                                    'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                    'header'        => 'Actions',
                                    'headerOptions' => ['style'=>'text-align:center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template'      => '{reports} {winners} {view} {update}',
                                    'buttons'       => [
                                        'winners'=>function($url,$model){
                                            //return Html::button('<i class="fas fa-trophy"></i>',['value'=>Url::to(['ganadores', 'id' => $model->id]), 'class' => 'btn bg-yellow btn-sm', 'title'=>'Asignar Ganador(es)']);
                                            return Html::a('<i class="fas fa-trophy"></i>', $url = Url::to(['ganadores/index', 'id' => $model->id]), ['class' => 'btn bg-yellow btn-sm','title'=>'Asignar Ganador(es)']);
                                        },
                                        'reports'=> function($url,$model,$key){
                                            if($model->status == 0){
                                                /*return Html::a('<i class="fas fa-download"></i>', ['reports', 'id' => $model->id], ['class' => 'btn bg-yellow btn-sm','title'=>'Descargar Reporte','target'=>'_blank']);*/
                                                return ButtonDropdown::widget([
                                                    'label'       => '<i class="fas fa-download"></i>',
                                                    'encodeLabel' => false,
                                                    'options'     => ['class' => 'btn bg-yellow btn-xs'],
                                                    'dropdown'    => [
                                                        'items'       => [
                                                            [
                                                                'label'  => '<i class="fas fa-ticket-alt"></i>&nbsp;Boletos Pagados/Apartados',
                                                                'encode' => false,
                                                                'url'    => ['reporteactivos', 'id' => $key]
                                                            ],
                                                            [
                                                                'label'  => '<i class="far fa-calendar-times"></i>&nbsp;Boletos Vencidos', 
                                                                'encode' => false,
                                                                'url'    => ['reportevencidos', 'id' => $key]
                                                            ],
                                                            [
                                                                'label'  => '<i class="fa fa-ban"></i>&nbsp;Boletos Despreciados', 
                                                                'encode' => false,
                                                                'url'    => ['reportedespreciados', 'id' => $key]
                                                            ],
                                                        ]
                                                    ],
                                                ]);
                                            }//end if
                                        },
                                        'view'=>function($url,$model){
                                            return Html::button('<i class="fas fa-eye"></i>',['value'=>Url::to(['view', 'id' => $model->id]), 'class' => 'btn bg-teal btn-sm btnViewForm', 'title'=>'Consultar']);
                                        },
                                        'update'=>function ($url, $model) {
                                            if($model->status != 0){
                                                return Html::button('<i class="fas fa-edit"></i>',['value'=>Url::to(['update','id' => $model->id]), 'class' => 'btn bg-teal btn-sm btnUpdateForm','title'=>'Editar']);
                                            }//end if
                                        }
                                        /*
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

                        <?php //Pjax::end(); ?>

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


<?php 
$script = <<< JS
    $(function(e){
        $(".btn .dropdown-toggle").addClass('btn-xs');
    });
JS;
$this->registerJs($script);
?>