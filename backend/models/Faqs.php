<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "faqs".
 *
 * @property int $id
 * @property string|null $pregunta
 * @property string|null $respuesta
 * @property int $status
 */
class Faqs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faqs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pregunta','respuesta','status'], 'required'],
            [['respuesta'], 'string'],
            [['status'], 'required'],
            [['status'], 'integer'],
            [['pregunta'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pregunta' => 'Pregunta',
            'respuesta' => 'Respuesta',
            'status' => 'Estatus',
        ];
    }
}
