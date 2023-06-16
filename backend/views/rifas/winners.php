<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Rifas */

$this->title = 'Ganador(es)';
$this->params['breadcrumbs'][] = ['label' => 'Ganador(es)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ganadores-create">
    <div class="row-fluid">
        <div class="col-sm-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h1 class="card-title"><strong><i class="nav-icon fas fa-trophy"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></strong></h1>
                    <button type="button" class="btn close text-white" onclick='closeForm("ganadoresForm")'>×</button>
                </div>
                <?=$this->render('_formGanadores', [
					'modelRifa'    => $modelRifa,
					'modelPM'      => $modelPM,
					'modelTickets' => $modelTickets,
                ]) ?>
            </div>
        </div>
        <!--.card-->
    </div>
</div>

