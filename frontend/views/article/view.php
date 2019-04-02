<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-02 22:55
 */

/**
 * @var $this yii\web\View
 * @var $model frontend\models\Article
 * @var $commentModel frontend\models\Comment
 * @var $prev frontend\models\Article
 * @var $next frontend\models\Article
 * @var $recommends array
 * @var $commentList array
 */

use frontend\widgets\ArticleListView;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use frontend\assets\ViewAsset;
use common\widgets\JsBlock;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $model->title;

$this->registerMetaTag(['name' => 'keywords', 'content' => $model->seo_keywords], 'keywords');
$this->registerMetaTag(['name' => 'description', 'content' => $model->seo_description], 'description');
$this->registerMetaTag(['name' => 'tags', 'content' => call_user_func(function()use($model) {
    $tags = '';
    foreach ($model->articleTags as $tag) {
        $tags .= $tag->value . ',';
    }
    return rtrim($tags, ',');
    }
)], 'tags');
$this->registerMetaTag(['property' => 'article:author', 'content' => $model->author_name]);
$categoryName = $model->category ? $model->category->name : Yii::t('app', 'uncategoried');

//传递分类到layout中
Yii::$app->params['category']= $model->category->alias;

ViewAsset::register($this);
?>
<div class="content-wrap">
    <div class="content">
        <div class="breadcrumbs">
            <a title="<?=Yii::t('frontend', 'Return Home')?>" href="<?= Yii::$app->getHomeUrl() ?>"><i class="fa fa-home"></i></a>
            <small>&gt;</small>
            <a href="<?= Url::to(['article/index', 'cat' => $model->category->alias]) ?>"><?= $categoryName ?></a>
            <small>&gt;</small>
            <span class="muted"><?= $model->title ?></span>
        </div>
        <header class="article-header">
            <h1 class="article-title"><?= $model->title ?></h1>
            <div class="meta">
                <span class="muted"><i class="fa fa-user"></i> <?= $model->author_name ?></span>
                <time class="muted"><i class="fa fa-clock-o"></i> <?= Yii::$app->getFormatter()->asDate($model->created_at) ?></time>
                <span class="muted"><i class="fa fa-eye"></i> <span id="scanCount"><?= $model->scan_count * 100 ?></span>℃</span>
                <span class="muted"><i class="fa fa-comments-o"></i>
                    <a href="<?= Url::to([
                        'article/view',
                        'id' => $model->id
                    ]) ?>#comments">
                        <span id="commentCount"><?= $model->comment_count ?></span>
                    <?=Yii::t('frontend', 'Comment')?></a>
                </span>
            </div>
        </header>

        <article class="article-content">
            <?= $model->articleContent->content ?>

            <div class="article-social">
                <a href="javascript:;" data-action="ding" data-id="<?=$model->id?>" like-url="<?=Url::to(['article/like'])?>" id="Addlike" class="action"><i class="fa fa-heart-o"></i><?=Yii::t('frontend', 'Like')?> (<span class="count"><?= $model->getArticleLikeCount() ?></span>)</a>
            </div>
        </article>
        <footer class="article-footer">
            <div class="article-tags">
                <i class="fa fa-tags"></i>
                <?php foreach ($model->articleTags as $tag){ ?>
                    <a href="<?=Url::to(['search/tag', 'tag'=>$tag->value])?>" rel="tag" data-original-title="" title=""><?=$tag->value?></a>
                <?php } ?>
            </div>
        </footer>
        <nav class="article-nav">
            <?php
                if ($prev !== null) {
            ?>
                <span class="article-nav-prev">
                    <i class="fa fa-angle-double-left"></i><a href='<?= Url::to(['article/view', 'id' => $prev->id]) ?>' rel="prev"><?= $prev->title ?></a>
                </span>
            <?php } ?>
            <?php
                if ($next != null) {
            ?>
                <span class="article-nav-next">
                    <a href="<?= Url::to(['article/view', 'id' => $next->id]) ?>" rel="next"><?= $next->title ?></a><i class="fa fa-angle-double-right"></i>
                </span>
            <?php } ?>
        </nav>

        </div>
    </div>
</div>
<?php JsBlock::begin(); ?>
<script type="text/javascript">
    SyntaxHighlighter.all();
    $(document).ready(function () {
        $.ajax({
            url:"<?=Url::to(['article/view-ajax'])?>",
            data:{id:<?=$model->id?>},
            success:function (data) {
                $("span.count").html(data.likeCount);
                $("span#scanCount").html(data.scanCount);
                $("span#commentCount").html(data.commentCount);
            }
        });
    })
</script>
<script>with(document)0[(getElementsByTagName("head")[0]||body).appendChild(createElement("script")).src="http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion="+~(-new Date()/36e5)];</script>
<?php JsBlock::end(); ?>
