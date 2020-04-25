<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use frontend\widgets\MenuView;
use frontend\models\FriendlyLink;
use common\widgets\JsBlock;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php !isset($this->metaTags['keywords']) && $this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->feehi->seo_keywords], 'keywords'); ?>
    <?php !isset($this->metaTags['description']) && $this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->feehi->seo_description], 'description'); ?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="renderer" content="webkit">
    <?= Html::csrfMetaTags() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
</head>
<?php $this->beginBody() ?>

<body class="home blog">
    <?= $this->render('//widgets/_flash') ?>
    <div id="masthead" class="site-header">
        <nav id="top-header">
            <div class="top-nav">
                <div id="user-profile">
                    <div id="links" style="display:inline">
                        <span  class="flink">导航链接</span>
                            <div id="daohang" class="fr_link hide">
                                <?php 
                                $links = FriendlyLink::find()->where(['status' => FriendlyLink::DISPLAY_YES])->orderBy("sort asc, id asc")->asArray()->all();
                                foreach ($links as $link) {
                                    echo "<a target='_blank' href='{$link['url']}'>{$link['name']}</a>";
                                }
                                ?>
                            </div>
                        </div>
                </div>
                <div class="menu-container">
                    <ul id="menu-page" class="top-menu">
                        <a target="_blank" href="<?= Url::to(['page/view', 'name' => 'about']) ?>"><?= Yii::t('frontend', 'About us') ?></a>
                        |
                        <a target="_blank" href="<?= Url::to(['page/view', 'name' => 'contact']) ?>"><?= Yii::t('frontend', 'Contact us') ?></a>
                        |
                        <a id="adminurl" target="_blank" href="/admin"><?= "后台管理" ?></a>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="nav-header"></div>
        <div id="site-nav-wrap">
            <nav id="site-nav" class="main-nav">
                <div>
                    <?= MenuView::widget() ?>
                    <span class="nav-search"><i class="fa fa-search"></i></span>
                </div>
            </nav>
        </div>
    </div>

    <div id="search-main">
        <div id="searchbar">
            <form id="searchform" action="<?= Url::toRoute('search/index') ?>" method="post">
                <input id="s" type="text" name="q" value="<?= Html::encode(Yii::$app->getRequest()->post('q')) ?>" required="" placeholder="<?= Yii::t('frontend', 'Please input keywords') ?>" name="s" value="">
                <input type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>" name="_csrf">
                <button id="searchsubmit" type="submit"><?= Yii::t('frontend', 'Search') ?></button>
            </form>
        </div>
        <div class="clear"></div>
    </div>

    <div class="container" style="min-height:400px">
        <?= $content ?>
    </div>


    <div class="footer">
        <div class="footer-inner">
            <p>
                宜春市公安局特警支队 <?= Yii::t('frontend', 'Copyright, all rights reserved') ?> © <?= date('Y') ?>&nbsp;&nbsp;
            </p>
            <p>为保证最佳的浏览体验，请使用Google Chrome浏览器</p>
            <p><?= Yii::$app->feehi->website_icp ?> Powered by 宜春市公安局特警支队政治处</p>
        </div>
    </div>

</body>
<?php $this->endBody() ?>

<?php JsBlock::begin() ?>
<script>
    $(function() {
        $('.flink').bind("mouseover", function() {
            $(this).addClass("cur");
            $("#daohang").removeClass("hide");
        });
        $('#links').bind("mouseleave", function() {
            $("#daohang").addClass("hide");
            $(".flink").removeClass("cur");
        });
        $(".nav-search").click(function () {
            $(".nav-search").toggleClass("active");
            $("#search-main").fadeToggle(250);
            // setTimeout(function () {
            //     a("#search-main input").focus()
            // }, 300)
        });

    });
</script>
<?php JsBlock::end() ?>

</html>
<?php $this->endPage() ?> 