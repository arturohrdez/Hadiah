<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Rifas */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<?php $formPM = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'ganadoresForm']]); ?>
<div class="rifas-form card-body row">
	<div class="col-12">
        <h2>Asignar Ganador</h2>
		<?= $formPM->field($modelPM, 'rifa_id')->hiddenInput(['option' => 'value'])->label(false); ?>

		<?php echo Html::label("Ticket Ganador", $for = 'ticket_id', ['class' => 'form-label']); ?>
		<?php
			echo Select2::widget([
				'id'=>'ticket_id',
			    'name' => 'ticket_id',
			    'data' => ArrayHelper::map($modelTickets, 'id', 'ticket'),
			    'options' => ['placeholder' => 'Seleccione una opción'],
			    'pluginOptions' => [
			        'allowClear' => true,
			    ],
			]);
		?>
	</div>
</div>
<?php ActiveForm::end(); ?>