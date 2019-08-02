<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $type string
 */

use frontend\widgets\ArticleListView;
use frontend\modules\zhuanlan\widgets\CategoryBar;

// IndexAsset::register($this);
$this->title = Yii::$app->feehi->website_title;
?>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
            <div class="category">
                <h4 class="tip" style="font-size:20px;padding-top:5px;padding-bottom:5px">专栏</h4>
                <?= CategoryBar::widget() ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
        <div class="category_list">
        <h1><?=$type?></h1>
        <?= ArticleListView::widget([
            'dataProvider' => $dataProvider,
        ]) ?>
        </div>
        </div>
    </div>
