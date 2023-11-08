<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
//use yii\bootstrap4\Html;
/*use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;*/

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:description" content="" />

    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl ?>favicon.ico" type="image/x-icon">
</head>
<body>
<?php $this->beginBody() ?>
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">
        <h1 class="logo me-auto"><a href="/" class="text-danger">🍀 RIFAS PABMAN 🍀</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="/" class="logo me-auto">
             <?php // echo Html::img('@web/images/pabmanlogo.png',['alt'=>'LOGO PABMAN','class'=>'',]); ?>
        </a> -->

        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="/" class="active fs-6">Inicio</a></li>
                <li><a href="/#quienessomos" class="fs-6">Quienes Somos</a></li>
                <li><a href="/#faq" class="fs-6">Preguntas Frecuentes</a></li>
                <li><a href="/#about" class="fs-6">Nosotros</a></li>
                <li><a href="/#contactus" class="fs-6">Contacto</a></li>
                <li><a href="/#team" class="getstarted fs-6">Comprar Boletos</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->

<?= $content ?>

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>RIFAS PABMAN</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/sailor-free-bootstrap-theme/ -->
            Designed by <a href="/">AHR</a>
        </div>
    </div>
</footer>
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();