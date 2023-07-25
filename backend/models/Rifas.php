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
            [['price','name', 'date_init', 'status', 'ticket_init', 'ticket_end','banner','time_apart','state'], 'required'],
            [['description', 'terms'], 'string'],
            [['ticket_init', 'ticket_end', 'status','banner','time_apart'], 'integer'],
            ['ticket_init', 'compare', 'compareValue'=>0, 'operator'=>'>='],
            ['ticket_end', 'compare', 'compareValue'=>0, 'operator'=>'>'],
            [['date_init'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['time_apart'], 'string', 'max' => 255],
            [['main_image'], 'string', 'max' => 5],
            [['state'], 'string', 'max' => 20],
            [['presorteos'], 'integer'],
            [['name'], 'unique'],
            ['price','number','numberPattern' => "/^\d+(\.\d{1,3})?$/"],
            [['imagen'],'image','extensions'=>'jpeg,jpg,png','minWidth' => 190,'maxWidth'=>1980,'minHeight'=>190,'maxHeight'=>1980,'maxSize'=>1024 * 1024 * 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Titulo',
            'description' => 'Descripción',
            'terms'       => 'Terminos y Condiciones',
            'ticket_init' => 'Primer Boleto',
            'ticket_end'  => 'Último Boleto',
            'date_init'   => 'Fecha Rifa',
            'time_apart'  => 'Tiempo Apartado',
            'state'       => 'Estado donde aplica',
            'main_image'  => 'Imagen',
            'status'      => 'Estatus',
            'banner'      =>'¿Mostrar en el Banner?'
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

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::className(), ['rifa_id' => 'id']);
    }
}
