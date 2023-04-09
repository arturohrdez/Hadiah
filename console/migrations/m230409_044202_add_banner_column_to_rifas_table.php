<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%rifas}}`.
 */
class m230409_044202_add_banner_column_to_rifas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rifas}}', 'banner', $this->integer(2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rifas}}', 'banner');
    }
}
