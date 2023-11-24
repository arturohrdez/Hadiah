<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%config}}`.
 */
class m231124_193358_add_tiktok_column_to_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $this->addColumn('{{%config}}', 'tiktok', $this->string()." AFTER youtube");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(){
        $this->dropColumn('{{%config}}', 'tiktok');
    }
}
