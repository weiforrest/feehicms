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
use frontend\models\Menu;
use common\models\Category;

class MenuView extends \yii\base\Widget
{

    public $template = "<ul class=\"down-menu nav-menu\">{lis}</ul>";

    public $liTemplate = "<li id='menu-item-{menu_id}' class='menu-item menu-item-type-taxonomy menu-item-object-category {current_menu_class} menu-item-{menu_id}'><a href='{url}' target='{target}' style='padding: 13px;'>{title}</a>{sub_menu}</li>";

    public $subTemplate = "<ul class=\"sub-menu\" style=\"padding-top: 20px;\">{lis}</ul>";

    public $subLitemplate = "<li id=\"menu-item-{menu_id}\" class=\"menu-item menu-item-type-taxonomy menu-item-object-category {current_menu_class} menu-item-{menu_id}\"><a href=\"{url}\" target='{target}' style=\"padding: 13px;\">{title}</a></li>";


    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        static $menus = null;
        if( $menus === null ) {
            $menus = Menu::find()
                ->where(['type' => Menu::FRONTEND_TYPE, 'is_display' => Menu::DISPLAY_YES])
                ->orderBy("sort asc,parent_id asc")
                ->all();
        }
        $content = '';
        foreach ($menus as $key => $menu) {
            /** @var $menu Menu */
            if ($menu->parent_id == 0) {
                $url = $menu->getMenuUrl();
                $currentMenuClass = '';
                if($url != Url::to(['/article/index'])){ // 如果为首页，则不进行转换，这样不会匹配到首页
                    $category = Url::to(['/article/index', 'cat'=> Yii::$app->params['category']]);
                }
                if ($url == yii::$app->getRequest()->getUrl() ||  $category == $url ) {
                    $currentMenuClass = ' current-menu-item ';
                }
                $submenu = $this->getSubMenu($menus, $menu->id);
                $content .= str_replace([
                    '{menu_id}',
                    '{current_menu_class}',
                    '{url}',
                    '{target}',
                    '{title}',
                    '{sub_menu}'
                ], [
                    $menu->id,
                    $currentMenuClass,
                    $url,
                    $menu->target,
                    $menu->name,
                    $submenu
                ], $this->liTemplate);
            }
        }
        return str_replace('{lis}', $content, $this->template);
    }

    /**
     * @param $menus
     * @param $cur_id
     * @return mixed|string
     * @throws yii\base\InvalidConfigException
     */
    private function getSubMenu($menus, $cur_id)
    {
        $content = '';
        foreach ($menus as $key => $menu) {
            /** @var $menu Menu */
            if ($menu['parent_id'] == $cur_id) {
                $url = $menu->getMenuUrl();
                $currentMenuClass = '';
                if ($menu['url'] == Yii::$app->controller->id . '/' . Yii::$app->controller->action->id) {
                    $currentMenuClass = ' current-menu-item ';
                } else {

                    if (yii::$app->request->getPathInfo() == $menu['url']) {
                        $currentMenuClass = ' current-menu-item ';
                    }
                }
                $content .= str_replace([
                    '{menu_id}',
                    '{current_menu_class}',
                    '{url}',
                    '{target}',
                    '{title}'
                ], [$menu['id'], $currentMenuClass, $url, $menu->target, $menu->name], $this->subLitemplate);
            }
        }
        if ($content != '') {
            return str_replace('{lis}', $content, $this->subTemplate);
        } else {
            return '';
        }
    }


}