<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ticketstorage}}`.
 */
class m230404_230752_add_uui_column_to_ticketstorage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ticketstorage}}', 'uuid', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ticketstorage}}', 'uuid');
    }
}
