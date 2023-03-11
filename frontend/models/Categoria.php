<?php

namespace frontend\models;

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
class Categoria extends \yii\db\ActiveRecord
{
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
            [['name', 'logo', 'status'], 'required'],
            [['parent_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['logo'], 'string', 'max' => 2500],
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
            'logo' => 'Logo',
            'status' => 'Status',
        ];
    }
}
