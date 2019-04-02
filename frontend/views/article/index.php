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

use frontend\models\Article;
use frontend\widgets\ArticleListView;
use frontend\widgets\ScrollPicView;
use frontend\widgets\NoticeView;
use common\widgets\JsBlock;
use frontend\assets\IndexAsset;
use yii\data\ArrayDataProvider;
use common\models\Category;
use frontend\widgets\DutyView;
use yii\helpers\Url;

// IndexAsset::register($this);
$this->title = Yii::$app->feehi->website_title;
?>
    <?php if($isIndex) { ?>
    <div class="content" >
        <div class="side col-xs-12 col-sm-6 col-md-6 col-lg-4" data-ride="carousel">
            <?= ScrollPicView::widget([
                'banners' => Article::find()->limit(7)->where(['type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED, 'flag_slide_show'=> 1])->orderBy("created_at desc")->asArray()->all(),
            ]) ?>
        </div>

        <?php 
            $categorys = Category::find()
                ->orderBy("sort asc,parent_id asc")
                ->asArray()
                ->all();
            $isright = true;
            //要闻
            $where = ['type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED, 'flag_special_recommend' => 1];
            $articles = Article::find()->limit(9)->with('category')->where($where)->orderBy("created_at desc")->all();
            // $articles = Article::find()->where(['flag_special_recommend' => 1])->limit(8)->orderBy("sort asc")->all();
            ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
                <div class="category">
                    <h4 class="tip"><?='特警要闻'?></h4>
                        <?= ArticleListView::widget([
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $articles,
                        ]),
                        'layout' => " <ul>
                                            {items}
                                        </ul>
                                    ",
                        'template' => "<a href='{article_url}'><p>{title}</p></a>
                                            <span class='pull-right'>{pub_date}</span>",
                        'itemOptions' => ['tag'=>'li'],
                        'thumbWidth' => 168,
                        'thumbHeight' => 112,
                    ]) ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?= DutyView::widget();?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                <?= NoticeView::widget();?>
            </div>
            <?php
            foreach($categorys as $category) {
            $where = ['type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED, 'cid' => $category["id"]];
            $articles = Article::find()->limit(9)->with('category')->where($where)->orderBy("created_at desc")->all();
                ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="category">
                    <h4 class="tip"><?= $category["name"]?> <a class="pull-right" href="<?= Url::to(['article/index', 'cat'=> $category['alias']])?>">更多</a></h4>
                        <?= ArticleListView::widget([
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $articles,
                        ]),
                        'layout' => " <ul>
                                            {items}
                                        </ul>
                                    ",
                        'template' => "<a href='{article_url}'><p>{title}</p></a>
                                            <span class='pull-right'>{pub_date}</span>",
                        'itemOptions' => ['tag'=>'li'],
                        'thumbWidth' => 168,
                        'thumbHeight' => 112,
                    ]) ?>
                </div>
            </div>
            <?php
            }

            ?>
                <?php } else {?>
        <div class="category_list">
        <h1><?=$type?></h1>
        <?= ArticleListView::widget([
            'dataProvider' => $dataProvider,
        ]) ?>
        </div>
        <?php }?>
    </div>
