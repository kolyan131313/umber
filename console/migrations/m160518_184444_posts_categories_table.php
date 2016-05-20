<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m160518_184444_posts_categories_table
 */
class m160518_184444_posts_categories_table extends Migration
{
    /**
     * Create table `posts_categories`, indexes and foreign keys
     */
    public function up()
    {
        /** @var \yii\db\Transaction $transaction */
        $transaction = $this->db->beginTransaction();

        try {
            $tableOptions = null;

            if ($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
            }

            /** Create table */
            $this->createTable('{{%posts_categories}}', [
                'post_id'     => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL'
            ], $tableOptions);

            /** Add indexes */
            $this->createIndex('ix-posts-categories-post-id', '{{%posts_categories}}', 'post_id');
            $this->createIndex('ix-posts-categories-category-id', '{{%posts_categories}}', 'category_id');

            /** Add foreign keys */
            $this->addForeignKey('fk-pstcat-post-id-posts-id', '{{%posts_categories}}', 'post_id', '{{%posts}}', 'id', 'RESTRICT', 'RESTRICT');
            $this->addForeignKey('fk-pstcat-category-id-categories-id', '{{%posts_categories}}', 'category_id', '{{%categories}}', 'id', 'RESTRICT', 'RESTRICT');

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }

    /**
     * Drop table `posts_categories`, indexes and foreign keys
     */
    public function down()
    {
        /** @var \yii\db\Transaction $transaction */
        $transaction = $this->db->beginTransaction();

        try {
            /** Drop foreign keys */
            $this->dropForeignKey('fk-pstcat-post-id-posts-id', '{{%posts_categories}}');
            $this->dropForeignKey('fk-pstcat-category-id-categories-id', '{{%posts_categories}}');

            /** Drop indexes */
            $this->dropIndex('ix-posts-categories-post-id', '{{%posts_categories}}');
            $this->dropIndex('ix-posts-categories-category-id', '{{%posts_categories}}');

            /** Drop table */
            $this->dropTable('{{%posts_categories}}');

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }
}
