<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ganadores}}`.
 */
class m230615_233653_create_ganadores_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ganadores}}', [
            'id'          => $this->primaryKey(),
            'rifa_id'     => $this->integer()->notNull(),
            'ticket_id'   => $this->integer()->notNull(),
            'description' => $this->string(250)->notNull()
        ]);

        // creates index for column `rifa_id`
        $this->createIndex(
            '{{%idx-ganadores-rifa_id}}',
            '{{%ganadores}}',
            'rifa_id'
        );


        // add foreign key for table `{{%rifas}}`
        $this->addForeignKey(
            '{{%fk-ganadores-rifa_id}}',
            '{{%ganadores}}',
            'rifa_id',
            '{{%rifas}}',
            'id',
            'CASCADE'
        );

        // creates index for column `rifa_id`
        $this->createIndex(
            '{{%idx-ganadores-ticket_id}}',
            '{{%ganadores}}',
            'ticket_id'
        );

        $this->addForeignKey(
            '{{%fk-ganadores-ticket_id}}',
            '{{%ganadores}}',
            'ticket_id',
            '{{%tickets}}',
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
            '{{%fk-ganadores-rifa_id}}',
            '{{%ganadores}}'
        );

        // drops index for column `rifa_id`
        $this->dropIndex(
            '{{%idx-ganadores-rifa_id}}',
            '{{%ganadores}}'
        );

        // drops foreign key for table `{{%ticket}}`
        $this->dropForeignKey(
            '{{%fk-ganadores-ticket_id}}',
            '{{%ganadores}}'
        );

        // drops index for column `ticket_id`
        $this->dropIndex(
            '{{%idx-ganadores-ticket_id}}',
            '{{%ganadores}}'
        );

        $this->dropTable('{{%ganadores}}');
    }
}
