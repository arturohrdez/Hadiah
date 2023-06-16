<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property string $logo
 * @property int $status
 */
class Categorias extends \yii\db\ActiveRecord
{
    public $archivo;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['parent_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['archivo'], 'file', 'extensions' => 'jpg,png'],
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
            'name' => 'Name',
            'parent_id' => 'Parent ID',
            'archivo' => 'Logo',
            'status' => 'Status',
        ];
    }
}
