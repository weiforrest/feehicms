<?php

namespace backend\controllers;

use Yii;
use common\models\Leader;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use backend\actions\ViewAction;
use yii\data\ActiveDataProvider;
/**
 * LeaderController implements the CRUD actions for Leader model.
 */
class LeaderController extends \yii\web\Controller
{
    /**
     * @auth
     * - item group=运营管理 category=领导值班 description=列表 sort=800 method=get
     * - item group=运营管理 category=领导值班 description=创建 sort=801 method=get,post
     * - item group=运营管理 category=领导值班 description=修改 sort=802 method=get,post
     * - item group=运营管理 category=领导值班 description=删除 sort=803 method=get,post
     * - item group=运营管理 category=领导值班 description=排序 sort=804 method=get
     * - item group=运营管理 category=领导值班 description=查看 sort=805 method=get
* 
     * @return array
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $dataProvider = new ActiveDataProvider([
                            'query' => Leader::find(),
                        ]);

                        return [
                            'dataProvider' => $dataProvider,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Leader::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Leader::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Leader::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Leader::className(),
            ],
            'view-layer' => [
                'class' => ViewAction::className(),
                'modelClass' => Leader::className(),
            ],
        ];
    }
}
