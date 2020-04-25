<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%leader}}".
 *
 * @property string $id  
 * @property string $name 领导
 * @property string $tel 电话
 * @property integer $sort 排序
 */
class Leader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%leader}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'tel'], 'required'],
            [['name','tel'], 'string', 'max' => 32],
            [['name'], 'unique'],
            [['sort'], 'integer'],
            [['sort'], 'compare', 'compareValue' => 0, 'operator' => '>='],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => '姓名',
            'tel' => '联系电话',
            'sort' => '排序'
        ];
    }
}
