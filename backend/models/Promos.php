<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "promos".
 *
 * @property int $id
 * @property int $rifa_id
 * @property int $buy_ticket
 * @property int $get_ticket
 *
 * @property Rifas $rifa
 */
class Promos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rifa_id', 'buy_ticket', 'get_ticket'], 'required', 'on'=>'normal'],
            [['rifa_id', 'buy_ticket', 'get_ticket'], 'integer'],
            [['rifa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rifas::class, 'targetAttribute' => ['rifa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rifa_id' => 'Rifa ID',
            'buy_ticket' => 'Compra Ticket',
            'get_ticket' => 'Obten Ticket Gratis',
        ];
    }

    /**
     * Gets query for [[Rifa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRifa()
    {
        return $this->hasOne(Rifas::class, ['id' => 'rifa_id']);
    }
}
