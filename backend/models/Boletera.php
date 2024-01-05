<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "boletera".
 *
 * @property int $id
 * @property int $rifa_id
 * @property string|null $template
 *
 * @property Rifas $rifa
 */
class Boletera extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'boletera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rifa_id'], 'required'],
            [['rifa_id'], 'integer'],
            [['template'], 'string'],
            [['rifa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rifas::class, 'targetAttribute' => ['rifa_id' => 'id']],
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
            'template' => 'Template',
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
