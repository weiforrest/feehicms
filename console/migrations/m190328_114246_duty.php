<?php

use yii\db\Migration;

/**
 * Class m190328_114246_duty
 */
class m190328_114246_duty extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%duty}}', [
            'duty_time' => $this->date()->comment("值班日期"),
            'leader' => $this->string(32)->notNull()->comment("值班领导"),
            'master' => $this->string(32)->notNull()->comment("主班大队"),
            'second' => $this->string(32)->notNull()->comment("副班大队"),
            'three' => $this->string(32)->notNull()->comment("行政班大队"),
            'gun' => $this->string(32)->notNull()->comment("枪库值守"),
            'PRIMARY KEY ([[duty_time]])'
        ], $tableOptions);
        $this->Insert("{{%menu}}", ['type'=> 0,'parent_id'=>27,'name'=>'值班管理','url'=>'duty/index','sort' => 0,'target' => '_blank','is_absolute_url'=> 0,'is_display'=> 1]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190328_114246_duty cannot be reverted.\n";
        $this->dropTable('{{%duty}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190328_114246_duty cannot be reverted.\n";

        return false;
    }
    */
}
