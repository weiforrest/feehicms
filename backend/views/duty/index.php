<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\grid\DateColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Duties';
$this->params['breadcrumbs'][] = yii::t('app', 'Duty');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>

            <div class="ibox-content">
                <div>
                <?= Html::a('<i class="fa fa-male"></i> ' . Yii::t('app', 'Leader'), Url::to(['leader/index']), [
                    'title' => Yii::t('app', 'Leader'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-white btn-sm',
                ]);?>
                <?= Html::a('<i class="fa fa-refresh"></i> ' . Yii::t('app', 'Refresh'), Url::to(['refresh']), [
                    'title' => Yii::t('app', 'Refresh'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-white btn-sm refresh',
                ]);?>
                <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), Url::to(['create']), [
                    'title' => Yii::t('app', 'Create'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-white btn-sm',
                ]);?>
                <?= Html::a('<i class="fa fa-trash-o"></i> ' . Yii::t('app', 'Delete'), Url::to(['delete']), [
                    'title' => Yii::t('app', 'Delete'),
                    'data-pjax' => '0',
                    'data-confirm' => Yii::t('app', 'Really to delete?'),
                    'class' => 'btn btn-white btn-sm multi-operate',
                ]); ?>

                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => CheckboxColumn::className()],

                        'duty_time',
                         'gun',

                        ['class' => ActionColumn::className(),],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
