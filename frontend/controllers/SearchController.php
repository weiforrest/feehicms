<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-05 13:08
 */

namespace frontend\controllers;

use common\models\meta\ArticleMetaTag;
use Yii;
use frontend\models\Article;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\StringHelper;

class SearchController extends Controller
{

    /**
     * 搜索
     *
     * @return string
     */
    public function actionIndex()
    {
        $where = ['type' => Article::ARTICLE];
        $query = Article::find()->select([])->where($where);
        $keyword = htmlspecialchars(Yii::$app->getRequest()->post('q'));
        $query->andFilterWhere(['like', 'title', $keyword]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                    'id' => SORT_DESC,
                ]
            ]
        ]);
        $keyword = StringHelper::truncate($keyword, 15);
        return $this->render('/article/category', [
            'dataProvider' => $dataProvider,
            'name' => Yii::t('frontend', 'Search keyword {keyword} results', ['keyword'=>$keyword]),
        ]);
    }

}
