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
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=database;dbname=hadiah',
        ],
        'mutex' => [
            'class' => 'yii\mutex\MysqlMutex'
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'America/Mexico_City',
        ],
        'pjax' => [
            'class' => 'yii\widgets\Pjax',
            'enablePushState' => false,
        ],
    ],
];
