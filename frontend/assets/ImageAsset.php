<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace frontend\assets;

class ImageAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@frontend/web/static';

    public $css = [
        'css/baguetteBox.min.css',
        'css/gallery-clean.css',
    ];

    public $js = [
        'js/baguetteBox.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
