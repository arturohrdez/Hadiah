<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use dosamigos\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model backend\models\Faqs */
/* @var $form yii\bootstrap4\ActiveForm */
?>


    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'faqsForm']]); ?>

<div class="faqs-form card-body">
    <?php echo $form->field($model, 'pregunta',['options'=>['class'=>'col-12 mt-3']])->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'respuesta',['options'=>['class'=>'col-12 mt-3']])->widget(
        CKEditor::class, [
            'options' => ['rows' => 5,'cols'=>2],
            'preset' => 'full', // Puedes ajustar esto según tus necesidades
            'clientOptions' => [
                'toolbar' => [
                    [
                        'name' => 'styles',
                        'items' => ['Styles', 'Format'],
                    ],
                    [
                        'name' => 'basicstyles',
                        'items' => ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat'],
                    ],
                    [
                        'name' => 'paragraph',
                        'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'],
                    ],
                    [
                        'name' => 'links',
                        'items' => ['Link', 'Unlink'],
                    ],
                    [
                        'name' => 'tools',
                        'items' => ['Maximize'],
                    ],
                    [
                        'name' => 'editing',
                        'items' => ['Scayt'],
                    ],
                ],
            ]
        ]
    ) ?>

    <?php echo $form->field($model, 'status',['options'=>['class'=>'col-12 mt-3']])->dropDownList([ '1' => 'Activo','0' => 'Inactivo', ], ['prompt' => 'Seleccione una opción'])?>

</div>
<div class=" card-footer" align="right">
	<?php echo  Html::Button('<i class="fas fa-times-circle"></i> Cancelar', ['class' => 'btn btn-danger','id'=>'btnCloseForm','onClick'=>'closeForm("faqsForm")']) ?>
    <?php echo Html::submitButton('<i class="fas fa-check-circle"></i> Aceptar', ['class' => 'btn btn-success']) ?>
</div>

    <?php ActiveForm::end(); ?>

