<?php

use yii\db\Migration;

/**
 * Class m200425_040729_drop_zhuanlan_module
 */
class m200425_040729_drop_zhuanlan_module extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_zhuanlan', '{{%zhuanlan_content}}');
        $this->dropTable('{{%zhuanlan_article}}');
        $this->dropTable('{{%zhuanlan_content}}');
        $this->dropTable('{{%zhuanlan}}');
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200425_040729_drop_zhuanlan_module cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200425_040729_drop_zhuanlan_module cannot be reverted.\n";

        return false;
    }
    */
}
