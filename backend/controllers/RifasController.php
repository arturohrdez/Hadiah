<?php

namespace backend\controllers;

use Yii;
use backend\models\Promos;
use backend\models\Rifas;
use backend\models\RifasSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rifas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model       = new Rifas();
        $modelPromos = new Promos();

        if ($model->load(Yii::$app->request->post())) {
            if(!empty($model->date_init)){
                $model->date_init = date('Y-m-d',strtotime($model->date_init));
            }else{
                $model->date_init = null;
            }//end if
            $model->save();

            #-- Save Promotion
            $modelPromos->load(Yii::$app->request->post());
            $modelPromos->rifa_id = $model->id;
            $modelPromos->save();

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
        $model       = $this->findModel($id);
        $modelPromos = !empty($model->promos) ? $model->promos[0] : new Promos;

        if ($model->load(Yii::$app->request->post())) {
            if(!empty($model->date_init)){
                $model->date_init = date('Y-m-d',strtotime($model->date_init));
            }else{
                $model->date_init = null;
            }//end if
            $model->save();

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
