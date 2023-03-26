<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tickets}}`.
 */
class m230326_030913_add_parent_id_column_to_tickets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tickets}}', 'parent_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tickets}}', 'parent_id');
    }
}
