<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ticketstorage}}`.
 */
class m230405_000337_add_created_at_column_updated_at_column_to_ticketstorage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ticketstorage}}', 'created_at', $this->string());
        $this->addColumn('{{%ticketstorage}}', 'updated_at', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ticketstorage}}', 'created_at');
        $this->dropColumn('{{%ticketstorage}}', 'updated_at');
    }
}
