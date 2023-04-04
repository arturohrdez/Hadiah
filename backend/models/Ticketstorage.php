<?php

namespace backend\models;

use Yii;
use yii\behaviors\OptimisticLockBehavior;

/**
 * This is the model class for table "ticketstorage".
 *
 * @property int $id
 * @property int $rifa_id
 * @property string $ticket
 * @property string $date_ini
 * @property string $date_end
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
            [['rifa_id'], 'integer'],
            [['date_ini', 'date_end'], 'safe'],
            [['ticket'], 'string', 'max' => 255],
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
            'date_ini' => 'Date Ini',
            'date_end' => 'Date End',
        ];
    }
}
