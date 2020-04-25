<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-02 22:48
 */

namespace frontend\controllers;

use Yii;
use common\libs\Constants;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\Article;
use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\HttpCache;

class ArticleController extends Controller
{


    public function behaviors()
    {
        return [
            [
                'class' => HttpCache::className(),
                'only' => ['view'],
                'lastModified' => function ($action, $params) {
                    $id = Yii::$app->getRequest()->get('id');
                    $model = Article::findOne(['id' => $id, 'type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED]);
                    if( $model === null ) throw new NotFoundHttpException(Yii::t("frontend", "Article id {id} is not exists", ['id' => $id]));
                    Article::updateAllCounters(['scan_count' => 1], ['id' => $id]);
                    if($model->visibility == Constants::ARTICLE_VISIBILITY_PUBLIC) return $model->updated_at;
                },
            ],
        ];
    }

    /**
     * 主页
     *
     * @param string
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    /**
     * 分类列表页
     *
     * @param string $cat 分类名称
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCate($cat = '')
    {
        if ($cat == '') {
            $cat = Yii::$app->getRequest()->getPathInfo();
        }
        $where = ['type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED];
        if ($cat != '') {
            if (! $category = Category::findOne(['alias' => $cat])) {
                throw new NotFoundHttpException(Yii::t('frontend', 'None category named {name}', ['name' => $cat]));
            }
            $descendants = Category::getDescendants($category['id']);
            if( empty($descendants) ) { 
                $where['cid'] = $category['id'];
                if($category->parent_id) $parent_id = $category->parent_id; // 找到父类
            }else{   //找到了子分类
                $cids = ArrayHelper::getColumn($descendants, 'id');
                $cids[] = $category['id'];
                $where['cid'] = $cids;
                $parent_id = $category['id']; //根分类
            }
        }
        // var_dump($where["cid"]);
        // 查询分类文章
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
        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'name' => $category->name,
            'parent_id'=> $parent_id,
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
        $model = Article::findOne(['id' => $id, 'type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED]);
        if( $model === null ) throw new NotFoundHttpException(Yii::t("frontend", "Article id {id} is not exists", ['id' => $id]));
        // 删除掉这些不需要的东西
        // $prev = Article::find()
        //     ->where(['cid' => $model->cid])
        //     ->andWhere(['>', 'id', $id])
        //     ->orderBy("sort asc,created_at desc,id desc")
        //     ->limit(1)
        //     ->one();
        // $next = Article::find()
        //     ->where(['cid' => $model->cid])
        //     ->andWhere(['<', 'id', $id])
        //     ->orderBy("sort desc,created_at desc,id asc")
        //     ->limit(1)
        //     ->one();//->createCommand()->getRawSql();
        // $commentModel = new Comment();
        // $commentList = $commentModel->getCommentByAid($id);
        // switch ($model->visibility){
        //     case Constants::ARTICLE_VISIBILITY_COMMENT://评论可见
        //         if( Yii::$app->getUser()->getIsGuest() ){
        //             $result = Comment::find()->where(['aid'=>$model->id, 'ip'=>Yii::$app->getRequest()->getUserIP()])->one();
        //         }else{
        //             $result = Comment::find()->where(['aid'=>$model->id, 'uid'=>Yii::$app->getUser()->getId()])->one();
        //         }
        //         if( $result === null ) {
        //             $model->articleContent->content = "<p style='color: red'>" . Yii::t('frontend', "Only commented user can visit this article") . "</p>";
        //         }
        //         break;
        //     case Constants::ARTICLE_VISIBILITY_SECRET://加密文章
        //         $authorized = Yii::$app->getSession()->get("article_password_" . $model->id, null);
        //         if( $authorized === null ) $this->redirect(Url::toRoute(['password', 'id'=>$id]));
        //         break;
        //     case Constants::ARTICLE_VISIBILITY_LOGIN://登陆可见
        //         if( Yii::$app->getUser()->getIsGuest() ) {
        //             $model->articleContent->content = "<p style='color: red'>" . Yii::t('frontend', "Only login user can visit this article") . "</p>";
        //         }
        //         break;
        // }
        $this->layout = 'view';
        return $this->render('view', [
            'model' => $model,
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

}