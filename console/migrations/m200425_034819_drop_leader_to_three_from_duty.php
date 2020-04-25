<?php

use yii\db\Migration;

/**
 * Class m200425_034819_drop_leader_to_three_from_duty
 */
class m200425_034819_drop_leader_to_three_from_duty extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('duty', 'leader');
        $this->dropColumn('duty', 'master');
        $this->dropColumn('duty', 'second');
        $this->dropColumn('duty', 'three');
        $this->alterColumn('duty', 'gun', $this->string(128)->notNull()->comment("枪库值守"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('duty', 'leader', $this->string(32)->notNull()->comment("值班领导"));
        $this->addColumn('duty', 'master', $this->string(32)->notNull()->comment("主班大队"));
        $this->addColumn('duty', 'second', $this->string(32)->notNull()->comment("副班大队"));
        $this->addColumn('duty', 'three',  $this->string(32)->notNull()->comment("行政班大队"));
        $this->alterColumn('duty', 'gun', $this->string(32)->notNull()->comment("枪库值守"));
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200425_034819_drop_leader_to_three_from_duty cannot be reverted.\n";

        return false;
    }
    */
}
