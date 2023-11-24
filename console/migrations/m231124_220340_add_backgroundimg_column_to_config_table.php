<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_backgroundimg_column_to_config}}`.
 */
class m231124_220340_add_backgroundimg_column_to_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%config}}', 'backgroundimg', $this->string()." AFTER favicon");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%config}}', 'backgroundimg');
    }
}
