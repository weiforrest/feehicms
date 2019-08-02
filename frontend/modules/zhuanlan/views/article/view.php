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
            </div>
        </header>

        <article class="article-content">
            <?= $model->articleContent->content ?>
        </article>
        <footer class="article-footer">
        </footer>
        <nav class="article-nav">
            <?php
                if ($prev !== null) {
            ?>
                <span class="article-nav-prev">
                    <i class="fa fa-angle-double-left"></i><a href='<?= Url::to(['/article/view', 'id' => $prev->id]) ?>' rel="prev"><?= $prev->title ?></a>
                </span>
            <?php } ?>
            <?php
                if ($next != null) {
            ?>
                <span class="article-nav-next">
                    <a href="<?= Url::to(['/article/view', 'id' => $next->id]) ?>" rel="next"><?= $next->title ?></a><i class="fa fa-angle-double-right"></i>
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
            }
        });
    })
</script>
<?php JsBlock::end(); ?>
