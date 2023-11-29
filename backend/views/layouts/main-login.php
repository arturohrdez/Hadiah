<?php
use app\models\Config;

/* @var $this \yii\web\View */
/* @var $content string */
\hail812\adminlte3\assets\AdminLteAsset::register($this);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
$this->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
\hail812\adminlte3\assets\PluginAsset::register($this)->add(['fontawesome', 'icheck-bootstrap']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hadiah | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<?php 
//Busca registros en la tabla Config
$searchConfig = Config::find()->count();
if($searchConfig > 0){
    $modelConfig     = Config::find()->one();
    $loginBackground = !empty($modelConfig->backgroundimg) ? $modelConfig->backgroundimg : false;

    if(!$loginBackground){
        $class_background = "bg-gradient-primary";
        $style_background = "";
    }else{
        $class_background = "";
        $style_background = "background-image: url('/".$loginBackground."'); background-size:cover; background-repeat: no-repeat; ";
    }
}else{
    $class_background = "bg-gradient-primary";
    $style_background = "";
}//end if


?>
<body class="hold-transition login-page <?php echo $class_background; ?>" style="<?php echo $style_background; ?>">
<?php  $this->beginBody() ?>
<div class="login-box">
    <!-- <a href="<?=Yii::$app->homeUrl?>">
        <b class="text-white">HADIAH</b> 
        </br> 
        <span class="text-white">Sistema de Rifas</span>
    </a> -->
    <div class="card card-outline card-danger">
        <div class="card-header text-center">
            <div class="h1 text-dark"><b>HADIAH</b></div>
            <div class="h4 text-dark">Sistema de Rifas</div>
        </div>
        <?= $content ?>
    </div>

</div>
<!-- /.login-box -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>