<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tickets */

$this->title = 'Create Tickets';
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tickets-create">
    <div class="row-fluid">
        <div class="col-sm-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h1 class="card-title"><strong><i class="nav-icon fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></strong></h1>
                    <button type="button" class="btn close text-white" onclick='closeForm("ticketsForm")'>×</button>
                </div>
                <?=$this->render('_form', [
                    'model' => $model
                ]) ?>
            </div>
        </div>
        <!--.card-->
    </div>
</div>