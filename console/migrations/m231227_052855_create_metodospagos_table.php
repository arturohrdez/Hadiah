<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pagos}}`.
 */
class m231227_052855_create_metodospagos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%metodospagos}}', [
            'id'      => $this->primaryKey(),
            'banco'   => $this->string(200),
            'nombre'  => $this->string(200),
            'tarjeta' => $this->string(100),
            'cuenta'  => $this->string(100),
            'clabe'   => $this->string(100),
            'status'  => $this->integer(2)->notnull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%metodospagos}}');
    }
}
