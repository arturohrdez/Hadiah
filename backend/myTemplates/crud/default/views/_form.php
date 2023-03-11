<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\bootstrap4\ActiveForm */
?>


    <?= "<?php " ?>$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>Form']]); ?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form card-body">
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
</div>
<div class=" card-footer" align="right">
	<?= "<?= " ?> Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>Form")']) ?>
    <?= "<?= " ?>Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>

    <?= "<?php " ?>ActiveForm::end(); ?>

