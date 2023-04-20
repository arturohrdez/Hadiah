<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Ticketstorage */

$this->title = 'Update Ticketstorage: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ticketstorages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ticketstorage-update">
    <div class="row-fluid">
        <div class="col-sm-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h1 class="card-title"><strong><i class="nav-icon fas fa-edit"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></strong></h1>
                    <button type="button" class="btn close text-white" onclick='closeForm("ticketstorageForm")'>×</button>
                </div>
                <?=$this->render('_form', [
                    'model' => $model
                ]) ?>
            </div>
            <!--.card-->
        </div>    
    </div>
</div>