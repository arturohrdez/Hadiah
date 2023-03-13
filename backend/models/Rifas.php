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
 * @property int|null $ticket_init
 * @property int|null $ticket_end
 * @property string $date_init
 * @property string $main_image
 * @property int $status
 */
class Rifas extends \yii\db\ActiveRecord
{
    public $imagen;

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
            [['imagen'],'required','on'=>'create'],
            [['name', 'date_init', 'status', 'ticket_init', 'ticket_end'], 'required'],
            [['description', 'terms'], 'string'],
            [['ticket_init', 'ticket_end', 'status'], 'integer'],
            [['date_init'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['main_image'], 'string', 'max' => 2500],
            [['name'], 'unique'],

            [['imagen'],'image','extensions'=>'jpeg,jpg,png','minWidth' => 190,'maxWidth'=>1500,'minHeight'=>190,'maxHeight'=>1500,'maxSize'=>1024 * 1024 * 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Titulo',
            'description' => 'Descripción',
            'terms' => 'Terminos y Condiciones',
            'ticket_init' => 'Primer Boleto',
            'ticket_end' => 'Último Boleto',
            'date_init' => 'Fecha Rifa',
            'main_image' => 'Imagen',
            'status' => 'Estatus',
        ];
    }

     /**
     * Gets query for [[Rifa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromos()
    {
        return $this->hasMany(Promos::className(), ['rifa_id' => 'id']);
    }
}
