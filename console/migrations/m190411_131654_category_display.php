<?php

use yii\db\Migration;

/**
 * Class m190411_131654_catagory_display
 */
class m190411_131654_category_display extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category','is_display',$this->smallInteger()->defaultValue(1));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        return $this->dropColumn('catagroy', 'is_display');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190411_131654_catagory_display cannot be reverted.\n";

        return false;
    }
    */
}
