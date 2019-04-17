<?php
namespace frontend\widgets;

use backend\models\form\AdForm;
use Yii;
use yii\helpers\HTML;

class AdView extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $ad = AdForm::findOne(['type'=>AdForm::TYPE_AD,'name' => 'main','autoload'=> 1]);
        // return var_dump($ad);
        $body = "";
        if ($ad) {
            $body = HTML::a(HTML::img($ad->ad,['alt' => $ad->desc]),$ad->link,['target' => $ad->target]);
            // $body = "<div class='duty'>
            //     <div class='tip'>
            //     <h4>" . date("Y-m-d") . " 值班安排</h4>
            //     </div>
            // <p>" . $duty->getAttributeLabel('leader') . ": <span>" . $duty->leader . "</span></p>
            // <p>" . $duty->getAttributeLabel('master') . ": <span>" . $duty->master . "</span></p>
            // <p>" . $duty->getAttributeLabel('second') . ": <span>" . $duty->second . "</span></p>
            // <p>" . $duty->getAttributeLabel('three') . ": <span>" . $duty->three . "</span></p>
            // <p>" . $duty->getAttributeLabel('gun') . ": <span>" . $duty->gun . "</span></p>
            //     </div> ";
        }
        return $body;
    }
}
