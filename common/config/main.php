<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mutex' => [
            'class'     => 'yii\mutex\FileMutex',
            'mutexPath' => '@common/runtime/mutex', //Debe exister para almacenar los archivos filemutex
        ],
    ],
];
