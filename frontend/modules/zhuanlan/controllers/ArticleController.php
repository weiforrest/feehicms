<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-02 22:48
 */

namespace frontend\modules\zhuanlan\controllers;

use Yii;
use common\libs\Constants;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\modules\zhuanlan\models\Article;
use frontend\modules\zhuanlan\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\HttpCache;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\XmlResponseFormatter;

class ArticleController extends Controller
{


    public function behaviors()
    {
        return [
            // [
            //     'class' => HttpCache::className(),
            //     'only' => ['view'],
            //     'lastModified' => function ($action, $params) {
            //         $id = Yii::$app->getRequest()->get('id');
            //         $model = Article::findOne(['id' => $id, 'status' => Article::ARTICLE_PUBLISHED]);
            //         if( $model === null ) throw new NotFoundHttpException(Yii::t("frontend", "Article id {id} is not exists", ['id' => $id]));
            //         Article::updateAllCounters(['scan_count' => 1], ['id' => $id]);
            //         return $model->updated_at;
            //     },
            // ],
        ];
    }

    /**
     * 分类列表页
     *
     * @param string $cat 分类名称
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($cat = '')
    {
        $isIndex = true;
        if ($cat == '') {
            $cat = Yii::$app->getRequest()->getPathInfo();
        }
        $where = ['status' => Article::ARTICLE_PUBLISHED];
        if ($cat != '' && $cat != 'index') {
            $isIndex = false;
            if ($cat == Yii::t('app', 'uncategoried')) {
                $where['cid'] = 0;
            } else {
                if (! $category = Category::findOne(['alias' => $cat])) {
                    throw new NotFoundHttpException(Yii::t('frontend', 'None category named {name}', ['name' => $cat]));
                }
                $descendants = Category::getDescendants($category['id']);
                if( empty($descendants) ) {
                    $where['cid'] = $category['id'];
                }else{
                    $cids = ArrayHelper::getColumn($descendants, 'id');
                    $cids[] = $category['id'];
                    $where['cid'] = $cids;
                }
            }
        }
        $query = Article::find()->with('category')->where($where);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                    'created_at' => SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ]
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'type' => ( !empty($category->name) ?  $category->name: '专栏' ),
        ]);
    }

    /**
     * 文章详情
     *
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Article::findOne(['id' => $id,  'status' => Article::ARTICLE_PUBLISHED]);
        if( $model === null ) throw new NotFoundHttpException(Yii::t("frontend", "Article id {id} is not exists", ['id' => $id]));
        $prev = Article::find()
            ->where(['cid' => $model->cid])
            ->andWhere(['>', 'id', $id])
            ->orderBy("sort asc,created_at desc,id desc")
            ->limit(1)
            ->one();

        $next = Article::find()
            ->where(['cid' => $model->cid])
            ->andWhere(['<', 'id', $id])
            ->orderBy("sort desc,created_at desc,id asc")
            ->limit(1)
            ->one();//->createCommand()->getRawSql();
        return $this->render('view', [
            'model' => $model,
            'prev' => $prev,
            'next' => $next,
        ]);
    }

    /**
     * 获取文章的点赞数和浏览数
     *
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionViewAjax($id)
    {
        $model = Article::findOne($id);
        if( $model === null ) throw new NotFoundHttpException("None exists article id");
        return [
            'likeCount' => (int)$model->getArticleLikeCount(),
            'scanCount' => $model->scan_count * 100,
            'commentCount' => $model->comment_count,
        ];
    }


    /**
     * 点赞
     *
     * @return int|string
     */
    public function actionLike()
    {
        $aid = Yii::$app->getRequest()->post("aid");
        $model = new ArticleMetaLike();
        $model->setLike($aid);
        return $model->getLikeCount($aid);

    }


}