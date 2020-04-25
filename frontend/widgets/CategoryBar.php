<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-06-19 10:44
 */

namespace frontend\widgets;


use yii;
use yii\helpers\Url;
use common\models\Category;

class CategoryBar extends \yii\base\Widget
{

    public $template = "<div class=\"list-view\"><ul>{lis}</ul></div>";

    public $liTemplate = "<li class='{current_menu_class} menu-item-{menu_id}' style='text-align:center;margin:10px;font-size:16px'><a href='{url}'><span>{title}</span></a></li>";
    
    public $parent_id = 0 ;

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        static $menus = null;
        if( $menus === null ) {
            $menus = Category::find()
                ->where(['parent_id'=> $this->parent_id])
                ->orderBy("sort asc")
                ->all();
        }
        $content = '';
        foreach ($menus as $key => $menu) {
            /** @var $menu Menu */
                $url = Url::to(['article/cate', 'cat' => $menu->alias]);
                $currentMenuClass = '';
                if($url != Url::to(['article/index'])){ // 如果为首页，则不进行转换，这样不会匹配到首页
                    $category = Url::to(['article/index', 'cat'=> Yii::$app->params['category']]);
                }
                if ($url == yii::$app->getRequest()->getUrl() ||  $category == $url ) {
                    $currentMenuClass = ' current-menu-item ';
                }
                $content .= str_replace([
                    '{menu_id}',
                    '{current_menu_class}',
                    '{url}',
                    '{title}',
                ], [
                    $menu->id,
                    $currentMenuClass,
                    $url,
                    $menu->name,
                ], $this->liTemplate);
        }
        return str_replace('{lis}', $content, $this->template);
    }


}
