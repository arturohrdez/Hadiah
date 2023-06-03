<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/vendor/bootstrap/css/bootstrap.min.css',
        'css/vendor/animate.css/animate.min.css',
        'css/vendor/bootstrap-icons/bootstrap-icons.css',
        'css/vendor/boxicons/css/boxicons.min.css',
        'css/vendor/glightbox/css/glightbox.min.css',
        'css/vendor/remixicon/remixicon.css',
        'css/vendor/remixicon/remixicon.css',
        'css/vendor/swiper/swiper-bundle.min.css',
        'css/style.css',
    ];
    public $js = [
        'js/main.js',
        'js/vendor/bootstrap.bundle.min.js',
        'js/vendor/glightbox.min.js',
        'js/vendor/isotope.pkgd.min.js',
        'js/vendor/swiper-bundle.min.js',
        'js/vendor/noframework.waypoints.js',
        'js/list.js'
        //'js/vendor/php-email-form/validate.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
