<?php 

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

use yii\helpers\HtmlPurifier;

class TicketForm extends \yii\db\ActiveRecord
{
	public $rifa_id;
    public $phone;
    public $name;
    public $lastname;
    public $state;
    public $tickets_selected;
    public $tickets_rand;

    public function rules()
    {
        return [
            // name, email, subject and body are required
			[['rifa_id','phone', 'name', 'lastname', 'state','tickets_selected'], 'required'],
			//[['phone'], 'number', 'max'    => 9999999999],
            ['phone', 'number'],
            ['phone', 'string', 'length' => 10],
			[['name'], 'string', 'max'     => 180],
			[['lastname'], 'string', 'max' => 250],
            [['name','tickets_rand'], 'safe'],
            [['phone','name','lastname','state'], 'validarSqlInjection'],
            [['phone'], 'filter','filter' => function($value) {
                $cleanValue = HtmlPurifier::process($value);
                if ($value !== $cleanValue) {
                    $this->addError('phone', 'El campo Teléfono contiene caracteres no permitidos.');
                }
                return $cleanValue;
            }],
            [['name'], 'filter','filter' => function($value) {
                $cleanValue = HtmlPurifier::process($value);
                if ($value !== $cleanValue) {
                    $this->addError('name', 'El campo Nombre contiene caracteres no permitidos.');
                }
                return $cleanValue;
            }],
            [['lastname'], 'filter','filter' => function($value) {
                $cleanValue = HtmlPurifier::process($value);
                if ($value !== $cleanValue) {
                    $this->addError('lastname', 'El campo Apellido(s) contiene caracteres no permitidos.');
                }
                return $cleanValue;
            }],
            [['state'], 'filter','filter' => function($value) {
                $cleanValue = HtmlPurifier::process($value);
                if ($value !== $cleanValue) {
                    $this->addError('state', 'El campo Estado contiene caracteres no permitidos.');
                }
                return $cleanValue;
            }],
        ];
    }

    public function validarSqlInjection($attribute, $params)
    {
        $this->$attribute = Html::encode($this->$attribute); // escapar los caracteres especiales
        if (preg_match("/\b(ALTER|CREATE|DELETE|DROP|EXEC(UTE){0,1}|INSERT( +INTO){0,1}|SELECT|UNION( +ALL){0,1})\b/i", $this->$attribute)) {
            $this->addError($attribute, 'Este campo no puede contener código SQL no permitido.');
        }
    }

    /*public function validateContent($attribute, $params)
    {
        $this->$attribute = HtmlPurifier::process($this->$attribute);
        if ($this->$attribute !== $this->$attribute) {
            $this->addError($attribute, 'El campo contiene código malicioso');
        }
    }*/

    public function attributeLabels()
    {
        return [
			'phone'    => 'Teléfono',
			'name'     => 'Nombre(s)',
			'lastname' => 'Apellidos',
			'state'    => 'Estado',
            'tickets_selected' => 'Tickets',
            'tickets_rand' => 'oportunidades'
        ];
    }

}