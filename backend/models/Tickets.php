<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tickets".
 *
 * @property int $id
 * @property int $rifa_id
 * @property string $ticket
 * @property string $date
 * @property string $phone
 * @property string $name
 * @property string $lastname
 * @property string $state
 * @property string $type
 * @property string $status
 *
 * @property Rifas $rifa
 */
class Tickets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tickets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rifa_id', 'ticket', 'date', 'phone', 'name', 'lastname', 'state', 'type', 'status'], 'required'],
            [['rifa_id'], 'integer'],
            [['date'], 'safe'],
            [['ticket'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 180],
            [['lastname'], 'string', 'max' => 250],
            [['state'], 'string', 'max' => 100],
            [['type', 'status'], 'string', 'max' => 5],
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
            'ticket' => 'Ticket',
            'date' => 'Date',
            'phone' => 'Phone',
            'name' => 'Name',
            'lastname' => 'Lastname',
            'state' => 'State',
            'type' => 'Type',
            'status' => 'Status',
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
