<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'article/index',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' =>
        [
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => frontend\models\User::className(),
            'enableAutoLogin' => true,
        ],
        'session' => [
            'timeout' => 1440,//session过期时间，单位为秒
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::className(),
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/'.date('Y/m/d') . '.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cache' => [
            'class' => yii\caching\FileCache::className(),//使用文件缓存，可根据需要改成apc redis memcache等其他缓存方式
            'keyPrefix' => 'frontend',       // 唯一键前缀
        ],
        'urlManager' => [
            'enablePrettyUrl' => false,//true 美化路由(注:需要配合web服务器配置伪静态，详见http://doc.feehi.com/install.html), false 不美化路由
            'showScriptName' => false,//隐藏index.php
            'enableStrictParsing' => false,
            // 'suffix' => '.html',//后缀，如果设置了此项，那么浏览器地址栏就必须带上.html后缀，否则会报404错误
            'rules' => [
                //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                //'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>?id=<id>'
                //'detail/<id:\d+>' => 'site/detail?id=$id',
                //'post/22'=>'site/detail',
                //'<controller:detail>/<id:\d+>' => '<controller>/index',
                'cate/<cat:\w+>' =>'/article/index',
                '<page:\d+>' => 'article/index',
                'login' => 'site/login',
                'signup' => 'site/signup',
                'view/<id:\d+>' => 'article/view',
                'image/<name:\w+>'=>'image/view',
                'page/<name:\w+>' => 'page/view',
                'zhuanlan/<cat:\w+>' =>'zhuanlan/article/index',
                'zhuanlan/view/<id:\d+>' => 'zhuanlan/article/view',
                'comment' => 'article/comment',
                'search/<page:\d+>' => 'search/index',
                'tag/<tag:\w+>' => 'search/tag',
                'rss' => 'article/rss',
                'list/<page:\d+>' => 'site/index',
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@backend/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',

                    ],
                ],
                'front*' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@frontend/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'frontend' => 'frontend.php',
                        'app/error' => 'error.php',

                    ],
                ],
            ],
        ],
        'assetManager' => [
            'linkAssets' => true,
        ]
    ],
    'params' => $params,
    'on beforeRequest' => [feehi\components\Feehi::className(), 'frontendInit'],
];
