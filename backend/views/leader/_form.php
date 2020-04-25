<?php

use backend\widgets\ActiveForm;
use common\widgets\JsBlock;

/* @var $this yii\web\View */
/* @var $model common\models\Duty */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'name')->textInput() ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'tel')->textInput() ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'sort')->textInput(); ?>

                <div class="hr-line-dashed"></div>

                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>