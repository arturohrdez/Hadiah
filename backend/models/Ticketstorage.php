<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ticketstorage".
 *
 * @property int $id
 * @property int $rifa_id
 * @property string $ticket
 * @property string|null $folio
 * @property string|null $date
 * @property string $date_ini
 * @property string $date_end
 * @property string|null $expiration
 * @property string|null $phone
 * @property string|null $name
 * @property string|null $lastname
 * @property string|null $state
 * @property string|null $transaction_number
 * @property string|null $type
 * @property string|null $status
 * @property int|null $parent_id
 * @property string|null $date_payment
 * @property string|null $type_sale
 * @property string|null $uuid
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Rifas $rifa
 */
class Ticketstorage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticketstorage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rifa_id', 'ticket', 'date_ini', 'date_end'], 'required'],
            [['rifa_id', 'parent_id'], 'integer'],
            [['date', 'date_ini', 'date_end', 'date_payment'], 'safe'],
            [['ticket', 'uuid', 'created_at', 'updated_at'], 'string', 'max' => 255],
            [['folio'], 'string', 'max' => 30],
            [['expiration', 'type', 'status'], 'string', 'max' => 5],
            [['phone'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 180],
            [['lastname', 'transaction_number'], 'string', 'max' => 250],
            [['state'], 'string', 'max' => 100],
            [['type_sale'], 'string', 'max' => 10],
            [['rifa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rifas::class, 'targetAttribute' => ['rifa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'rifa_id'            => 'Rifa',
            'ticket'             => 'Boleto',
            'folio'              => 'Folio',
            'date'               => 'Date',
            'date_end'           => 'Date End',
            'phone'              => 'Teléfono',
            'name'               => 'Nombre(s)',
            'lastname'           => 'Apellidos',
            'state'              => 'Estado',
            'transaction_number' => 'Número de transacción',
            'type'               => 'Type',
            'type_sale'          => 'Vendido',
            'status'             => 'Estatus',
            'parent_id'          => 'Parent ID',
            'date_payment'       => 'Fecha de Pago',
            'expiration'         => 'Plazo vencido',
            'uuid'               => 'Uuid',
            'created_at'         => 'Created At',
            'updated_at'         => 'Updated At',
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
