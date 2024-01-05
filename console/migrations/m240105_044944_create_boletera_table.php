<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%boletera}}`.
 */
class m240105_044944_create_boletera_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%boletera}}', [
            'id'       => $this->primaryKey(),
            'rifa_id'  => $this->integer()->notNull(),
            'template' => "MEDIUMTEXT"

        ]);

        // creates index for column `rifa_id`
        $this->createIndex(
            '{{%idx-boletera-rifa_id}}',
            '{{%boletera}}',
            'rifa_id'
        );

        // add foreign key for table `{{%rifas}}`
        $this->addForeignKey(
            '{{%fk-boletera-rifa_id}}',
            '{{%boletera}}',
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
            '{{%fk-boletera-rifa_id}}',
            '{{%boletera}}'
        );

        // drops index for column `rifa_id`
        $this->dropIndex(
            '{{%idx-boletera-rifa_id}}',
            '{{%boletera}}'
        );
        $this->dropTable('{{%boletera}}');
    }
}
