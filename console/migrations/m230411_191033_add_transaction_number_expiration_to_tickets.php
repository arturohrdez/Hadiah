<?php

use yii\db\Migration;

/**
 * Class m230411_191033_add_transaction_number_expiration_to_tickets
 */
class m230411_191033_add_transaction_number_expiration_to_tickets extends Migration
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
        echo "m230411_191033_add_transaction_number_expiration_to_tickets cannot be reverted.\n";

        return false;
    }*/

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%tickets}}', 'transaction_number', $this->string(250)." AFTER state");
        $this->addColumn('{{%tickets}}', 'expiration', $this->string(5)." AFTER  date_end");

    }

    public function down()
    {
        $this->dropColumn('{{%tickets}}', 'transaction_number');
        $this->dropColumn('{{%tickets}}', 'expiration');
    }
    
}
