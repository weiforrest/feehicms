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
use frontend\assets\IndexAsset;
use yii\data\ArrayDataProvider;
use common\models\Category;
use yii\helpers\ArrayHelper;
use frontend\widgets\DutyView;
use frontend\widgets\AdView;
use frontend\widgets\SideAdView;
use frontend\widgets\PicView;
use yii\helpers\Url;

// IndexAsset::register($this);
$this->title = Yii::$app->feehi->website_title;
?>
    <div class="content">
        <div class="side col-md-5" data-ride="carousel">
            <?= ScrollPicView::widget([
                'banners' => Article::find()->limit(7)->where(['type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED, 'flag_slide_show'=> 1])->orderBy("created_at desc")->asArray()->all(),
            ]) ?>
        </div>

        <?php 
            $categorys = Category::find()
                ->where(['is_display'=> Category::DISPLAY_YES])
                ->orderBy("sort asc,parent_id asc")
                ->asArray()
                ->all();
            $index = 0;
            foreach($categorys as $category) {
                $descendants = Category::getDescendants($category['id']);
                $cids= [];
                if( empty($descendants) ) {
                    $cids = $category['id'];
                }else{
                    $cids = ArrayHelper::getColumn($descendants, 'id');
                    $cids[] = $category['id'];
                }
                $where = ['type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED, 'cid' => $cids];
                $articles = Article::find()->limit(10)->with('category')->where($where)->orderBy("created_at desc")->all();
                ?>
                <div class="col-md-<?= (($index) ? "4" : "5") ?>">
                    <div class="category" >
                        <h4 class="tip"><div><?= $category["name"]?></div> <div class="pull-right" style="padding:0;background:#f5f5f5;color:#2985e0;"><a href="<?= Url::to(['article/index', 'cat'=> $category['alias']])?>">更多</a></div></h4>
                            <?= ArticleListView::widget([
                            'dataProvider' => new ArrayDataProvider([
                                'allModels' => $articles,
                            ]),
                            'layout' => " <ul>
                                                {items}
                                            </ul>
                                        ",
                            'template' => "<a target='_blank' href='{article_url}'><p>{title}</p></a>
                                                <span class='pull-right'>{pub_date}</span>",
                            'dateformat'=>'m-d',
                            'itemOptions' => ['tag'=>'li'],
                            'thumbWidth' => 168,
                            'thumbHeight' => 112,
                        ]) ?>
                    </div>
                </div>
            <?php

                switch($index) {
                case 0:
                    ?>
                    <div class="col-md-2">
                        <?= DutyView::widget();?>
                    </div>
                    <div class="col-md-4">
                        <?= NoticeView::widget();?>
                    </div>
                <?
                break;
                case 2:
                ?>
                <div class="col-md-12" style="margin-bottom:15px">
                    <?=AdView::widget();?>
                </div>
            <?php
                break;
                }
            $index++;
            }
            
            ?>
            <div>
                <?= SideAdView::widget();?>
            </div>
            <div class="col-md-12">
                    <?=PicView::widget(['name' => 'index']);?>
                </div>
            </div>

        </div>