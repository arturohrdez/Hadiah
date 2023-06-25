<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ganadores}}`.
 */
class m230625_052408_add_type_column_to_ganadores_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ganadores}}', 'type', $this->string(15)." AFTER description");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ganadores}}', 'type');
    }
}
