<?php

use yii\db\Migration;

/**
 * Class m230415_082315_add_time_apart_to_rifas_table
 */
class m230415_082315_add_time_apart_to_rifas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    /*public function safeDown()
    {
        echo "m230415_082315_add_time_apart_to_rifas_table cannot be reverted.\n";

        return false;
    }
*/
    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%rifas}}', 'time_apart', $this->string(5)." AFTER date_init");
        $this->addColumn('{{%rifas}}', 'state', $this->string(20)." AFTER time_apart");
    }

    public function down()
    {
        $this->dropColumn('{{%rifas}}', 'time_apart');
        $this->dropColumn('{{%rifas}}', 'state');
    }
}
