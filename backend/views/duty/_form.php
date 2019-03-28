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

                <?= $form->field($model, 'leader')->dropDownList(["贾先华" => "贾先华","刘钰坤"=>"刘钰坤","牛志军"=>"牛志军",
                "廖芳芳" => "廖芳芳", "唐育平" =>"唐育平","黄杨敏" => "黄杨敏"
                ]) ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'master')->dropDownList(["二大队" => "二大队", "三大队" => "三大队", "四大队" => "四大队", ]) ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'second')->dropDownList(["二大队" => "二大队", "三大队" => "三大队", "四大队" => "四大队", ]) ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'three')->dropDownList(["二大队" => "二大队", "三大队" => "三大队", "四大队" => "四大队", ]) ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'gun')->textInput(['maxlength' => true]) ?>
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