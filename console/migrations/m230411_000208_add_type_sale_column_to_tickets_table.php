<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tickets}}`.
 */
class m230411_000208_add_type_sale_column_to_tickets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tickets}}', 'type_sale', $this->string(10));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tickets}}', 'type_sale');
    }
}
