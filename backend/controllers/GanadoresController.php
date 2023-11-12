<?php

namespace backend\controllers;

use Yii;
use backend\models\Ganadores;
use backend\models\GanadoresSearch;
use backend\models\Rifas;
use backend\models\Tickets;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GanadoresController implements the CRUD actions for Ganadores model.
 */
class GanadoresController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ganadores models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel          = new GanadoresSearch();

        if(!empty(Yii::$app->request->get('id'))){
            $searchModel->rifa_id = Yii::$app->request->get('id');
            $modelRifa            = Rifas::findOne(Yii::$app->request->get('id'));
        }else{
            $searchModel->rifa_id = NULL;
            $modelRifa            = NULL;
        }//end if

        $dataProvider         = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'modelRifa'    => $modelRifa
        ]);
    }

    /**
     * Displays a single Ganadores model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ganadores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model          = new Ganadores();

        if(!empty(Yii::$app->request->get('rifa_id'))){
            $model->rifa_id = Yii::$app->request->get('rifa_id');
        }//end if

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->type == "PM"){
                $modelRifa = Rifas::find()->where(["id"=>$model->rifa_id])->one();
                $modelRifa->status = 0;
                $modelRifa->save(false);

                Yii::$app->session->setFlash('success', "Se guardo correctamente el registro del ganador y se desactivo la Rifa :  <strong>".$modelRifa->name."</strong>");
            }//end if

            $model->save();
            return $this->redirect(['index',"id"=>Yii::$app->request->get('rifa_id')]);
        }//end if

        $rifas        = Rifas::find()->where(["=","status",1])->all();
        $modelTickets = Tickets::find()->joinWith(['rifa'])
                            ->where(['=','rifas.status',1])
                            ->andWhere(['rifas.id'       =>$model->rifa_id])
                            ->andWhere(['tickets.status' =>'P'])
                            ->orderBy('tickets.ticket ASC')
                            ->all();
        return $this->renderAjax('create', [
            'model'        => $model,
            'rifas'        => $rifas,
            'modelTickets' => $modelTickets
        ]);
    }

    /**
     * Updates an existing Ganadores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ganadores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id){
        $modelGanador = $this->findModel($id);
        if($modelGanador->type == "PM"){
            $modelRifa         = Rifas::findOne($modelGanador->rifa->id);
            $modelRifa->status = 1;
            $modelRifa->save(false);
            $rifa_id           = $modelGanador->rifa->id;
            Yii::$app->session->setFlash('success', "Se elimino correctamente el registro de ganador y se activo la Rifa :  <strong>".$modelRifa->name."</strong>");
        }else{
            $rifa_id = $modelGanador->rifa->id;
            Yii::$app->session->setFlash('success', "Se elimino correctamente el ticket: <strong>".$modelGanador->ticket->ticket."</strong>");
        }//end if

        $modelGanador->delete();

        //$this->findModel($id)->delete();
        return $this->redirect(['index','id'=>$rifa_id]);
    }

    /**
     * Finds the Ganadores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ganadores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ganadores::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
