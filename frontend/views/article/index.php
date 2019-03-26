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

use common\models\Options;
use frontend\models\Article;
use frontend\widgets\ArticleListView;
use frontend\widgets\ScrollPicView;
use common\widgets\JsBlock;
use frontend\assets\IndexAsset;
use yii\data\ArrayDataProvider;
use common\models\Category;

IndexAsset::register($this);
$this->title = Yii::$app->feehi->website_title;
?>
<div class="content-wrap">
    <?php if($isIndex) { ?>
    <div class="content" style="width:1200px">
        <div class="slick_bor left">
            <?= ScrollPicView::widget([
                'banners' => Options::getBannersByType('index'),
            ]) ?>
            <div class="ws_shadow"></div>
        </div>

        <?php 
            $categorys = Category::find()
                ->orderBy("sort asc,parent_id asc")
                ->asArray()
                ->all();
            $isright = true;
            foreach($categorys as $category) {
            $where = ['type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED, 'cid' => $category["id"]];
            $articles = Article::find()->limit(9)->with('category')->where($where)->orderBy("created_at desc")->all();
                ?>

            <div class="zhuye <?= $isright? "right" : "left"?>">
            <div class='tip'><h4><?= $category["name"]?></h4></div>
            <?= ArticleListView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $articles,
                ]),
                'layout' => " <ul>
                                    {items}
                                </ul>
                             ",
                'template' => "<a href='{article_url}'>{title}</a>
                                    <span class='right'>{pub_date}</span><span class='clear'></span>",
                'itemOptions' => ['tag'=>'li'],
                'thumbWidth' => 168,
                'thumbHeight' => 112,
            ]) ?>
            </div>
            <?php if($isright){
                        echo '<div class="clear"></div>';
                        $isright = false;
                    }else{
                        $isright = true;
                    }
            }

            ?>
                <?php } else {?>
        <div class="content">
        <div class="daodu ">
        <header class="archive-header"><h1><?=$type?></h1></header>
        <?= ArticleListView::widget([
            'dataProvider' => $dataProvider,
        ]) ?>
        </div>
        <?php }?>
    </div>
</div>
<?php JsBlock::begin() ?>
<script>
    $(function () {
        var mx = document.body.clientWidth;
        $(".slick").responsiveSlides({
            auto: true,
            pager: true,
            nav: true,
            speed: 700,
            timeout: 7000,
            maxwidth: mx,
            namespace: "centered-btns"
        });
    });
</script>
<?php JsBlock::end() ?>
