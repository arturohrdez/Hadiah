<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promos}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%rifas}}`
 */
class m230312_043636_create_promos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promos}}', [
            'id' => $this->primaryKey(),
            'rifa_id' => $this->integer()->notNull(),
            'buy_ticket' => $this->integer()->notNull(),
            'get_ticket' => $this->integer()->notNull(),
        ]);

        // creates index for column `rifa_id`
        $this->createIndex(
            '{{%idx-promos-rifa_id}}',
            '{{%promos}}',
            'rifa_id'
        );

        // add foreign key for table `{{%rifas}}`
        $this->addForeignKey(
            '{{%fk-promos-rifa_id}}',
            '{{%promos}}',
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
            '{{%fk-promos-rifa_id}}',
            '{{%promos}}'
        );

        // drops index for column `rifa_id`
        $this->dropIndex(
            '{{%idx-promos-rifa_id}}',
            '{{%promos}}'
        );

        $this->dropTable('{{%promos}}');
    }
}
