<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property string $sitename
 * @property string|null $slogan
 * @property string $logo
 * @property string|null $favicon
 * @property string|null $whatsapp
 * @property string|null $instagram
 * @property string|null $facebook
 * @property string|null $youtube
 * @property string|null $video
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sitename', 'logo'], 'required'],
            [['slogan', 'logo', 'favicon'], 'string'],
            [['sitename'], 'string', 'max' => 150],
            [['whatsapp'], 'string', 'max' => 15],
            [['instagram', 'facebook', 'youtube', 'video'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sitename' => 'Nombre del sitio',
            'slogan' => 'Slogan',
            'logo' => 'Logo',
            'favicon' => 'Favicon',
            'whatsapp' => 'Whatsapp',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'youtube' => 'Youtube',
            'video' => 'Video de presentación',
        ];
    }
}
