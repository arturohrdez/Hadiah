<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%rifas}}`.
 */
class m230704_230308_add_price_column_to_rifas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rifas}}', 'price', $this->float("12,6")->notNull()." AFTER ticket_end");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rifas}}', 'price');
    }
}
