<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%rifas}}`.
 */
class m230615_224211_add_presorteos_column_to_rifas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rifas}}', 'presorteos', $this->integer(11)." AFTER time_apart");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rifas}}', 'presorteos');
    }
}
