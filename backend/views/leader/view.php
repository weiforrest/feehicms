<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Duty */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Leader', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="duty-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'name',
            'tel',
            'sort'
        ],
    ]) ?>

</div>
