<?php
namespace frontend\widgets;
use yii\bootstrap\Carousel;
use yii\helpers\Url;
use yii\helpers\StringHelper;

class ScrollPicView extends \yii\base\Widget
{

    public $banners;

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $items=[];
        foreach ($this->banners as $banner) {
            $items[] = [
                'content' => '<a target="_blank" href="'.Url::to(['article/view','id' =>$banner['id']]).'"><img style="width:100%;height:300px" src="'.$banner['thumb'].'"></a>',
                'caption' => '<p>'.StringHelper::truncate($banner['title'],25).'</p>',
            ];
        }
        return Carousel::widget([
            'controls' => [
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true">',
                '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true">',

            ],
            'items' => $items,
        ]);
    }

}