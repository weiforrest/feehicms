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
use frontend\widgets\CategoryBar;
use common\models\Category;

// IndexAsset::register($this);
$this->title = Yii::$app->feehi->website_title;
?>

    <?php if($parent_id) {
            $parent =  Category::findone(['id' => $parent_id]);
        ?>
        <div class="col-sm-3">
            <div class="category_list">
                <h1 style="padding:5px 0px"><?=$parent->name?></h1>
                <?= CategoryBar::widget(['parent_id'=> $parent_id]) ?>
            </div>
        </div>
        <div class="col-sm-9">
   <?php } else { ?>

        <div style="width:800px;margin:0 auto">
    <?php } ?>
            <div class="category_list">
            <h1><?=$name?></h1>
            <?= ArticleListView::widget([
                'dataProvider' => $dataProvider,
            ]) ?>
        </div>
        </div>
    </div>
