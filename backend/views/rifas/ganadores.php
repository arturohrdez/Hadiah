<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Rifas */

$this->title = 'Ganadores';
$this->params['breadcrumbs'][] = ['label' => 'Ganador(es)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-widget widget-user" style="margin: 0 !important;">
                                    <div class="widget-user-header bg-secondary text-left" style="height: auto !important;">
                                        <h1 class="h1 text-center">RIFA</h1>
                                        <h3 class="h4 text-center">
                                            <?php echo $modelRifa->name; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6 col-md-12 pb-3">
                                <?= Html::a('<i class="fas fa-chevron-circle-left"></i>&nbsp;&nbsp;Regresar al listado de Rifas', $url = Url::to('index'), ['class' => 'col-lg-6 col-md-12 btn bg-gradient-danger float-left']); ?>
                            </div>
                            <div class="col-lg-6 col-md-12 pb-3">
                                <?= Html::button('<i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Agregar Ganador', ['value' => Url::to('create'), 'class' => 'col-lg-6 col-md-12 btn bg-gradient-danger float-right','id'=>'btnAddForm']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pad table-responsive">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

