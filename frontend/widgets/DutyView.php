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
            $duty = Duty::findOne(["duty_time" => date("Y-m-d")]);
            $body="";
            $man = explode(",",$duty->gun);
            if($duty){
            $body = '<div class="duty">
                <table  width="100%">
               <thead class="dutyhead"> 
                <tr>
                    <td colspan="8">'.date("Y-m-d").' 值班安排</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="dutyblod"> 总值班</td>
                    <td>贾先华</td>
                    <td class="dutyblod">'.$duty->getAttributeLabel("leader").'</td>
                    <td>'.$duty->leader.'</td>
                    <td class="dutyblod">其他领导</td>
                    <td colspan = "3">刘钰坤、廖芳芳、肖坚、李琦辉、唐育平、黄杨敏</td>
                </tr>
                <tr>
                    <td rowspan="2" class="dutyblod">值班大队</td>
                    <td class="dutyblod">'.$duty->getAttributeLabel("master").'</td>
                    <td class="dutyblod">'.$duty->getAttributeLabel("second").'</td>
                    <td class="dutyblod">'.$duty->getAttributeLabel("three").'</td>
                    <td rowspan="2" class="dutyblod">'.$duty->getAttributeLabel("gun").'</td>
                    <td class="dutyblod" colspan="2">机关民警</td>
                    <td class="dutyblod">主班大队民警</td>
                </tr>
                <tr>
                <td>'.$duty->master.'</td>
                <td>'.$duty->second.'</td>
                <td>'.$duty->three.'</td>
                <td colspan="2">'.$man[0].'</td>
                <td>'.$man[1].'</td>
                </tr>
                </tbody>
                </table></div>';
            }
        return $body;
    }
}

