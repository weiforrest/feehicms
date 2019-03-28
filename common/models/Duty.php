<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%duty}}".
 *
 * @property string $duty_time 值班日期
 * @property string $leader 领导
 * @property string $master 主班
 * @property string $second 副班
 * @property string $three 行政班
 * @property string $gun 枪库值守
 */
class Duty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%duty}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['duty_time', 'leader', 'master', 'second', 'three', 'gun'], 'required'],
            [['duty_time'], 'safe'],
            [['leader', 'master', 'second', 'three', 'gun'], 'string', 'max' => 32],
            [['duty_time'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'duty_time' => '值班日期',
            'leader' => '值班领导',
            'master' => '主班大队',
            'second' => '副班大队',
            'three' => '行政班大队',
            'gun' => '枪库值守',
        ];
    }
}
