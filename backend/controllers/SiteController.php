<?php

namespace backend\controllers;

use Yii;
use app\models\Config;
use common\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','config'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'errorLayout'
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionConfig(){
        $model = new Config();

        if($model->load(Yii::$app->request->post())) {
            $model->logo = UploadedFile::getInstance($model,'logo');
            if(!empty($model->logo)){
                $logoName    = $model->logo->name;
                $model->logo->saveAs('uploads/logos/'.$logoName);
                $model->logo = 'uploads/logos/'.$logoName;
            }//end if

            $model->favicon = UploadedFile::getInstance($model,'favicon');
            if(!empty($model->favicon)){
                $faviconName    = $model->favicon->name;
                $model->favicon->saveAs('uploads/favicon/'.$faviconName);
                $model->favicon    = 'uploads/favicon/'.$faviconName;
            }//end if

            if(!$model->validate()){
                return $this->render('config',[
                    'model'=> $model
                ]);
            }//end if

            $model->save();
        }//end if

        return $this->render('config',[
            'model'=> $model
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //Layout Login
        $this->layout = "main-login";
        $model        = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
