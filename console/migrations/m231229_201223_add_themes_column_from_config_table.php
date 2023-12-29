<?php

use yii\db\Migration;

/**
 * Class m231229_201223_add_themes_column_from_config_table
 */
class m231229_201223_add_themes_column_from_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $this->addColumn('{{%config}}', 'theme', $this->string(20));
        $this->addColumn('{{%config}}', 'titlecolor', $this->string(45));
        $this->addColumn('{{%config}}', 'fontcolor', $this->string(45));
        $this->addColumn('{{%config}}', 'navbarcolor', $this->string(45));
        $this->addColumn('{{%config}}', 'bgbuttoncolor', $this->string(45));
        $this->addColumn('{{%config}}', 'txtbuttoncolor', $this->string(45));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(){
        $this->dropColumn('{{%config}}', 'theme');
        $this->dropColumn('{{%config}}', 'titlecolor');
        $this->dropColumn('{{%config}}', 'fontcolor');
        $this->dropColumn('{{%config}}', 'navbarcolor');
        $this->dropColumn('{{%config}}', 'bgbuttoncolor');
        $this->dropColumn('{{%config}}', 'txtbuttoncolor');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231229_201223_add_themes_column_from_config_table cannot be reverted.\n";

        return false;
    }
    */
}
