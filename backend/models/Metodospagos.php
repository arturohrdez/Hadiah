<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "metodospagos".
 *
 * @property int $id
 * @property string|null $banco
 * @property string|null $nombre
 * @property string|null $tarjeta
 * @property string|null $cuenta
 * @property string|null $clabe
 * @property int $status
 */
class Metodospagos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodospagos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status','banco','nombre'], 'required'],
            [['status'], 'integer'],
            [['banco', 'nombre'], 'string', 'max' => 200],
            [['tarjeta', 'cuenta', 'clabe'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banco' => 'Banco',
            'nombre' => 'Nombre',
            'tarjeta' => 'Número de tarjeta',
            'cuenta' => 'Número de cuenta',
            'clabe' => 'Clabe',
            'status' => 'Estatus',
        ];
    }
}
