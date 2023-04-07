<?php 
use yii\db\Migration;

/**
 * Handles the creation of table `{{%mutex}}`.
 */
class m210407_000000_create_mutex_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mutex}}', [
            'name' => $this->string(255)->notNull(),
            'owner' => $this->string(255),
            'expire' => $this->integer(),
            'PRIMARY KEY([[name]])',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mutex}}');
    }
}
