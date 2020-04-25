<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-06-21 11:07
 */

/**
 * @var $this yii\web\View
 * @var $model frontend\models\Article
 */

use frontend\models\Article;
use yii\helpers\Url;

$this->title = $model->title . '-' . Yii::$app->feehi->website_title;

$this->registerMetaTag(['name' => 'tags', 'content'=> call_user_func(function()use($model) {
    $tags = '';
    foreach ($model->articleTags as $tag) {
        $tags .= $tag->value . ',';
    }
    return rtrim($tags, ',');
}
)], 'tags');
?>
<div class="pagewrapper clearfix">
    <div class="pagecontent">
        <header class="pageheader clearfix">
            <h1 class="pull-left">
                <?= $model->title ?>
            </h1>
            <div class="pull-right">
            </div>
        </header>
        <div class="article-content">
            <?= $model->articleContent->content ?>
        </div>
    </div>
</div>
