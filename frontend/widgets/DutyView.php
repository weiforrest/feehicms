<?php
namespace frontend\widgets;

use common\models\Duty;
use common\models\Leader;
use Yii;

class DutyView extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        
        parent::run();
        $count = Leader::find()->count();
        $week = (date('W') % $count);
        if(!$week) $week = $count;
        $leader = Leader::findOne(["sort" => $week]);
        $body = "";
        if(!$leader){
            $body = '<div class="duty"><h4 class="tip">'.date("Y-m-d").'</h4>请在后台设置值班信息</div>';
        }else{
            $body = '<div class="duty"><table>
                    <h4 class="tip">'.date("Y-m-d").'</h4>
                <tbody>
                <tr>
                    <td class="dutyblod">'.$leader->getAttributeLabel("name").'</td>
                </tr>
                <tr>
                    <td>'.$leader->name.'</td>
                </tr>
                <tr>
                    <td class="dutyblod">'.$leader->getAttributeLabel("tel").'</td>
                </tr>
                <tr>
                    <td>'.$leader->tel.'</td>
                </tr>';
            $duty = Duty::findOne(["duty_time" => date("Y-m-d")]);
            if($duty){
                $body.= '<tr><td class="dutyblod">'.$duty->getAttributeLabel("gun").'</td></tr><tr>
                        <td>'.$duty->gun.'</td></tr>';
            }
            $body.= '</tbody></table></div>';
        }




        // $duty = Duty::findOne(["duty_time" => date("Y-m-d")]);
        // $body = "";
        // $man = explode(",", $duty->gun);
        // if ($duty) {
        //     $body = '<div class="duty"><table>
        //             <h4 class="tip">'.date("Y-m-d").' 值班安排</h4>
        //         <tbody>
        //         <tr>
        //             <td class="dutyblod">'.$duty->getAttributeLabel("leader").'</td>
        //             <td>'.$duty->leader.'</td>
        //         </tr>
        //         <tr>
        //             <td class="dutyblod">'.$duty->getAttributeLabel("master").'</td>
        //             <td>'.$duty->master.'</td>
        //         </tr>
        //         <tr>
        //             <td class="dutyblod">'.$duty->getAttributeLabel("second").'</td>
        //             <td>'.$duty->second.'</td>
        //         </tr>
        //         <tr>
        //             <td class="dutyblod">'.$duty->getAttributeLabel("three").'</td>
        //             <td>'.$duty->three.'</td>
        //         </tr>
        //         <tr>
        //             <td colspan="2" class="dutyblod">'.$duty->getAttributeLabel("gun").'</td>
        //         </tr>
        //             <td class="dutyblod">机关民警</td>
        //             <td class="dutyblod">主班大队</td>
        //         </tr>
        //         <tr>
        //         <td>'.$man[0].'</td>
        //         <td>'.$man[1].'</td>
        //         </tr>
        //         </tbody>
        //         </table></div>';

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
        // }
        return $body;
    }
}
