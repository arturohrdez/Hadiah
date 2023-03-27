<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tickets}}`.
 */
class m230327_150525_add_date_payment_column_to_tickets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tickets}}', 'date_payment', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tickets}}', 'date_payment');
    }
}
