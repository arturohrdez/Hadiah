<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%config}}`.
 */
class m231228_190927_add_quienessomos_column_to_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%config}}', 'quienessomos', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%config}}', 'quienessomos');
    }
}
