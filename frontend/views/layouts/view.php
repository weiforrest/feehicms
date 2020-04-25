
<?php

use yii\helpers\Html;
?>

<?php $this->beginPage() ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<META content="IE=5.0000" http-equiv="X-UA-Compatible">
<title><?= Html::encode($this->title) ?></title>
<META http-equiv="Content-Language" content="zh-ch"> 
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"> 
<?= Html::csrfMetaTags() ?>
<meta name="GENERATOR" content="MSHTML 11.00.9600.16661">
<style>
img {
    max-width: 600px;
}
</style>
</HEAD> 
<?php $this->beginBody() ?>
<BODY topmargin="0" leftmargin="0" bgcolor="#999999" marginwidth="0" marginheight="0">
    <?= $content ?>
</BODY>
<?php $this->endBody()?>
</HTML>
