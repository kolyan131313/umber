<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m160518_181237_posts_table
 */
class m160518_181237_posts_table extends Migration
{
    /**
     * Create table `post`, indexes and foreign keys
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
            $this->createTable('{{%post}}', [
                'id'            => Schema::TYPE_PK,
                'title'         => Schema::TYPE_STRING . '(255) NOT NULL',
                'description'   => Schema::TYPE_STRING . '(512) NOT NULL',
                'text'          => Schema::TYPE_TEXT,
                'src'           => Schema::TYPE_STRING . '(255) NOT NULL',
                'created_by'    => Schema::TYPE_INTEGER . '(11) NULL',
                'modified_by'   => Schema::TYPE_INTEGER . '(11) NULL',
                'moderated'     => Schema::TYPE_BOOLEAN . '(1) NOT NULL DEFAULT 0',
                'unvisible'     => Schema::TYPE_BOOLEAN . '(1) NOT NULL DEFAULT 0',
                'date_created'  => Schema::TYPE_DATETIME,
                'date_modified' => Schema::TYPE_DATETIME
            ], $tableOptions);

            /** Add indexes */
            $this->createIndex('ix-post-title', '{{%post}}', 'title');
            $this->createIndex('ix-post-created-by', '{{%post}}', 'created_by');
            $this->createIndex('ix-post-modified-by', '{{%post}}', 'modified_by');

            /** Add foreign keys */
            $this->addForeignKey('fk-post-created-by-user-id', '{{%post}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
            $this->addForeignKey('fk-post-modified-by-user-id', '{{%post}}', 'modified_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }

    /**
     * Drop table `post`, indexes and foreign keys
     */
    public function down()
    {
        /** @var \yii\db\Transaction $transaction */
        $transaction = $this->db->beginTransaction();

        try {
            /** Drop foreign keys */
            $this->dropForeignKey('fk-post-created-by-user-id', '{{%post}}');
            $this->dropForeignKey('fk-post-modified-by-user-id', '{{%post}}');

            /** Drop indexes */
            $this->dropIndex('ix-post-title', '{{%post}}');
            $this->dropIndex('ix-post-created-by', '{{%post}}');
            $this->dropIndex('ix-post-modified-by', '{{%post}}');

            /** Drop table */
            $this->dropTable('{{%post}}');

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }
}
