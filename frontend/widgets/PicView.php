<?php
namespace frontend\widgets;

use common\models\Options;
use yii\helpers\Url;
use common\widgets\JsBlock;

class PicView extends \yii\base\Widget
{
    public $name;
    public $template = "<div class=\"picWrap\">
                        <h4 class=\"tip\">{picDesc}<a class=\"pull-right\" href=\"{href}\">更多</a></h4>
                        <div class=\"picView\" id=\"picView\">
                            <span id=\"PicDemo1\">{lis}</span><span id=\"PicDemo2\"></span>
                        </div>";

    public $liTemplate = "<a><img src=\"{img_url}\" alt=\"{desc}\"><div>{desc}</div></a>";


    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $banners = Options::getBannersByType($this->name);
        $lis = '';
        foreach ($banners as $banner) {
            $lis .= str_replace(['{img_url}', '{target}','{desc}'], [$banner['img'], $banner['target'], $banner['desc']], $this->liTemplate);
        }
            JsBlock::begin();
            echo '<script>
                $(function() {
                    var pic_speed_30=30; 
                    var Objmarquee_1_30=document.getElementById("PicDemo1");
                    var Objmarquee_2_30=document.getElementById("PicDemo2");
                    var Objmarquee_30=document.getElementById("picView");

                    Objmarquee_2_30.innerHTML = Objmarquee_1_30.innerHTML;
                    function Pic_Marquee30()
                    {
                        if(Objmarquee_2_30.offsetWidth-Objmarquee_30.scrollLeft<=0)
                        {
                        Objmarquee_30.scrollLeft-=Objmarquee_1_30.offsetWidth
                        }
                        else
                        {
                        Objmarquee_30.scrollLeft++;
                        }
                    }
                    var pic_var30=setInterval(Pic_Marquee30,pic_speed_30)
                    Objmarquee_30.onmouseover=function() {clearInterval(pic_var30)}
                    Objmarquee_30.onmouseout=function() {pic_var30=setInterval(Pic_Marquee30,pic_speed_30)}
                });
            </script>';
            JsBlock::end();
            return str_replace(['{lis}','{picDesc}','{href}'], [$lis,Options::findOne(['name' => $this->name])->tips,Url::toRoute(['image/view', 'name'=>$this->name])],$this->template);
    }
}
