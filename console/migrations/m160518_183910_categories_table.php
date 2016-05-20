<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m160518_183910_categories_table
 */
class m160518_183910_categories_table extends Migration
{
    /**
     * Create table `categories`
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        /** Create table */
        $this->createTable('{{%categories}}', [
            'id'            => Schema::TYPE_PK,
            'title'         => Schema::TYPE_STRING . '(255) NOT NULL',
            'date_created'  => Schema::TYPE_DATETIME,
            'date_modified' => Schema::TYPE_DATETIME
        ], $tableOptions);
    }

    /**
     * Drop table `categories`
     */
    public function down()
    {
        /** Drop table */
        $this->dropTable('{{%categories}}');
    }
}
