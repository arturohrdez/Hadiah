<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ticketstorage}}`.
 */
class m230419_150448_add_columns_to_ticketstorage_table extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%ticketstorage}}', 'folio', $this->string(30)." AFTER ticket");
        $this->addColumn('{{%ticketstorage}}', 'date', $this->dateTime()." AFTER  folio");
        $this->addColumn('{{%ticketstorage}}', 'expiration', $this->string(5)." AFTER  date_end");
        $this->addColumn('{{%ticketstorage}}', 'phone', $this->string(15)." AFTER  expiration");
        $this->addColumn('{{%ticketstorage}}', 'name', $this->string(180)." AFTER  phone");
        $this->addColumn('{{%ticketstorage}}', 'lastname', $this->string(250)." AFTER  name");
        $this->addColumn('{{%ticketstorage}}', 'state', $this->string(100)." AFTER  lastname");
        $this->addColumn('{{%ticketstorage}}', 'transaction_number', $this->string(250)." AFTER  state");
        $this->addColumn('{{%ticketstorage}}', 'type', $this->string(5)." AFTER  transaction_number");
        $this->addColumn('{{%ticketstorage}}', 'status', $this->string(5)." AFTER  type");
        $this->addColumn('{{%ticketstorage}}', 'parent_id', $this->integer()." AFTER  status");
        $this->addColumn('{{%ticketstorage}}', 'date_payment', $this->dateTime()." AFTER  parent_id");
        $this->addColumn('{{%ticketstorage}}', 'type_sale', $this->string(10)." AFTER  date_payment");


    }

    public function safeDown()
    {
        $this->dropColumn('{{%ticketstorage}}', 'folio');
        $this->dropColumn('{{%ticketstorage}}', 'date');
        $this->dropColumn('{{%ticketstorage}}', 'expiration');
        $this->dropColumn('{{%ticketstorage}}', 'phone');
        $this->dropColumn('{{%ticketstorage}}', 'name');
        $this->dropColumn('{{%ticketstorage}}', 'lastname');
        $this->dropColumn('{{%ticketstorage}}', 'state');
        $this->dropColumn('{{%ticketstorage}}', 'transaction_number');
        $this->dropColumn('{{%ticketstorage}}', 'type');
        $this->dropColumn('{{%ticketstorage}}', 'status');
        $this->dropColumn('{{%ticketstorage}}', 'parent_id');
        $this->dropColumn('{{%ticketstorage}}', 'date_payment');
        $this->dropColumn('{{%ticketstorage}}', 'type_sale');
    }
}
