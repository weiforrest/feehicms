<?php
namespace frontend\widgets;

use common\models\Duty;
class DutyView extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
            $duty = Duty::findOne(['duty_time' => date("Y-m-d")]);
      $body = "<div class='duty'>
                <div class='tip'>
                <h4>".date("Y-m-d")." 值班安排</h4>
                </div>
            <p>".$duty->getAttributeLabel('leader').": <span>".$duty->leader."</span></p>
            <p>".$duty->getAttributeLabel('master').": <span>".$duty->master."</span></p>
            <p>".$duty->getAttributeLabel('second').": <span>".$duty->second."</span></p>
            <p>".$duty->getAttributeLabel('three').": <span>".$duty->three."</span></p>
            <p>".$duty->getAttributeLabel('gun').": <span>".$duty->gun."</span></p>
                </div> ";
        return $body;
    }
}

