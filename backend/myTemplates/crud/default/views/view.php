<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row-fluid">
    <div class="col-xs-12">
        <div class="card card-danger">
            <div class="card-header">
                <h1 class="card-title"><strong>&nbsp;&nbsp;&nbsp;<?= "<?=" ?>Html::encode($model-><?= $generator->getNameAttribute() ?>) ?></strong></h1>
            </div>
            <div class="contact-view card-body">
                <div class="col-12" align="right">
                    <?= "<?= " ?>Html::button('<i class="fas fa-edit"></i>', ['value'=>Url::to(['update',<?= $urlParams ?>]),'class' => 'btn bg-teal btn-sm btnUpdateView', 'title'=>'Editar']) ?>
                    <?= "<?= " ?>Html::a('<i class="fas fa-trash-alt"></i>', ['delete', <?= $urlParams ?>], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => <?= $generator->generateString('¿Está seguro de eliminar este elemento?') ?>,
                                'method' => 'post',
                            ],
                        ]) ?>
                </div>
                <div class="col-12 pt-3">
                    <?= "<?= " ?>DetailView::widget([
                        'model' => $model,
                        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "                            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "                            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="card-footer text-center">
                <?= "<?= " ?> Html::button(<?= $generator->generateString('Cerrar') ?>,['value'=>'','class'=>'btn btn-sm btn-success cancelView', 'title'=>'Cerrer']) ?>
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

