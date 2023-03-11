<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>
use yii\helpers\Url;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="loading text-center"></div>
    <div id="divEditForm" class="col-sm-12 col-md-12 col-lg-6 offset-lg-3" style="display: none;"></div>
</div>

<div class="<?=$generator->modelClass?>-index">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <div class="col-6 float-right pb-3">
                        <?= "<?= " ?>Html::button('<i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Agregar <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>', ['value' => Url::to('create'), 'class' => 'btn bg-gradient-danger float-right','id'=>'btnAddForm']) ?>
                    </div>
                </div>
                <div class="card-body pad table-responsive">


<?= $generator->enablePjax ? "                    <?php Pjax::begin(); ?>\n" : '' ?>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "                    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "                <?= " ?>GridView::widget([
                        'dataProvider' => $dataProvider,
                        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n                        'columns' => [\n" : "'columns' => [\n"; ?>
                            ['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "                            '" . $name . "',\n";
        } else {
            echo "                            //'" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "                            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "                            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'header'        => 'Actions',
                                'headerOptions' => ['style'=>'text-align:center'],
                                'template'      => '{view} {update} {delete}',
                                'buttons'       => [
                                    'view'=>function($url,$model){
                                        return Html::button('<i class="fas fa-eye"></i>',['value'=>Url::to(['view', <?= $urlParams ?>]), 'class' => 'btn bg-teal btn-sm btnViewForm', 'title'=>'Consultar']);
                                    },
                                    'update'=>function ($url, $model) {
                                        return Html::button('<i class="fas fa-edit"></i>',['value'=>Url::to(['update',<?= $urlParams ?>]), 'class' => 'btn bg-teal btn-sm btnUpdateForm','title'=>'Editar']);
                                    },
                                    'delete'=>function ($url, $model) {
                                        return Html::a('<i class="fas fa-trash-alt"></i>', $url = Url::to(['delete',<?= $urlParams ?>]), ['class' => 'btn bg-danger btn-sm','title'=>'Eliminar','data-pajax'=>0, 'data-confirm'=>'¿Está seguro de eliminar este elemento?','data-method'=>'post']);
                                    },
                                ]

                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]); ?>
<?php else: ?>
    <?= "               <?= " ?>ListView::widget([
                        'dataProvider' => $dataProvider,
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                        },
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                            'options' => ['class' => 'pagination mt-3'],
                        ]
                    ]) ?>
<?php endif; ?>

<?= $generator->enablePjax ? "                    <?php Pjax::end(); ?>\n" : '' ?>

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
