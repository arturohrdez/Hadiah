<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rifas}}`.
 */
class m230310_225135_create_rifas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rifas}}', [
            'id'          => $this->primaryKey(),
            'name'        => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
            'terms'       => $this->text(),
            'ticket_init' => $this->integer(35),
            'ticket_end'  => $this->integer(35),
            'date_init'   => $this->dateTime()->notNull(),
            'main_image'  => $this->string(2500)->notnull(),
            'status'      => $this->integer(2)->notnull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rifas}}');
    }
}
