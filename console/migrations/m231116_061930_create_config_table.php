<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%config}}`.
 */
class m231116_061930_create_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey(),
            'sitename' => $this->string(150)->notnull(),
            'slogan' => $this->text(),
            'logo' => $this->text()->notNull(),
            'favicon' => $this->text(),
            'whatsapp' => $this->string(15),
            'instagram' => $this->string(250),
            'facebook' => $this->string(250),
            'youtube' => $this->string(250),
            'video' => $this->string(250),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%config}}');
    }
}
