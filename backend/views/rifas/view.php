<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Rifas */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rifas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
echo newerton\fancybox3\FancyBox::widget([
    'target' => '.data-fancybox',
]);

?>
<?php
if(is_null($sales)){ 
?>
<div class="row-fluid">
    <div class="col-xs-12">
        <div class="card card-danger">
            <div class="card-header">
                <h1 class="card-title"><strong>&nbsp;&nbsp;&nbsp;<?=Html::encode($model->name) ?></strong></h1>
            </div>
<?php 
}//end if 
?>

            <?php
            if(is_null($sales)){ 
            ?>
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
                <?php 
                }//end if 
                ?>
                    <?php 
                        $items   = [];
                        $items[] = [
                            'label'          => 'Imagen',
                            'attribute'      => 'main_image',
                            'format'         => 'html',
                            'contentOptions' => [
                                "style" => "text-align: center",
                            ],
                            'value'     =>function($model){
                                return Html::a(Html::img(Url::base()."/".$model->main_image,['height'=>'100']),Url::base()."/".$model->main_image,['title'=>'Ver Imagen','class' => 'data-fancybox']);
                            }

                        ];

                        if(is_null($sales)){ 
                            $items[] = ["attribute"=>"id"];
                            $items[] = ["attribute"=>"name"];
                        }

                        $items[] = ["attribute"=>"description"];

                        if(is_null($sales)){ 
                            $items[] = ["attribute"=>"ticket_init"];
                            $items[] = ["attribute"=>"ticket_end"];
                        }

                        $items[] = [
                            'attribute' => 'date_init',
                            'format'    => 'html',
                            'contentOptions' => [
                                "style" => "text-align: left",
                            ],
                            'value'     =>function($model){
                                return date('d-M-Y',strtotime($model->date_init));
                            }
                        ];
                        $items[] = [
                            'label' => 'Promoción',
                            'format' => 'html',
                            'value'     =>function($model){
                                if(!empty($model->promos)){
                                    return "Obten : ".$model->promos[0]->get_ticket." Oportunidades, En la compra de :".$model->promos[0]->buy_ticket." Boleto";
                                }else{
                                    return "N/A";
                                    }//end if
                                }//end function
                            ];

                        if(is_null($sales)){ 
                            $items[] = [
                                    'label' => 'Estatus',
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'contentOptions' => ['align'=> 'center'],
                                    'value' => function($model){
                                        if($model->status == 1){
                                            return "<div class='col-4 alert-success'>Activo</div>";
                                        }else{
                                            return "<div class='col-4 alert-danger'>Inactivo</div>";
                                        }//end if
                                    }
                                ];
                        }

                        echo DetailView::widget([
                        'model' => $model,
                        'attributes' => $items,
                    ]) ?>

                <?php
                if(is_null($sales)){ 
                ?>
                </div>
            </div>
            <?php 
            }else{
            ?>
            <input type="hidden" id="t_init" value="<?php echo $model->ticket_init ?>">
            <input type="hidden" id="t_digit" value="<?php echo strlen($model->ticket_end);?>">
            <input type="hidden" id="t_end" value="<?php echo $model->ticket_end ?>">
            <?php
            }//end if 
            ?>

            <?php
            if(is_null($sales)){ 
            ?>
            <div class="card-footer text-center">
                <?=  Html::button('Cerrar',['value'=>'','class'=>'btn btn-sm btn-success cancelView', 'title'=>'Cerrer']) ?>
            </div>
        </div>
    </div>
</div>
<?php 
}//end if 
?>

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

