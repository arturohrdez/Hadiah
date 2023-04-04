<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ticketstorage}}`.
 */
class m230404_151403_create_ticketstorage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ticketstorage}}', [
            'id'       => $this->primaryKey(),
            'rifa_id'  => $this->integer()->notNull(),
            'ticket'   => $this->string()->notNull(),
            'date_ini' => $this->dateTime()->notNull(),
            'date_end' => $this->dateTime()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ticketstorage}}');
    }
}
