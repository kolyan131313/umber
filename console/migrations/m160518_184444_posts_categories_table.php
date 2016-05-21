<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m160518_184444_posts_categories_table
 */
class m160518_184444_posts_categories_table extends Migration
{
    /**
     * Create table `post_category`, indexes and foreign keys
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
            $this->createTable('{{%post_category}}', [
                'post_id'     => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL'
            ], $tableOptions);

            /** Add indexes */
            $this->createIndex('ix-post-categories-post-id', '{{%post_category}}', 'post_id');
            $this->createIndex('ix-post-categories-category-id', '{{%post_category}}', 'category_id');

            /** Add foreign keys */
            $this->addForeignKey('fk-pstcat-post-id-post-id', '{{%post_category}}', 'post_id', '{{%post}}', 'id', 'RESTRICT', 'RESTRICT');
            $this->addForeignKey('fk-pstcat-category-id-categories-id', '{{%post_category}}', 'category_id', '{{%category}}', 'id', 'RESTRICT', 'RESTRICT');

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }

    /**
     * Drop table `post_category`, indexes and foreign keys
     */
    public function down()
    {
        /** @var \yii\db\Transaction $transaction */
        $transaction = $this->db->beginTransaction();

        try {
            /** Drop foreign keys */
            $this->dropForeignKey('fk-pstcat-post-id-post-id', '{{%post_category}}');
            $this->dropForeignKey('fk-pstcat-category-id-categories-id', '{{%post_category}}');

            /** Drop indexes */
            $this->dropIndex('ix-post-categories-post-id', '{{%post_category}}');
            $this->dropIndex('ix-post-categories-category-id', '{{%post_category}}');

            /** Drop table */
            $this->dropTable('{{%post_category}}');

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }
}
