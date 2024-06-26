<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

// use \yii\web\Request;

// $baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
    'language' => 'az',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        [
            'class' => 'frontend\components\LanguageSelector',
        ],
    ],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => '/main/index',
    'homeUrl' => '',
    'components' => [
        // 'assetManager' => [
        //     'basePath' => '@webroot/assets',
        //     'baseUrl' => '@web/assets'
        // ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            // 'class' => 'common\components\Request',
            // 'web' => '/frontend/web',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'main/error',
        ],
        'i18n' => [
            'translations' => [
                'samba' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    // 'sourceLanguage' => 'en',
                ],
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'en-US',
                ]
            ],
        ],
        'urlManager' => [
            'scriptUrl' => '/index.php',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // 'suffix' => '/',
            'rules' => [
                // '' => 'main/index',
                // '<action:\w+>' => '/main/<action>',
                // '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
                'categories/<id:\d+>' => 'main/categories',
                'categories/' => 'main/main',
                'product/<id:\d+>/<headCateg:\d+>' => 'main/product',
                'about' => 'main/about',
                'contact' => 'main/contact',
                'sitemap.xml' => 'sitemap/index',
            ],
        ],
    ],
    'params' => $params,
];
