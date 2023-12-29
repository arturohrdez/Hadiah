<?php

use yii\db\Migration;

/**
 * Class m231229_170551_creta_faqs_table
 */
class m231229_170551_creta_faqs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%faqs}}', [
            'id'        => $this->primaryKey(),
            'pregunta'  => $this->string(250),
            'respuesta' => $this->text(),
            'status'    => $this->integer(2)->notnull()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%faqs}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231229_170551_creta_faqs_table cannot be reverted.\n";

        return false;
    }
    */
}
