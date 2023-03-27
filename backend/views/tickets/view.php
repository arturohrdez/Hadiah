<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Tickets */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row-fluid">
    <div class="col-xs-12">
        <div class="card card-danger">
            <div class="card-header">
                <h1 class="card-title"><strong>&nbsp;&nbsp;&nbsp;<?=Html::encode($model->name) ?></strong></h1>
            </div>
            <div class="contact-view card-body">
                <div class="col-12" align="right">
                    <?= Html::button('<i class="fas fa-edit"></i>', ['value'=>Url::to(['update','id' => $model->id]),'class' => 'btn bg-teal btn-sm btnUpdateView', 'title'=>'Editar']) ?>
                    <?= Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => '¿Está seguro de eliminar este elemento?',
                                'method' => 'post',
                            ],
                        ]) ?>
                </div>
                <div class="col-12 pt-3">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'rifa_id',
                            'ticket',
                            'date',
                            'date_end',
                            'phone',
                            'name',
                            'lastname',
                            'state',
                            'type',
                            'status',
                            'parent_id',
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="card-footer text-center">
                <?=  Html::button('Cerrar',['value'=>'','class'=>'btn btn-sm btn-success cancelView', 'title'=>'Cerrer']) ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /*** Action Button Edit View ***/
    $(".btnUpdateView").on("click",function(e){
        $("#divEditForm").hide(function(e){});
        $("#btnAddForm").show(function(e){});
        $("#divEditForm").load($(this).attr('value'),function(e){
            $("#divEditForm").slideDown('slow');
        });
    });

    /*** Action Button Cancel-Close View ***/
    $(".cancelView").on("click",function(e){
         $("#divEditForm").slideUp(function(e){});
    });
</script>

