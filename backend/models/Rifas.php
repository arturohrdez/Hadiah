<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rifas".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $terms
 * @property int|null $opportunities
 * @property string $date_init
 * @property string $main_image
 * @property int $status
 */
class Rifas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rifas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date_init', 'main_image', 'status'], 'required'],
            [['description', 'terms'], 'string'],
            [['opportunities', 'status'], 'required'],
            [['date_init'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['main_image'], 'string', 'max' => 2500],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'description' => 'Descripción',
            'terms' => 'Terminos y Condiciones',
            'opportunities' => 'Num. de Boletos',
            'date_init' => 'Fecha Rifa',
            'main_image' => 'Imagen',
            'status' => 'Estatus',
        ];
    }
}
