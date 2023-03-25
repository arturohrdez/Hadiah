<?php 

namespace frontend\models;

use Yii;
use yii\base\Model;

class TicketForm extends Model
{
	public $rifa_id;
    public $phone;
    public $name;
    public $lastname;
    public $state;

    public function rules()
    {
        return [
            // name, email, subject and body are required
			[['rifa_id','phone', 'name', 'lastname', 'state'], 'required'],
			[['phone'], 'number', 'max'    => 9999999999],
			[['name'], 'string', 'max'     => 180],
			[['lastname'], 'string', 'max' => 250],
        ];
    }

    public function attributeLabels()
    {
        return [
			'phone'    => 'Teléfono',
			'name'     => 'Nombre(s)',
			'lastname' => 'Apellidos',
			'state'    => 'Estado'
        ];
    }

}