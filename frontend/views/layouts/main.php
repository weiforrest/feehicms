<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use frontend\widgets\MenuView;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php !isset($this->metaTags['keywords']) && $this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->feehi->seo_keywords], 'keywords');?>
    <?php !isset($this->metaTags['description']) && $this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->feehi->seo_description], 'description');?>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
</head>
<?php $this->beginBody() ?>
<body class="home blog">
<?= $this->render('/widgets/_flash') ?>
<header id="masthead" class="site-header">
    <nav id="top-header">
        <div class="top-nav">
            <div id="user-profile">
                <span class="nav-set">
                    <span class="nav-login">
                        <?php
                        if (Yii::$app->getUser()->getIsGuest()) {
                            ?>
                            <a href="<?= Url::to(['site/login']) ?>" class="signin-loader"><?= Yii::t('frontend', 'Hi, Log in') ?></a>&nbsp; &nbsp;
                        <?php } else { ?>
                            Welcome, <?= Html::encode(Yii::$app->user->identity->username) ?>
                            <a href="<?= Url::to(['site/logout']) ?>" class="signup-loader"><?= Yii::t('frontend', 'Log out') ?></a>
                        <?php } ?>
                    </span>
                </span>
            </div>
            <div class="menu-container">
                <ul id="menu-page" class="top-menu">
                    <a target="_blank" href="<?=Url::to(['page/view', 'name'=>'about'])?>"><?= Yii::t('frontend', 'About us') ?></a>
                    |
                    <a target="_blank" href="<?=Url::to(['page/view', 'name'=>'contact'])?>"><?= Yii::t('frontend', 'Contact us') ?></a>
                </ul>
            </div>
        </div>
    </nav>
    <div id="nav-header" class="">
        <div id="top-menu">
            <div id="top-menu_1">
                <span class="nav-search_1"><i class="fa fa-navicon"></i></span>
                <hgroup class="logo-site">
                    <h1 class="site-title">
                        <a href="<?= Yii::$app->getHomeUrl() ?>"><img style="height:175px" src="<?=Yii::$app->getRequest()->getBaseUrl()?>/static/images/logo.png" alt="<?= Yii::$app->feehi->website_title ?>"></a>
                    </h1>
                </hgroup>
            </div>
        </div>
    </div>
    <div id="site-nav-wrap">
        <nav id="site-nav" class="main-nav">
            <div>
                <?= MenuView::widget() ?>
                <span class="nav-search"><i class="fa fa-search"></i></span>
            </div>
        </nav>
    </div>
    <?= MenuView::widget([
        'template' => '<nav><ul class="nav_sj" id="nav-search_1">{lis}</ul></nav>',
        'liTemplate' => "<li class='menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-{menu_id}'><a href='{url}'>{title}</a>{sub_menu}</li>"
    ]) ?>
</header>

<div id="search-main">
    <div id="searchbar">
        <form id="searchform" action="<?= Url::toRoute('search/index') ?>" method="get">
            <?= Yii::$app->getUrlManager()->enablePrettyUrl ? "" : "<input type='hidden' name='" . Yii::$app->getUrlManager()->routeParam . "' value='search/index'>" ?>
            <input id="s" type="text" name="q" value="<?= Html::encode(Yii::$app->getRequest()->get('q')) ?>" required="" placeholder="<?= Yii::t('frontend', 'Please input keywords') ?>" name="s" value="">
            <button id="searchsubmit" type="submit"><?= Yii::t('frontend', 'Search') ?></button>
        </form>
    </div>
    <div class="clear"></div>
</div>

<section class="container">
    <div class="speedbar"></div>
    <?= $content ?>
</section>


<footer class="footer">
    <div class="footer-inner">
        <p>
            宜春市公安局特巡警支队 <?= Yii::t('frontend', 'Copyright, all rights reserved') ?> © <?=date('Y')?>&nbsp;&nbsp;
        </p>
        <p><?=Yii::$app->feehi->website_icp?> Powered by 宜春市公安局特巡警支队政治处</p>
    </div>
</footer>

<div class="rollto" style="display: none;">
    <button class="btn btn-inverse" data-type="totop" title="back to top"><i class="fa fa-arrow-up"></i></button>
</div>

</body>
<?php $this->endBody() ?>
<?php
if (Yii::$app->feehi->website_statics_script) {
    echo Yii::$app->feehi->website_statics_script;
}
?>
</html>
<?php $this->endPage() ?>