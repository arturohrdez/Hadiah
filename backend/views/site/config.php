<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\RifasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configuraciones Generales';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div id="divEditForm" class="col-lg-12 col-md-12 ">
        <div class="card card-danger">
            <div class="card-header">
                <h1 class="card-title"><strong><i class="nav-icon fas fa-tools"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></strong></h1>
            </div>
            <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'configForm']]); ?>
            <div class="config-form card-body row">
                <?php echo $form->field($model, 'id')->hiddenInput()->label(false); ?>
                <?php echo $form->field($model, 'sitename',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'slogan',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="card-body row">
                <?php echo $form->field($model, 'logo',['options'=>['class'=>'col-lg-6 col-md-12 mt-3 bg-light']])->fileInput()->label('<div>Logo: </div> <div class=" alert-warning" style="padding:4px; border-radius: 2px;"><small><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Tamaño del Logo: 770px X 770px (Ancho x Alto)</small></div>',['class'=>'col-12']) ?>
                <div id="preview_logo" class="col-lg-6 col-md-12 mt-3" align="center">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt iure quam amet, ullam. Accusamus iste rem eveniet reiciendis doloremque! Est consequatur eveniet error nostrum ipsam voluptatum, facere eaque, voluptas quia.
                </div>
            </div>
            <div class="card-body row">
                <?php echo $form->field($model, 'favicon',['options'=>['class'=>'col-lg-6 col-md-12 mt-3 bg-light']])->fileInput()->label('<div>Favicon: </div> <div class=" alert-warning" style="padding:4px; border-radius: 2px;"><small><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Tamaño del favicon: 48px X 48px (Ancho x Alto)</small></div>',['class'=>'col-12']) ?>
                <div id="preview_logo" class="col-lg-6 col-md-12 mt-3" align="center">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt iure quam amet, ullam. Accusamus iste rem eveniet reiciendis doloremque! Est consequatur eveniet error nostrum ipsam voluptatum, facere eaque, voluptas quia.
                </div>
            </div>
            <div class="card-body row">
                <div class="col-12">
                    <h2>Redes Sociales</h2>
                </div>
                <?php echo $form->field($model, 'whatsapp',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'instagram',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'facebook',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'youtube',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'video',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class=" card-footer" align="right">
                <?php echo Html::submitButton('<i class="fas fa-check-circle"></i> Guardar Información', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>