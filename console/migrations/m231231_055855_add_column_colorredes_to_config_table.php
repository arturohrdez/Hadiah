<?php

use yii\db\Migration;

/**
 * Class m231231_055855_add_column_colorredes_to_config_table
 */
class m231231_055855_add_column_colorredes_to_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%config}}', 'colorredes', $this->string(45));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%config}}', 'colorredes');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231231_055855_add_column_colorredes_to_config_table cannot be reverted.\n";

        return false;
    }
    */
}
