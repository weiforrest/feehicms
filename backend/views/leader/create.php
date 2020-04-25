<?php

use yii\helpers\Url;
use common\models\Duty;


/* @var $this yii\web\View */
/* @var $model common\models\Duty */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Leader'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . yii::t('app', 'Duty')],
];
/*$model=Duty::find()->limit(1)->orderBy('duty_time desc')->one();
if($model){
$model->duty_time = date('Y-m-d',strtotime("$model->duty_time +1 day"));
$model->gun ='';
}else{
$model->duty_time = date('Y-m-d');
}*/

?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

