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
 * @property string|null $date_end
 * @property string $phone
 * @property string $name
 * @property string $lastname
 * @property string $state
 * @property string $type
 * @property string $status
 * @property int|null $parent_id
 * @property string|null $date_payment
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
            [['rifa_id', 'parent_id'], 'integer'],
            [['date', 'date_end', 'date_payment'], 'safe'],
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
            'id'           => 'ID',
            'rifa_id'      => 'Rifa',
            'ticket'       => 'Boleto',
            'date'         => 'Date',
            'date_end'     => 'Date End',
            'phone'        => 'Teléfono',
            'name'         => 'Nombre(s)',
            'lastname'     => 'Apellidos',
            'state'        => 'Estado',
            'type'         => 'Type',
            'status'       => 'Estatus',
            'parent_id'    => 'Parent ID',
            'date_payment' => 'Date Payment',
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
