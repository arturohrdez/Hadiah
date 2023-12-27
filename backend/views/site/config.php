<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\ButtonGroup;

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
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="row-fluid mt-2" align="center">
                    <div class="col-sm-12">
                        <div class="alert bg-teal alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('danger')): ?>
                <div class="row-fluid mt-2" align="center">
                    <div class="col-sm-12">
                        <div class="alert bg-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('danger') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','id'=>'configForm']]); ?>
            <div class="config-form card-body row">
                <?php echo $form->field($model, 'id')->hiddenInput()->label(false); ?>
                <?php echo $form->field($model, 'sitename',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'slogan',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="card-body row">
                <?php echo $form->field($model, 'img')->hiddenInput()->label(false); ?>
                <?php echo $form->field($model, 'logo',['options'=>['class'=>'col-lg-6 col-md-12 mt-3']])->fileInput()->label('<div>Logo: </div> <div class=" alert-warning" style="padding:4px; border-radius: 2px;"><small><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Tamaño del Logo: 770px X 770px (Ancho x Alto)</small></div>',['class'=>'col-12']) ?>
                <div id="preview_logo" class="col-lg-5 col-md-12" align="center"></div>
            </div>
            <!-- <div class="card-body row">
                <?php //echo $form->field($model, 'img_favicon')->hiddenInput()->label(false); ?>
                <?php //echo $form->field($model, 'favicon',['options'=>['class'=>'col-lg-6 col-md-12 mt-3']])->fileInput()->label('<div>Favicon: </div> <div class=" alert-warning" style="padding:4px; border-radius: 2px;"><small><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Tamaño del favicon: 48px X 48px (Ancho x Alto)</small></div>',['class'=>'col-12']) ?>
                <div id="preview_favicon" class="col-lg-6 col-md-12 mt-3" align="center"></div>
            </div> -->
            <div class="card-body row">
                <?php echo $form->field($model, 'img_background')->hiddenInput()->label(false); ?>
                <?php echo $form->field($model, 'backgroundimg',['options'=>['class'=>'col-lg-6 col-md-12 mt-3']])->fileInput()->label('<div>Login (Imagen de fondo): </div> <div class=" alert-warning" style="padding:4px; border-radius: 2px;"><small><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Tamaño del favicon: 1980px X 1980px (Ancho x Alto)</small></div>',['class'=>'col-12']) ?>
                <div id="preview_backlogin" class="col-lg-6 col-md-12 mt-3" align="center"></div>
            </div>
            <div class="card-body row">
                <div class="col-12">
                    <h2>Redes Sociales</h2>
                </div>
                <?php echo $form->field($model, 'whatsapp',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'instagram',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'facebook',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'youtube',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'tiktok',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'video',['options'=>['class'=>'col-lg-6 col-12 mt-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class=" card-footer" align="right">
                <?php echo Html::submitButton('<i class="fas fa-check-circle"></i> Guardar Información', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$script = <<< JS

    $(function(e){
        var previewLogo = '/$model->logo';
        image = document.createElement('img');
        image.src = previewLogo;
        image.classList.add('img-fluid');
        preview_logo.innerHTML = '';
        preview_logo.append(image);
        
        var previewFavicon = '/$model->favicon';
        image = document.createElement('img');
        image.src = previewFavicon;
        image.classList.add('img-fluid');
        preview_favicon.innerHTML = '';
        preview_favicon.append(image);
        
        var previewLogin = '/$model->backgroundimg';
        image = document.createElement('img');
        image.src = previewLogin;
        image.classList.add('img-fluid');
        preview_backlogin.innerHTML = '';
        preview_backlogin.append(image);
    });

    document.getElementById("config-logo").onchange = function(e) {
        if(e.target.files[0] === undefined){
            document.getElementById('preview_logo').innerHTML = "";
        }else{
            let reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = function(){
                let preview = document.getElementById('preview_logo'),
                    image = document.createElement('img');

                image.src = reader.result;
                image.classList.add('img-fluid');

                preview.innerHTML = '';
                preview.append(image);
            };
        }
    }

    document.getElementById("config-favicon").onchange = function(e) {
        if(e.target.files[0] === undefined){
            document.getElementById('preview_favicon').innerHTML = "";
        }else{
            let reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = function(){
                let preview = document.getElementById('preview_favicon'),
                    image = document.createElement('img');

                image.src = reader.result;
                image.classList.add('img-fluid');

                preview.innerHTML = '';
                preview.append(image);
            };
        }
    }
    
    document.getElementById("config-backgroundimg").onchange = function(e) {
        if(e.target.files[0] === undefined){
            document.getElementById('preview_backlogin').innerHTML = "";
        }else{
            let reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = function(){
                let preview = document.getElementById('preview_backlogin'),
                    image = document.createElement('img');

                image.src = reader.result;
                image.classList.add('img-fluid');

                preview.innerHTML = '';
                preview.append(image);
            };
        }
    }

    
JS;
$this->registerJs($script);