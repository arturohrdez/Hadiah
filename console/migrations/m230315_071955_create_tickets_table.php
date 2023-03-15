<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tickets}}`.
 */
class m230315_071955_create_tickets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tickets}}', [
            'id'       => $this->primaryKey(),
            'rifa_id'  => $this->integer()->notNull(),
            'ticket'   => $this->string()->notNull(),
            'date'     => $this->dateTime()->notNull(),
            'phone'    => $this->string(15)->notNull(),
            'name'     => $this->string(180)->notNull(),
            'lastname' => $this->string(250)->notNull(),
            'state'    => $this->string(100)->notNull(),
            'type'     => $this->string(5)->notNull(),
            'status'   => $this->string(5)->notNull(),
        ]);

        // creates index for column `rifa_id`
        $this->createIndex(
            '{{%idx-tickets-rifa_id}}',
            '{{%tickets}}',
            'rifa_id'
        );

        // add foreign key for table `{{%rifas}}`
        $this->addForeignKey(
            '{{%fk-tickets-rifa_id}}',
            '{{%tickets}}',
            'rifa_id',
            '{{%rifas}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%rifas}}`
        $this->dropForeignKey(
            '{{%fk-tickets-rifa_id}}',
            '{{%tickets}}'
        );

        // drops index for column `rifa_id`
        $this->dropIndex(
            '{{%idx-tickets-rifa_id}}',
            '{{%tickets}}'
        );

        $this->dropTable('{{%tickets}}');
    }
}
