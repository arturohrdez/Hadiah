<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categorias}}`.
 */
class m220905_145131_create_categorias_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categorias}}', [
            'id'        => $this->primaryKey(),
            'name'      => $this->string(255)->notNull()->unique(),
            'parent_id' => $this->integer(255),
            'logo'      => $this->string(2500)->notnull(),
            'status'    => $this->integer(255)->notnull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categorias}}');
    }
}
