<?php

use yii\db\Migration;

/**
 * Class m190801_074442_zhuanlan
 */
class m190801_074442_zhuanlan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //table category
        $this->createTable('{{%zhuanlan}}', [
            'id' => $this->primaryKey()->unsigned(),
            'parent_id' => $this->integer()->unsigned()->defaultValue(0)->notNull(),
            'name' => $this->string()->notNull(),
            'alias' => $this->string()->notNull(),
            'sort' => $this->integer()->unsigned()->defaultValue(0)->notNull(),
            'remark' => $this->string()->defaultValue('')->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->defaultValue(0)->notNull(),
            'is_display' => $this->smallInteger()->defaultValue(1),
        ], $tableOptions);

        //table article
        $this->createTable('{{%zhuanlan_article}}', [
            'id' => $this->primaryKey()->unsigned()->comment("文章自增id"),
            'cid' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment("文章分类id"),
            'title' => $this->string()->notNull()->comment("文章标题"),
            'sub_title' => $this->string()->defaultValue('')->notNull()->comment("用户名"),
            'summary' => $this->string()->defaultValue('')->notNull()->comment("文章概要"),
            'thumb' => $this->string()->defaultValue('')->notNull()->comment("缩略图"),
            'status' => $this->smallInteger()->unsigned()->defaultValue(1)->notNull()->comment("状态.0草稿,1发布"),
            'sort' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment("排序"),
            'author_id' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment("发布文章管理员id"),
            'author_name' => $this->string()->defaultValue('')->notNull()->comment("发布文章管理员用户名"),
            'scan_count' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment("浏览次数"),
            'flag_headline' => $this->smallInteger()->unsigned()->defaultValue(0)->notNull()->comment("头条.0否,1.是"),
            'flag_recommend' => $this->smallInteger()->unsigned()->defaultValue(0)->notNull()->comment("推荐.0否,1.是"),
            'flag_bold' => $this->smallInteger()->unsigned()->defaultValue(0)->notNull()->comment("加粗.0否,1.是"),
            'flag_picture' => $this->smallInteger()->unsigned()->defaultValue(0)->notNull()->comment("图片.0否,1.是"),
            'created_at' => $this->integer()->unsigned()->notNull()->comment("创建时间"),
            'updated_at' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment("最后修改时间"),
        ], $tableOptions);

        $this->createIndex("index_title", "{{%zhuanlan_article}}", "title");
        //table article_content
        $this->createTable('{{%zhuanlan_content}}', [
            'id' => $this->primaryKey()->unsigned()->comment("自增id"),
            'aid' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment("文章id"),
            'content' => $this->text()->notNull()->comment("文章详细内容"),
        ], $tableOptions);

        $this->addForeignKey('fk_zhuanlan', "{{%zhuanlan_content}}", "aid", "{{%zhuanlan_article}}", "id", "CASCADE", "CASCADE");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_zhuanlan', '{{%zhuanlan_content}}');
        $this->dropTable('{{%zhuanlan_article}}');
        $this->dropTable('{{%zhuanlan_content}}');
        $this->dropTable('{{%zhuanlan}}');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190801_074442_zhuanlan cannot be reverted.\n";

        return false;
    }
    */
}
