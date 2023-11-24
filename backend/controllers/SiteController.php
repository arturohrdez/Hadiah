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
        $searchConfig = Config::find()->count();
        if($searchConfig > 0){
            $model                 = Config::find()->one();
            $model->img            = $model->logo;
            $model->img_favicon    = $model->favicon;
            $model->img_background = $model->backgroundimg;
        }else{
            $model = new Config();
            $model->scenario = 'create';
        }//end if

        if($model->load(Yii::$app->request->post())) {
            //Aux IMG
            $aux_logo      = Yii::$app->request->post()["Config"]["img"];
            $aux_favicon   = Yii::$app->request->post()["Config"]["img_favicon"];
            $aux_backlogin = Yii::$app->request->post()["Config"]["img_background"];

            if(empty($aux_logo)){
                $model->logo = UploadedFile::getInstance($model,'logo');
                if(!empty($model->logo)){
                    $logoName    = $model->logo->name;
                    $model->logo->saveAs('uploads/logos/'.$logoName);
                    $model->logo = 'uploads/logos/'.$logoName;
                }//end if
            }else{
                $model->logo = UploadedFile::getInstance($model,'logo');
                if(!empty($model->logo)){
                    $logoName    = $model->logo->name;
                    $model->logo->saveAs('uploads/logos/'.$logoName);
                    $model->logo = 'uploads/logos/'.$logoName;
                }else{
                    $model->logo = $aux_logo;
                }//end if
            }//end if

            if(empty($aux_favicon)){
                $model->favicon = UploadedFile::getInstance($model,'favicon');
                if(!empty($model->favicon)){
                    $faviconName    = $model->favicon->name;
                    $model->favicon->saveAs('uploads/favicon/'.$faviconName);
                    $model->favicon    = 'uploads/favicon/'.$faviconName;
                }//end if
            }else{
                $model->favicon = UploadedFile::getInstance($model,'favicon');
                if(!empty($model->favicon)){
                    $faviconName    = $model->favicon->name;
                    $model->favicon->saveAs('uploads/favicon/'.$faviconName);
                    $model->favicon    = 'uploads/favicon/'.$faviconName;
                }else{
                    $model->favicon = $aux_favicon;
                }//end if
            }//end if
            
            if(empty($aux_backlogin)){
                $model->backgroundimg = UploadedFile::getInstance($model,'backgroundimg');
                if(!empty($model->backgroundimg)){
                    $backgroundimgName = $model->backgroundimg->name;
                    $model->backgroundimg->saveAs('uploads/backlogin/'.$backgroundimgName);
                    $model->backgroundimg = 'uploads/backlogin/'.$backgroundimgName;
                }//end if
            }else{
                $model->backgroundimg = UploadedFile::getInstance($model,'backgroundimg');
                if(!empty($model->backgroundimg)){
                    $backgroundimgName = $model->backgroundimg->name;
                    $model->backgroundimg->saveAs('uploads/backlogin/'.$backgroundimgName);
                    $model->backgroundimg = 'uploads/backlogin/'.$backgroundimgName;
                }else{
                    $model->backgroundimg = $aux_backlogin;
                }//end if
            }//end if

            if(!$model->validate()){
                Yii::$app->session->setFlash('danger', "La información no se guardo, por favor intente nuevamente.");
                return $this->render('config',[
                    'model'=> $model
                ]);
            }//end if

            //Save Config
            $model->save();
            Yii::$app->session->setFlash('success', "La información se guardo correctamente.");
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
            'model' => $model
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
