<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'v1' => [
            'class' => \app\api\v1\Module::class,
        ],
    ],
    'components' => [
        'request' => [
            'enableCsrfValidation' => false,
            'enableCookieValidation' => false,
            'parsers' => [
                //can accept json request.
                'application/json' => yii\web\JsonParser::class,
            ],
        
        ],
        'response' => [
            'as beforeSend' => [
                'class' => \app\components\ResponseFormatter::class,
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => null,
            'enableSession' => false,
        ],
        'errorHandler' => [
            'class' => \app\components\ErrorHandler::class,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'ruleConfig' => [
                'class' => \yii\rest\UrlRule::class,
            ],
            'rules' => [
                //site
                [
                    'class' => \yii\web\UrlRule::class,
                    'pattern' => '',
                    'route' => 'site/doc',
                ],
                [
                    'class' => \yii\web\UrlRule::class,
                    'pattern' => 'site/api',
                    'route' => 'site/api',
                ],
                
                //api.v1
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => 'v1/default',
                    'extraPatterns' => [
                        'POST query' => 'query',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
