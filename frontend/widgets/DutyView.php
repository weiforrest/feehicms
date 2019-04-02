<?php
namespace frontend\widgets;

use common\models\Duty;
use Yii;

class DutyView extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $duty = Duty::findOne(["duty_time" => date("Y-m-d")]);
        $body = "";
        $man = explode(",", $duty->gun);
        if ($duty) {
            $body = '<div class="duty"><table>
                    <h4 class="tip">'.date("Y-m-d").' 值班安排</h4>
                <tbody>
                <tr>
                    <td class="dutyblod">'.$duty->getAttributeLabel("leader").'</td>
                    <td>'.$duty->leader.'</td>
                </tr>
                <tr>
                    <td class="dutyblod">'.$duty->getAttributeLabel("master").'</td>
                    <td>'.$duty->master.'</td>
                </tr>
                <tr>
                    <td class="dutyblod">'.$duty->getAttributeLabel("second").'</td>
                    <td>'.$duty->second.'</td>
                </tr>
                <tr>
                    <td class="dutyblod">'.$duty->getAttributeLabel("three").'</td>
                    <td>'.$duty->three.'</td>
                </tr>
                <tr>
                    <td colspan="2" class="dutyblod">'.$duty->getAttributeLabel("gun").'</td>
                </tr>
                    <td class="dutyblod">机关民警</td>
                    <td class="dutyblod">主班大队民警</td>
                </tr>
                <tr>
                <td>'.$man[0].'</td>
                <td>'.$man[1].'</td>
                </tr>
                </tbody>
                </table></div>';

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
