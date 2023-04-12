<?php

use yii\db\Migration;

/**
 * Class m230412_040957_add_folio_to_tickets
 */
class m230412_040957_add_folio_to_tickets extends Migration
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
        echo "m230412_040957_add_folio_to_tickets cannot be reverted.\n";

        return false;
    }*/

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%tickets}}', 'folio', $this->string(30)." AFTER ticket");
    }

    public function down()
    {
        $this->dropColumn('{{%tickets}}', 'folio');

    }
}
