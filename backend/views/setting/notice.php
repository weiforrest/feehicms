<?php
/* @var $this \yii\web\View
 * @var $model common\models\Options
 */

use backend\widgets\ActiveForm;

$this->title = Yii::t('app', 'Notice Setting');
$this->params['breadcrumbs'][] = Yii::t('app', 'Notice Setting');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <?=$this->render('/widgets/_ibox-title')?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'notice')->textarea() ?>
                <div class="hr-line-dashed"></div>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
