<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',//应用id，必须唯一
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',//控制器命名空间
    'language' => 'zh-CN',//默认语言
    'timeZone' => 'Asia/Shanghai',//默认时区
    'bootstrap' => ['log'],
    'modules' => [
        'zhuanlan' => [
            'class' => 'backend\modules\zhuanlan\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => backend\models\User::className(),
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_backend_identity'],
            'idParam' => '__backend__id',
            'returnUrlParam' => '_backend_returnUrl',
        ],
        'session' => [
            'name' => 'BACKEND_FEEHICMS',
            'timeout' => 1440,//session过期时间，单位为秒
        ],
        'log' => [//此项具体详细配置，请访问http://wiki.feehi.com/index.php?title=Yii2_log
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::className(),//当触发levels配置的错误级别时，保存到日志文件
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/'.date('Y/m/d') . '.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'csrfParam' =>'_csrf_backend',
            'baseUrl' => '/admin',
        ],
        'i18n' => [
            'translations' => [//多语言包设置
                'app*' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@backend/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'menu' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@backend/messages',
                    'sourceLanguage' => 'zh-CN',
                    'fileMap' => [
                        'app' => 'menu.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'assetManager' => [
            'linkAssets' => false,//若为unix like系统这里可以修改成true则创建css js文件软链接到assets而不是拷贝css js到assets目录
            'bundles' => [
                backend\assets\AppAsset::className() => [
                    'sourcePath' => '@backend/web/static',
                    'css' => [
                        'a' => 'css/bootstrap.min14ed.css?v=3.3.6',
                        'b' => 'css/font-awesome.min93e3.css?v=4.4.0',
                        'c' => 'css/animate.min.css',
                        'd' => 'css/style.min862f.css?v=4.1.0',
                        'f' => 'js/plugins/layer/laydate/theme/default/laydate.css',
                        'g' => 'css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css',
                        'h' => 'css/plugins/toastr/toastr.min.css',
                        'i' => 'css/plugins/chosen/chosen.css',
                        'j' => 'css/feehi.css',

                    ],
                    'js' => [
                        'a' => 'js/feehi.js',
                        'b' => 'js/plugins/layer/laydate/laydate.js',
                        'c' => 'js/plugins/layer/layer.min.js',
                        'd' => 'js/plugins/prettyfile/bootstrap-prettyfile.js',
                        'e' => 'js/plugins/toastr/toastr.min.js',
                        'f' => 'js/plugins/chosen/chosen.jquery.js',
                    ],
                ],
                backend\assets\IndexAsset::className() => [
                    'sourcePath' => '@backend/web/static',
                    'css' => [
                        'a' => 'css/bootstrap.min.css',
                        'b' => 'css/font-awesome.min93e3.css?v=4.4.0',
                        'c' => 'css/style.min862f.css?v=4.1.0',
                    ],
                    'js' => [
                        'a' => "js/jquery.min.js?v=2.1.4",
                        'b' => "js/bootstrap.min.js?v=3.3.6",
                        'c' => "js/plugins/metisMenu/jquery.metisMenu.js",
                        'd' => "js/plugins/slimscroll/jquery.slimscroll.min.js",
                        'e' => "js/plugins/layer/layer.min.js",
                        'f' => "js/hplus.min.js?v=4.1.0",
                        'g' => "js/contabs.min.js",
                        'h' => "js/plugins/pace/pace.min.js",
                    ]
                ],
                backend\assets\UeditorAsset::className() => [
                    'sourcePath' => '@backend/web/static/js/plugins/ueditor',
                    'css' => [
                        'a' => 'ueditor.all.min.js'
                    ],
                ],
            ]
        ],
    ],
    'on beforeRequest' => [feehi\components\Feehi::className(), 'backendInit'],
    'as access' => [
        'class' => backend\components\AccessControl::className(),
        'allowActions' => [
            'site/login',
            'site/captcha',
            'site/error',
            'site/index',
            'site/main',
            'site/logout',
            'site/language',
            'admin-user/request-password-reset',
            'admin-user/reset-password',
            'admin-user/update-self',
            'assets/*',
            'debug/*',
            'gii/*',
            'page/a'
        ],
        'superAdminUserIds' => [1],//超级管理员用户id，拥有所有权限，不受权限管理的控制
    ],
    'params' => $params,
];
