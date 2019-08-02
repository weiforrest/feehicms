<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-14 12:09
 */

use common\libs\Constants;
use yii\widgets\DetailView;

/**
 * @var $model backend\models\Article
 */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'category',
            'value' => function($model){
                return $model->category === null ? "-" : $model->category->name;
            }
        ],
        'title',
        'sub_title',
        'summary',
        [
            'attribute' => 'thumb',
            'format' => 'raw',
            'value' => function($model){
                return "<img style='max-width:200px;max-height:200px' src='" . $model->thumb . "' >";
            }
        ],
        [
            'attribute' => 'status',
            'value' => function($model){
                return Constants::getStatusItems($model->status);
            }
        ],
        'sort',
        'author_id',
        'author_name',
        'scan_count',
        [
            'attribute' => 'flag_headline',
            'value' => function($model){
                return Constants::getYesNoItems($model->flag_headline);
            }
        ],
        [
            'attribute' => 'flag_recommend',
            'value' => function($model){
                return Constants::getYesNoItems($model->flag_recommend);
            }
        ],
        [
            'attribute' => 'flag_bold',
            'value' => function($model){
                return Constants::getYesNoItems($model->flag_bold);
            }
        ],
        [
            'attribute' => 'flag_picture',
            'value' => function($model){
                return Constants::getYesNoItems($model->flag_picture);
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'content',
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>