<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-10-16 17:15
 */

namespace common\models;

use common\models\meta\ArticleMetaLike;
use common\models\meta\ArticleMetaTag;
use feehi\cdn\TargetAbstract;
use Yii;
use common\libs\Constants;
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
 * @property integer $flag_slide_show
 * @property integer $flag_special_recommend
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ArticleContent[] $articleContents
 */
class Article extends \yii\db\ActiveRecord
{
    const ARTICLE = 0;
    const SINGLE_PAGE = 2;

    const ARTICLE_PUBLISHED = 1;
    const ARTICLE_DRAFT = 0;

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
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'type', 'status', 'sort', 'author_id' ], 'integer'],
            [['cid', 'sort', 'author_id'], 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['title', 'status','cid'], 'required'],
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
                    'flag_slide_show',
                    'flag_special_recommend',
                    'status',
                ],
                'in',
                'range' => [0, 1]
            ],
            [['visibility'], 'in', 'range' => array_keys(Constants::getArticleVisibility())],
            [['type'], 'default', 'value'=>self::ARTICLE, 'on'=>'article'],
            [['type'], 'default', 'value'=>self::SINGLE_PAGE, 'on'=>'page'],
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
                'type',
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
                'flag_slide_show',
                'flag_special_recommend',
            ],
            'page' => [
                'type',
                'title',
                'sub_title',
                'summary',
                'content',
                'status',
                'sort'
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
            'type' => Yii::t('app', 'Type'),
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
            'flag_special_recommend' => Yii::t('app', 'Is Special Recommend'),
            'flag_slide_show' => Yii::t('app', 'Is Slide Show'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getArticleLikes()
    {
        $tempModel = new ArticleMetaLike();
        return $this->hasMany(ArticleMetaLike::className(), ['aid' => 'id'])->where(['key'=>$tempModel->keyName]);
    }

    public function getArticleTags()
    {
        $tempModel = new ArticleMetaTag();
        return $this->hasMany(ArticleMetaLike::className(), ['aid' => 'id'])->where(['key'=>$tempModel->keyName]);
    }

    /**
     * @return integer
     */
    public function getArticleLikeCount()
    {
        return $this->getArticleLikes()->count('id');
    }

    public function afterFind()
    {
        if ($this->thumb) {
            /** @var TargetAbstract $cdn */
            $cdn = Yii::$app->get('cdn');
            $this->thumb = $cdn->getCdnUrl($this->thumb);
        }
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if ($this->thumb) {
            /** @var TargetAbstract $cdn */
            $cdn = Yii::$app->get('cdn');
            $this->thumb = str_replace($cdn->host, '', $this->thumb);
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
    
}
