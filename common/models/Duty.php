<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%duty}}".
 *
 * @property string $duty_time 值班日期
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
            [['duty_time','gun'], 'required'],
            [['duty_time'], 'safe'],
            [['gun'], 'string', 'max' => 256],
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
            'gun' => '枪库值守',
        ];
    }
}
