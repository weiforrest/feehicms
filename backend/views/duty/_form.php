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
                <?= $form->field($model, 'duty_time')->textInput(['readonly' => 'readonly']) ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'gun')->textarea() ?>
                <div class="hr-line-dashed"></div>

                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php JsBlock::begin() ?>
<script>
    //使用layui 的时间获取器
        laydate.render({
            elem: "#duty-duty_time",
            lang: "zh",
            showBottom:false,
        });
</script>
<?php JsBlock::end() ?> 