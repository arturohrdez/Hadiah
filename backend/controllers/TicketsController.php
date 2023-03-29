<?php

namespace backend\controllers;

use Yii;
use backend\models\Rifas;
use backend\models\Tickets;
use backend\models\TicketsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TicketsController implements the CRUD actions for Tickets model.
 */
class TicketsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=> AccessControl::className(),
                'only' => ['index','create','update','delete'],
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
     * Lists all Tickets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TicketsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tickets model.
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
     * Creates a new Tickets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tickets();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tickets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //Solo boletos pagados
            if($model->status == "P"){
                if(is_null($model->parent_id)){
                    //Busca si tiene oportunidades
                    $oportunidades = Tickets::find()->where(['parent_id'=>$model->id])->all();
                    if(!empty($oportunidades)){
                        $op_s = "";
                        foreach ($oportunidades as $oportunidad) {
                            $op_s .= "{$oportunidad->ticket},";
                            //Actualiza también las oportunidades relacionadas al boleto
                            $oportunidad->status       = "P";
                            $oportunidad->date_payment = date("Y-m-d H:i:s");
                            $oportunidad->save();
                        }//end foreach

                        $op_str = "(".trim($op_s, ',').")";
                    }//end if
                }//end if

                $model->date_payment = date("Y-m-d H:i:s");
                $model->save();

                if(isset($op_str) && !empty($op_str)){
                    $msg = "Se actualizaron los boletos: <strong>".$model->ticket." ".$op_str."correctamente</strong>";
                }else{
                    $msg = "Se actualizo el boleto #: <strong>".$model->ticket."</strong> correctamente";
                }


                Yii::$app->session->setFlash('success', $msg);
                return $this->redirect(['index']);
            }else{
                return $this->redirect(['index']);    
            }//end if
            //return $this->redirect(['view', 'id' => $model->id]);
        }//end id

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tickets model.
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


    public function actionSales(){
        Yii::$app->session->set('tickets', []);
        Yii::$app->session->set('tickets_play_all',[]);

        $modelRifas = Rifas::find()->where(['status' => 1])->orderBy(['date_init' => SORT_ASC])->all();
        return $this->render('sales',[
            'modelRifas' => $modelRifas,
        ]);
    }//end function


    public static function dumpTicketAC($tickets_ac = []){
        $ticketsAC = []; 
        if(empty($tickets_ac)){
            return $ticketsAC;
        }//end if
        
        foreach ($tickets_ac as $ticket_) {
            $ticketsAC[] = $ticket_->ticket;
        }//end foreach
        return $ticketsAC;
    }//end function

    public function actionSearchticket(){
        $tn_s = Yii::$app->request->post()["tn_s"];
        $max  = Yii::$app->request->post()["max"];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($tn_s > $max){
            return ["status"=>false];
        }//end if

        $modelT  = Tickets::find()->where(['ticket' => $tn_s])->one();
        //Boleto disponible
        if(is_null($modelT)){
            $model   = Rifas::find()->where(["id" => Yii::$app->request->post("id")])->one();

            //Tickets apartados y vendidos
            $tickets_ac = self::dumpTicketAC($model->tickets);
            echo "<pre>";
            var_dump($tickets_ac);
            echo "</pre>";
            die();
            //$allTickets = array_merge($elements,$tickets_ac);

            return ["status"=>true];
        }//end if

        //return ["status"=>false];
    }//end function

    /**
     * Finds the Tickets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tickets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tickets::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
