<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Duty */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Duty'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Duty')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
