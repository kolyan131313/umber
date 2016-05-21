<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m160518_183910_categories_table
 */
class m160518_183910_categories_table extends Migration
{
    /**
     * Create table `category`
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
            $this->createTable('{{%category}}', [
                'id'            => Schema::TYPE_PK,
                'title'         => Schema::TYPE_STRING . '(255) NOT NULL',
                'url'           => Schema::TYPE_STRING . '(255) NOT NULL',
                'date_created'  => Schema::TYPE_DATETIME,
                'date_modified' => Schema::TYPE_DATETIME
            ], $tableOptions);

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }

    /**
     * Drop table `category`
     */
    public function down()
    {
        /** @var \yii\db\Transaction $transaction */
        $transaction = $this->db->beginTransaction();

        try {
            /** Drop table */
            $this->dropTable('{{%category}}');
            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }
}
