<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m160518_181237_posts_table
 */
class m160518_181237_posts_table extends Migration
{
    /**
     * Create table `posts`, indexes and foreign keys
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
            $this->createTable('{{%posts}}', [
                'id'            => Schema::TYPE_PK,
                'title'         => Schema::TYPE_STRING . '(255) NOT NULL',
                'description'   => Schema::TYPE_STRING . '(512) NOT NULL',
                'text'          => Schema::TYPE_TEXT,
                'created_by'    => Schema::TYPE_INTEGER . '(11) NULL',
                'modified_by'   => Schema::TYPE_INTEGER . '(11) NULL',
                'moderated'     => Schema::TYPE_BOOLEAN . '(1) DEFAULT 0',
                'visible'       => Schema::TYPE_BOOLEAN . '(1) DEFAULT 1',
                'date_created'  => Schema::TYPE_DATETIME,
                'date_modified' => Schema::TYPE_DATETIME
            ], $tableOptions);

            /** Add indexes */
            $this->createIndex('ix-posts-title', '{{%posts}}', 'title');
            $this->createIndex('ix-posts-author', '{{%posts}}', 'author');

            /** Add foreign keys */
            $this->addForeignKey('fk-post-created-by-user-id', '{{%posts}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
            $this->addForeignKey('fk-post-modified-by-user-id', '{{%posts}}', 'modified_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }

    /**
     * Drop table `posts`, indexes and foreign keys
     */
    public function down()
    {
        /** @var \yii\db\Transaction $transaction */
        $transaction = $this->db->beginTransaction();

        try {
            /** Drop foreign keys */
            $this->dropForeignKey('fk-post-created-by-user-id', '{{%posts}}');
            $this->dropForeignKey('fk-post-modified-by-user-id', '{{%posts}}');

            /** Drop indexes */
            $this->dropIndex('ix-posts-title', '{{%posts}}');
            $this->dropIndex('ix-posts-author', '{{%posts}}');

            /** Drop table */
            $this->dropTable('{{%posts}}');

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }
}
