<?php
namespace frontend\widgets;

use backend\models\form\AdForm;
use yii\helpers\HTML;
use common\widgets\JsBlock;

class SideAdView extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $ads = AdForm::find()->where(['type'=>AdForm::TYPE_AD,'autoload'=> 1])->andWhere(['like','name','side_left'])
                ->orderBy("sort asc")
                ->all();
        $body="";
        if ($ads) {
            $body = '<div class="sideAd">';
            foreach($ads as $ad){
            $body .= HTML::a(HTML::img($ad->ad,['alt' => $ad->desc]),$ad->link,['target' => $ad->target]);
            }
            $body .= '<a class="sideAdClose" id="sideAdClose">X关闭</a></div>';
            JsBlock::begin();
            echo '<script>
                $(function() {
                    $("#sideAdClose").click(function(){
                        $(this).parent().hide();
                    });
                });
            </script>';
            JsBlock::end();
        }
        return $body;
    }
}
