<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row-fluid">
    <div class="col-xs-12">
        <div class="card card-danger">
            <div class="card-header">
                <h1 class="card-title"><strong>&nbsp;&nbsp;&nbsp;<?=Html::encode($model->id) ?></strong></h1>
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
                            'username',
                            'auth_key',
                            'password_hash',
                            'password_reset_token',
                            'email:email',
                            'status',
                            'created_at',
                            'updated_at',
                            'verification_token',
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

