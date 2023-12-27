<?php

namespace backend\models;

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
    public $img;
    public $img_favicon;
    public $img_background;
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
            [['logo'],'required','on'=>'create'],
            [['sitename'], 'required'],
            [['slogan', 'logo', 'favicon'], 'string'],
            [['logo'],'image','extensions'=>'jpeg,jpg,png','minWidth' => 500,'maxWidth'=>777,'minHeight'=>500,'maxHeight'=>777,'maxSize'=>1024 * 1024 * 2],
            [['favicon'],'image','extensions'=>'ico','minWidth' => 48,'maxWidth'=>48,'minHeight'=>48,'maxHeight'=>48,'maxSize'=>1024 * 1024 * 2],
            [['backgroundimg'],'image','extensions'=>'jpeg,jpg,png','minWidth' => 900,'maxWidth'=>1980,'minHeight'=>900,'maxHeight'=>1980,'maxSize'=>1024 * 1024 * 2],

            [['sitename'], 'string', 'max' => 150],
            //[['whatsapp'], 'string', 'max' => 15]
            [['whatsapp'], 'string', 'min' => 10, 'max' => 15],
            [['whatsapp'], 'match', 'pattern' => '/^\d+$/i', 'message' => 'El número debe contener solo dígitos.'],

            [['instagram', 'facebook', 'youtube','tiktok' ,'video','img','img_favicon','img_background'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'sitename'      => 'Nombre del sitio',
            'slogan'        => 'Slogan',
            'logo'          => 'Logo',
            'favicon'       => 'Favicon',
            'backgroundimg' => 'Imagen Login',
            'whatsapp'      => 'Whatsapp',
            'instagram'     => 'Instagram',
            'facebook'      => 'Facebook',
            'youtube'       => 'Youtube',
            'tiktok'        => 'Tik Tok',
            'video'         => 'Video de presentación',
        ];
    }
}
