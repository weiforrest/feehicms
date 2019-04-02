<?php
namespace frontend\widgets;

use common\models\Options;
use Yii;

class NoticeView extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $notice = Options::getNotice('notice');
        $body = "";
        if ($notice) {
            $body = '<div class="notice">
                <h4 class="tip">网站公告</h4>
               <p> 
               '.$notice.'
                </p></div>';

        }
        return $body;
    }
}
