<?php

namespace backend\controllers;

use Yii;
use app\models\Ganadores;
use backend\models\Promos;
use backend\models\Rifas;
use backend\models\RifasSearch;
use backend\models\Tickets;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * RifasController implements the CRUD actions for Rifas model.
 */
class RifasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=> AccessControl::className(),
                'only' => ['index','create','update','delete','view'],
                'rules' => [
                    [
                        'allow' =>true,
                        'roles' => ['@']
                    ]
                ]
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Rifas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RifasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rifas model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        //Para la vista de ventas
        $sales = Yii::$app->request->get("sales",null);
        if($sales == true){
            Yii::$app->session->set("rifaId", $id);
        }//end if

        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'sales' => $sales
        ]);
    }

    /**
     * Creates a new Rifas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model           = new Rifas();
        $model->scenario = 'create';

        $modelPromos = new Promos();

        if ($model->load(Yii::$app->request->post())) {
            if(!empty($model->date_init)){
                $model->date_init = date('Y-m-d',strtotime($model->date_init));
            }else{
                $model->date_init = null;
            }//end if

            $model->imagen = UploadedFile::getInstance($model,'imagen');
            if(!empty($model->imagen)){
                $imageName          = $model->imagen->name;
                $model->imagen->saveAs('uploads/rifas/'.$imageName);
                $model->main_image = 'uploads/rifas/'.$imageName;
            }else{
                $model->main_image = null;
            }//end if
            $model->save(false);

            #-- Save Promotion
            $modelPromos->load(Yii::$app->request->post());
            if(!empty($modelPromos->buy_ticket) && !empty($modelPromos->get_ticket)){
                $modelPromos->rifa_id = $model->id;
                $modelPromos->save();
            }//end if
            

            Yii::$app->session->setFlash('success', "Se registro correctamente la Rifa :  <strong>".$model->name."</strong>");
            return $this->redirect(['index']);
        }//end if

        return $this->renderAjax('create', [
            'model'       => $model,
            'modelPromos' => $modelPromos
        ]);
    }

    /**
     * Updates an existing Rifas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model         = $this->findModel($id);
        $modelPromos   = !empty($model->promos) ? $model->promos[0] : new Promos;

        if ($model->load(Yii::$app->request->post())) {
            if(!empty($model->date_init)){
                $model->date_init = date('Y-m-d',strtotime($model->date_init));
            }else{
                $model->date_init = null;
            }//end if


            $model->imagen = UploadedFile::getInstance($model,'imagen');
            if(!empty($model->imagen)){
                $imageName          = $model->imagen->name;
                $model->imagen->saveAs('uploads/rifas/'.$imageName);
                $model->main_image = 'uploads/rifas/'.$imageName;
            }//end if
            $model->save(false);

            #--Promos
            $modelPromos->load(Yii::$app->request->post());
            if(!empty($modelPromos->buy_ticket) && !empty($modelPromos->get_ticket)){
                $modelPromos->rifa_id = $model->id;
                $modelPromos->save();
            }else{
                if(!empty($modelPromos->id)){
                    $modelPromos->delete();
                }//end if
            }//end if

            Yii::$app->session->setFlash('success', "Se actualizo correctamente la Rifa :  <strong>".$model->name."</strong>");
            return $this->redirect(['index']);
        }//end if


        return $this->renderAjax('update', [
            'model' => $model,
            'modelPromos' => $modelPromos
        ]);
    }

    public function actionWinners($id){
        $modelRifa  = Rifas::findOne($id);
        $presorteos = $modelRifa->presorteos;



        $modelPM          = new Ganadores();
        $modelPM->rifa_id = $modelRifa->id;
        $modelTickets     = Tickets::find()->joinWith(['rifa'])
                                ->where(['<>','rifas.status',0])
                                ->andWhere(['rifas.id'=>$id])
                                ->andWhere(['IS','tickets.parent_id',NULL])
                                ->andWhere(['tickets.status'=>'P'])
                                ->orderBy('tickets.ticket ASC')
                                ->all();

        return $this->renderAjax('winners', [
            'modelRifa'    => $modelRifa,
            'modelPM'      => $modelPM,
            'modelTickets' => $modelTickets,
        ]);
    }//end function

    /**
     * Deletes an existing Rifas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rifas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Rifas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rifas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
