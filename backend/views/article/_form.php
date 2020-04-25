<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 15:49
 */

/**
 * @var $this yii\web\View
 * @var $model backend\models\Article
 */

use backend\widgets\ActiveForm;
use common\models\Category;
use common\libs\Constants;
use common\widgets\JsBlock;
use backend\widgets\Ueditor;

$this->title = "Articles";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <div class="row form-body form-horizontal m-t">
                    <div class="col-md-12 droppable sortable ui-droppable ui-sortable" style="display: none;">
                    </div>
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'form-horizontal'
                        ]
                    ]); ?>

                    <!--left start-->
                    <div class="col-md-7 droppable sortable ui-droppable ui-sortable" style="">
                        <?= $form->field($model, 'title')->textInput(); ?>
                        <?= $form->field($model, 'sub_title')->textInput(); ?>
                        <?= $form->field($model, 'summary')->textArea(); ?>
                        <?= $form->field($model, 'thumb')->imgInput(['style' => 'max-width:200px;max-height:200px']); ?>
                        <?= $form->field($model, 'content')->widget(Ueditor::className()) ?>
                    </div>
                    <!--left stop -->

                    <div class="col-md-5 droppable sortable ui-droppable ui-sortable" style="">
                        <div class="ibox-title">
                            <h5><?= Yii::t('app', 'Category') ?></h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12 col-sm-offset-1">
                                        <?= $form->field($model, 'cid', ['size'=>10])->label(false)->chosenSelect(Category::getCategoriesName())?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--属性设置start-->
                    <div class="col-md-5 droppable sortable ui-droppable ui-sortable" style="">
                        <div class="ibox-title">
                            <h5><?= Yii::t('app', 'Attributes') ?></h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        &nbsp;
                                        <?= $form->field($model, 'flag_slide_show', ['options'=>['tag'=>'span']])->checkbox() ?>
                                        &nbsp;
                                        <?= $form->field($model, 'flag_special_recommend', ['options'=>['tag'=>'span']])->checkbox() ?>
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--属性设置stop-->




		<?php
			$userid = Yii::$app->getUser()->id;
			if($userid == 1 || $userid == 3) {
		?>
		    <div class="col-md-5 droppable sortable ui-droppable ui-sortable" style="">
			<div class="ibox-title">
			    <h5><?= Yii::t('app', 'Other') ?></h5>
			    <div class="ibox-tools">
				<a class="collapse-link">
				    <i class="fa fa-chevron-up"></i> </a> <a class="close-link">
				    <i class="fa fa-times"></i>
				</a>
			    </div>
			</div>
			<div class="ibox-content">
			    <div class="row">
                    <div class="col-sm-12">
					<?= $form->field($model, 'status', [
					'size' => 7,
					'labelOptions' => ['class' => 'col-sm-2 control-label']
					    ])->dropDownList(Constants::getArticleStatus()); ?></div>
                   <?= $form->field($model, 'sort')->textInput(); ?>

		<?php
			}else{
	
		?>
		    <div class="col-md-5 droppable sortable ui-droppable ui-sortable" style="">
			<div class="ibox-content">
				<input type="hidden" name="Article[status]" value="0">
		<?php
			}
		?>
					
                            <?= $form->defaultButtons(['size' => 12]) ?>
                        </div>
                    </div>
                    <?php $form = ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
