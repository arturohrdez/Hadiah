<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%rifas}}`.
 */
class m231108_235521_add_phone_column_to_rifas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rifas}}', 'phone', $this->string(15)." AFTER ticket_end");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropColumn('{{%rifas}}', 'phone');
    }
}
