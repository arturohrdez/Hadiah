<?php

namespace backend\models;

use Yii;
use backend\models\Rifas;
use backend\models\Tickets;

/**
 * This is the model class for table "ganadores".
 *
 * @property int $id
 * @property int $rifa_id
 * @property int $ticket_id
 * @property string $description
 * @property string|null $type 
 *
 * @property Rifas $rifa
 * @property Tickets $ticket
 */
class Ganadores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ganadores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rifa_id', 'ticket_id', 'description','type'], 'required'],
            [['rifa_id', 'ticket_id'], 'integer'],
            [['description'], 'string', 'max' => 250],
            [['type'], 'string', 'max' => 15], 
            [['rifa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rifas::class, 'targetAttribute' => ['rifa_id' => 'id']],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tickets::class, 'targetAttribute' => ['ticket_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'rifa_id'     => 'Rifa',
            'ticket_id'   => 'Ticket',
            'description' => 'Detalle del premio',
            'type'        => 'Tipo de premio',
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

    /**
     * Gets query for [[Ticket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Tickets::class, ['id' => 'ticket_id']);
    }
}
