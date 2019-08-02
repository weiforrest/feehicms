<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-10-16 17:15
 */

namespace backend\modules\zhuanlan\models;

use feehi\cdn\TargetAbstract;
use common\helpers\Util;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property integer $cid
 * @property integer $type
 * @property string $title
 * @property string $sub_title
 * @property string $summary
 * @property string $thumb
 * @property integer $status
 * @property integer $sort
 * @property integer $author_id
 * @property string $author_name
 * @property integer $scan_count
 * @property integer $flag_headline
 * @property integer $flag_recommend
 * @property integer $flag_bold
 * @property integer $flag_picture
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ArticleContent[] $articleContents
 */
class Article extends \yii\db\ActiveRecord
{
    const ARTICLE_PUBLISHED = 1;
    const ARTICLE_DRAFT = 0;

    public $content = null;

    /**
     * 需要截取的文章缩略图尺寸
     */
    public static $thumbSizes = [
        ["w"=>220, "h"=>150],//首页文章列表
        ["w"=>168, "h"=>112],//精选导读
        ["w"=>185, "h"=>110],//文章详情下边图片推荐
        ["w"=>125, "h"=>86],//热门推荐
    ];

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zhuanlan_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'status', 'sort', 'author_id'], 'integer'],
            [['cid', 'sort', 'author_id'], 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['title', 'status'], 'required'],
            [['thumb'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [
                [
                    'title',
                    'sub_title',
                    'summary',
                    'thumb',
                    'author_name',
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'flag_headline',
                    'flag_recommend',
                    'flag_bold',
                    'flag_picture',
                    'status',
                ],
                'in',
                'range' => [0, 1]
            ],
            ['cid', 'default', 'value'=>0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'article' => [
                'cid',
                'title',
                'sub_title',
                'summary',
                'content',
                'thumb',
                'status',
                'sort',
                'author_id',
                'author_name',
                'created_at',
                'updated_at',
                'scan_count',
                'flag_headline',
                'flag_recommend',
                'flag_bold',
                'flag_picture',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cid' => Yii::t('app', 'Category Id'),
            'title' => Yii::t('app', 'Title'),
            'sub_title' => Yii::t('app', 'Sub Title'),
            'summary' => Yii::t('app', 'Summary'),
            'content' => Yii::t('app', 'Content'),
            'thumb' => Yii::t('app', 'Thumb'),
            'status' => Yii::t('app', 'Status'),
            'sort' => Yii::t('app', 'Sort'),
            'author_id' => Yii::t('app', 'Author Id'),
            'author_name' => Yii::t('app', 'Author'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'flag_headline' => Yii::t('app', 'Is Headline'),
            'flag_recommend' => Yii::t('app', 'Is Recommend'),
            'flag_bold' => Yii::t('app', 'Is Bold'),
            'flag_picture' => Yii::t('app', 'Is Picture'),
            'scan_count' => Yii::t('app', 'Scan Count'),
            'category' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'cid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleContent()
    {
        return $this->hasOne(ArticleContent::className(), ['aid' => 'id']);
    }


    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        if ($this->thumb) {
            /** @var TargetAbstract $cdn */
            $cdn = Yii::$app->get('cdn');
            $this->thumb = $cdn->getCdnUrl($this->thumb);
        }
        $this->content = ArticleContent::findOne(['aid' => $this->id])['content'];
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if ($this->thumb) {
            /** @var TargetAbstract $cdn */
            $cdn = Yii::$app->get('cdn');
            $this->thumb = str_replace($cdn->host, '', $this->thumb);
        }
        $insert = $this->getIsNewRecord();
        Util::handleModelSingleFileUpload($this, 'thumb', $insert, '@thumb', ['thumbSizes'=>self::$thumbSizes]);
        if ($insert) {
            $this->author_id = Yii::$app->getUser()->getIdentity()->getId();
            $this->author_name = Yii::$app->getUser()->getIdentity()->username;
        }
        return parent::beforeSave($insert);
    }

    public function getThumbUrlBySize($width='', $height='')
    {
        if( empty($width) || empty($height) ){
            return $this->thumb;
        }
        if( empty($this->thumb) ){//未配图
            return $this->thumb = '/static/images/' . rand(1, 10) . '.jpg';
        }
        static $str = null;
        if( $str === null ) {
            $str = "";
            foreach (self::$thumbSizes as $temp){
                $str .= $temp['w'] . 'x' . $temp['h'] . '---';
            }
        }
        if( strpos($str, $width . 'x' . $height) !== false ){
            $dotPosition = strrpos($this->thumb, '.');
            $thumbExt = "@" . $width . 'x' . $height;
            if( $dotPosition === false ){
                return $this->thumb . $thumbExt;
            }else{
                return substr_replace($this->thumb,$thumbExt, $dotPosition, 0);
            }
        }
        return Yii::$app->getRequest()->getBaseUrl() . '/timthumb.php?' . http_build_query(['src'=>$this->thumb, 'h'=>$height, 'w'=>$width, 'zc'=>0]);
    }
    

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ( $insert ) {
            $contentModel = yii::createObject( ArticleContent::className() );
            $contentModel->aid = $this->id;
        } else {
            if ( $this->content === null ) {
                return true;
            }
            $contentModel = ArticleContent::findOne(['aid' => $this->id]);
            if ($contentModel == null) {
                $contentModel = yii::createObject( ArticleContent::className() );
                $contentModel->aid = $this->id;
            }
        }
        $contentModel->content = $this->content;
        $contentModel->save();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if( !empty( $this->thumb ) ){
            Util::deleteThumbnails(Yii::getAlias('@frontend/web') . $this->thumb, self::$thumbSizes, true);
        }
        Comment::deleteAll(['aid' => $this->id]);
        if (($articleContentModel = ArticleContent::find()->where(['aid' => $this->id])->one()) != null) {
            $articleContentModel->delete();
        }
        return parent::beforeDelete();
    }

}
