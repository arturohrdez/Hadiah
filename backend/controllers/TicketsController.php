<?php

namespace backend\controllers;

use Yii;
use backend\models\Rifas;
use backend\models\Tickets;
use backend\models\TicketsSearch;
use backend\models\Ticketstorage;
use frontend\models\TicketForm;
use yii\db\Transaction;
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
                'class'=> AccessControl::class,
                'only' => ['index','create','update','delete','sales','view','listtickets','createtickets','searchticket','ticketremove','pagar','sendwp','expirate','search'],
                'rules' => [
                    [
                        'allow' =>true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
        $searchModel  = new TicketsSearch();

        $params = Yii::$app->request->queryParams;
        $params['TicketsSearch']['expiration'] = "0";
        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExpirate(){
        $searchModel  = new TicketsSearch();

        $params = Yii::$app->request->queryParams;
        $params['TicketsSearch']['expiration'] = "1";
        $dataProvider = $searchModel->search($params);

        return $this->render('expirate', [
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
        $model->scenario = 'payment';
        
        if ($model->load(Yii::$app->request->post())) {
            //Solo boletos pagados
            if($model->status == "P"){
                //Hace la busqueda por folio para poder actualizar todos los tickets con el mismo folio
                $folio_ = $model->folio;
                if(!empty($folio_)){
                    $modelTF = Tickets::find()->where(["rifa_id"=>$model->rifa_id,"folio"=>$folio_])->all();
                    if(!empty($modelTF)){
                        $tickets_update = "";
                        foreach ($modelTF as $ticketF) {
                            $ticketF->transaction_number = $model->transaction_number;
                            $ticketF->status             = "P";
                            $ticketF->date_payment       = $model->date_payment;
                            $ticketF->expiration         = "0";
                            $ticketF->save();
                            $tickets_update .= $ticketF->ticket.",";
                        }//end foreach

                         $tickets_update = "(".trim($tickets_update, ',').")";
                    }//end if
                }else{
                    if(is_null($model->parent_id)){
                        //Busca si tiene oportunidades
                        $oportunidades = Tickets::find()->where(['parent_id'=>$model->id])->all();
                        if(!empty($oportunidades)){
                            $op_s = "";
                            foreach ($oportunidades as $oportunidad) {
                                $op_s .= "{$oportunidad->ticket},";
                                //Actualiza también las oportunidades relacionadas al boleto
                                $oportunidad->transaction_number = $model->transaction_number;
                                $oportunidad->status             = "P";
                                $oportunidad->date_payment       = $model->date_payment;
                                $oportunidad->expiration         = "0";
                                $oportunidad->save();
                            }//end foreach

                            $op_str = "(".trim($op_s, ',').")";
                        }//end if
                    }//end if

                    //$model->date_payment = date("Y-m-d H:i:s");
                    $model->expiration = "0";
                    $model->save();
                }//end if

                if(isset($op_str) && !empty($op_str)){
                    $msg = "Se actualizaron los boletos: <strong>".$model->ticket." ".$op_str."correctamente</strong>";
                }else{
                    //$msg = "Se actualizo el boleto #: <strong>".$model->ticket."</strong> correctamente";
                    $msg = "Se actualizaron los boletos:: <strong>".$tickets_update."</strong> correctamente";
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
        //$this->findModel($id)->delete();
        $modelTicket   = $this->findModel($id);
        $ticket_folio  = $modelTicket->folio;
        $ticket_rifaId = $modelTicket->rifa_id;

        $modelTF = Tickets::find()->where(["rifa_id"=>$ticket_rifaId,"folio"=>$ticket_folio])->all();

        $connection  = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            foreach ($modelTF as $modelTicket) {
                $modelStorage                     =  new Ticketstorage();
                $modelStorage->id                 = $modelTicket->id;
                $modelStorage->rifa_id            = $modelTicket->rifa_id;
                $modelStorage->ticket             = $modelTicket->ticket;
                $modelStorage->folio              = $modelTicket->folio;
                $modelStorage->date               = $modelTicket->date;
                $modelStorage->date_ini           = $modelTicket->date;
                $modelStorage->date_end           = $modelTicket->date_end;
                $modelStorage->expiration         = $modelTicket->expiration;
                $modelStorage->phone              = $modelTicket->phone;
                $modelStorage->name               = $modelTicket->name;
                $modelStorage->lastname           = $modelTicket->lastname;
                $modelStorage->state              = $modelTicket->state;
                $modelStorage->transaction_number = $modelTicket->transaction_number;
                $modelStorage->type               = $modelTicket->type;
                $modelStorage->status             = $modelTicket->status;
                $modelStorage->parent_id          = $modelTicket->parent_id;
                $modelStorage->date_payment       = $modelTicket->date_payment;
                $modelStorage->type_sale          = $modelTicket->type_sale;
                $modelStorage->save();
                
                //libera el ticket seleccionado
                $modelTicket->delete();
            }//end foreach

            $transaction->commit();

        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::error('Error en la transacción: ' . $e->getMessage());
            return false;
        }//end try
        return $this->redirect(['ticketstorage/index']);
    }


    public function actionSales(){
        die("No Allowed");
        $modelRifas = Rifas::find()->where(['status' => 1])->orderBy(['date_init' => SORT_ASC])->all();
        return $this->render('sales',[
            'modelRifas' => $modelRifas,
        ]);
    }//end function

    public static function addcero($digitos,$number){
        return str_pad($number, $digitos, "0", STR_PAD_LEFT);
    }//end function

    public static function actionCreatetickets(){
        Yii::$app->session->set('tickets_B', []);
        Yii::$app->session->set('tickets_play_all_B',[]);

        //Rifa
        $model   = Rifas::find()->where(["id" => Yii::$app->request->get("id")])->one();
        $digitos = strlen($model->ticket_end);
        $tickets = [];
        for ($i=$model->ticket_init; $i <= $model->ticket_end ; $i++) { 
            $tickets[$i] = self::addcero($digitos,$i);
        }//end foreach

        //$tickets_div = array_chunk($tickets,6500);
        
        Yii::$app->session->set('tickets_B', $tickets);
        //return $tickets_div;
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
        $tn  = Yii::$app->request->post()["tn_s"];
        $max = Yii::$app->request->post()["max"];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($tn > $max){
            return ["status"=>false];
        }//end if

        $modelT  = Tickets::find()->where(['ticket' => $tn])->one();
        //Boleto disponible
        if(is_null($modelT)){
            //Rifa
            $model   = Rifas::find()->where(["id" => Yii::$app->request->post("id")])->one();
            $tickets = Yii::$app->session->get('tickets_B');
            //El número fue previamente seleccionado
            if(!in_array($tn,$tickets)){
                return ["status"=>null];
            }//end if

            //No existen promos
            if(empty($model->promos)){
                //Tickets apartados y vendidos
                $tickets_ac = self::dumpTicketAC($model->tickets);
                array_push($tickets_ac, $tn);

                //Elimina los Tickets seleccionados del conjunto de Tickets
                foreach ($tickets_ac as $element) {
                    if (($key = array_search($element, $tickets)) !== false) {
                        unset($tickets[$key]);
                    }//end if
                }//end foreach

                $tickets_play[$tn]          = $tn;
                $dump_tickets_play_all      = Yii::$app->session->get('tickets_play_all_B');
                $dump_tickets_play_all[$tn] = $tickets_play[$tn];
                
                Yii::$app->session->set('tickets_B',$tickets);
                Yii::$app->session->set('tickets_play_all_B',$dump_tickets_play_all);

                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ["status"=>true,"promos"=>false,"tickets_play"=>Yii::$app->session->get('tickets_play_all_B')];
            }//end if


            //El número existe en los números random previamente generados
            $dump_tickets_play_all = Yii::$app->session->get('tickets_play_all_B');
            foreach ($dump_tickets_play_all as $tickets_play) {
                if(in_array($tn,$tickets_play)){
                    return ["status"=>null];
                }//end if
            }//end if


            //Tickets apartados y vendidos
            $tickets_ac = self::dumpTicketAC($model->tickets);
            array_push($tickets_ac, $tn);

            //Elimina los Tickets seleccionados del conjunto de Tickets
            foreach ($tickets_ac as $element) {
                if (($key = array_search($element, $tickets)) !== false) {
                    unset($tickets[$key]);
                }//end if
            }//end foreach

            //Obtiene un número aleatorio del conjunto de Tickets
            $total_tickets_ls = count($tickets);
            //Existe tickets para generar un aleatoreo
            if($total_tickets_ls != 0){
                if($total_tickets_ls < $model->promos[0]->get_ticket){
                    $keys_random = array_rand($tickets,$total_tickets_ls);
                }else{
                    $keys_random = array_rand($tickets,$model->promos[0]->get_ticket);
                }//end if
            }elseif($total_tickets_ls == 0){
                //Ya no existen tickets para generar aleatoreo
                $keys_random = null;
            }//end if

            if(is_array($keys_random)){
                foreach ($keys_random as $key_random) {
                    $tickets_play[$tn][] = $tickets[$key_random];
                }//end foreahc
            }else{
                if(!is_null($keys_random)){
                    $tickets_play[$tn][] = $tickets[$keys_random];
                }//end if
            }//end if

            $dump_tickets_play_all      = Yii::$app->session->get('tickets_play_all_B');
            if(is_null($keys_random)){
                $dump_tickets_play_all[$tn] = [$tn];
            }else{
                $dump_tickets_play_all[$tn] = $tickets_play[$tn];
            }//end if

            Yii::$app->session->set('tickets_B',$tickets);
            Yii::$app->session->set('tickets_play_all_B',$dump_tickets_play_all);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ["status"=>true,"promos"=>true,"tickets_play"=>Yii::$app->session->get('tickets_play_all_B')];
        }//end if

        return ["status"=>false];
    }//end function

    public function actionTicketremove(){
        $tn               = Yii::$app->request->post()["tn"];
        $tickets_play_all = Yii::$app->session->get('tickets_play_all_B');
        $tickets          = Yii::$app->session->get('tickets_B');

        array_push($tickets, $tn);
        if(is_array($tickets_play_all[$tn])){
            foreach ($tickets_play_all[$tn] as $value) {
                array_push($tickets, $value);
            }//end forechs
        }//end if

        $ticketRemove_    = $tickets_play_all[$tn];
        unset($tickets_play_all[$tn]);


        Yii::$app->session->set('tickets_B',$tickets);
        Yii::$app->session->set('tickets_play_all_B',$tickets_play_all);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        /*$ticketRemove = json_encode($ticketRemove_);*/
        return ["status"=>true,"tickets_play"=>Yii::$app->session->get('tickets_play_all_B')];
    }//end function

    public static function getTicketSelected($ticket = null){
        $model  = Tickets::find()->where(['ticket' => $ticket])->one();
        if(is_null($model)){
            return true;
        }//end if

        return false;
    }//end function

    public function actionPagar(){
        date_default_timezone_set('America/Mexico_City');

        $modelTicket = new TicketForm();
        if ($modelTicket->load(Yii::$app->request->post())) {
            $mutex = \Yii::$app->mutex;
            // Adquirir el bloqueo
            if (!$mutex->acquire('lock_apartar')) {
                // Esperar 2 segundos antes de volver a ejecutar la acción
                sleep(2);
                // Volver a ejecutar la acción
                $this->actionPagar();
            }//end if

            try{
                $rifaId            = $modelTicket->rifa_id;
                //Valida si existen tickets ya apartados o pagados
                $ticket_duplicados = [];
                $data              = [];
                $tickets_play_all  = Yii::$app->session->get('tickets_play_all_B');
                foreach ($tickets_play_all as $key__ => $tickets__) {
                    if(!self::getTicketSelected($key__)){
                        $ticket_duplicados[] = $key__;
                    }//end if

                    if(is_array($tickets__)){
                        foreach ($tickets__ as $ticket_) {
                            if(!self::getTicketSelected($ticket_)){
                                $ticket_duplicados[] = $ticket_;
                            }//end if
                        }//end foreach
                    }//end if
                }//end foreach

                //Existen tickets ya registrados por alguien más
                if(!empty($ticket_duplicados)){
                    $ticket_duplicados = implode(",", $ticket_duplicados);
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ["status"=>false,"tickets_duplicados"=>$ticket_duplicados];
                }//end if

                $resFolio = Tickets::find()->where(["rifa_id"=>$rifaId])->orderBy(["id"=>SORT_DESC])->one();
                if(is_null($resFolio)){
                    $folio = self::addcero(5,1);
                }else{
                    $folio_ = (int)$resFolio->folio+1;
                    $folio = self::addcero(5,$folio_);
                }//end if

                //No existes tickets registrados con anterioridad
                //Guarda información
                foreach ($tickets_play_all as $key__ => $tickets__) {
                    $model               = new Tickets();
                    $model->rifa_id      = $modelTicket->rifa_id;
                    $model->ticket       = (string) $key__;
                    $model->folio        = $folio;
                    $model->date         = date("Y-m-d H:i");
                    $model->date_end     = date("Y-m-d H:i");
                    $model->date_payment = date("Y-m-d H:i:s");
                    $model->phone        = $modelTicket->phone;
                    $model->name         = $modelTicket->name;
                    $model->lastname     = $modelTicket->lastname;
                    $model->state        = $modelTicket->state;
                    $model->type         = "S";
                    $model->type_sale    = "store";
                    $model->status       = "P";
                    $model->parent_id    = null;
                    $model->expiration   = "0";
                    $model->save(false);


                    if(is_array($tickets__)){
                        foreach ($tickets__ as $ticket_) {
                            $modelTR               = new Tickets();
                            $modelTR->rifa_id      = $modelTicket->rifa_id;
                            $modelTR->ticket       = (string) $ticket_;
                            $modelTR->folio        = $folio;
                            $modelTR->date         = date("Y-m-d H:i");
                            $modelTR->date_end     = date("Y-m-d H:i");
                            $modelTR->date_payment = date("Y-m-d H:i:s");
                            $modelTR->phone        = $modelTicket->phone;
                            $modelTR->name         = $modelTicket->name;
                            $modelTR->lastname     = $modelTicket->lastname;
                            $modelTR->state        = $modelTicket->state;
                            $modelTR->type         = "R";
                            $modelTR->type_sale    = "store";
                            $modelTR->status       = "P";
                            $modelTR->parent_id    = $model->id;
                            $modelTR->expiration   = "0";
                            $modelTR->save(false);
                        }//end foreach
                    }//end if
                }//end foreach

                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    "status"   => true,
                    "rifaId"   => $modelTicket->rifa_id,
                    "name"     => $modelTicket->name,
                    "lastname" => $modelTicket->lastname,
                    "phone"    => $modelTicket->phone
                ];
            }finally {
                // Liberar el mutex para que otras instancias puedan ejecutar la acción.
                $mutex->release('lock_apartar');
            }
        }//end if

        $modelRifa   = Rifas::find()->where(["id" => Yii::$app->session->get("rifaId")])->one();
        return $this->renderAjax('_apartarPopup',[
            'modelRifa'=>$modelRifa,
            'modelTicket'=>$modelTicket
        ]);
    }//end if


    public function actionSendwp(){
        $model            = Rifas::find()->where(["id" => Yii::$app->request->post()["id"]])->one();
        $tickets_play_all = Yii::$app->session->get('tickets_play_all_B');

        //Usuario
        $name     = Yii::$app->request->post()["name"];
        $lastname = Yii::$app->request->post()["lastname"];
        $phone    = Yii::$app->request->post()["phone"];

        $diassemana = Yii::$app->params["diassemana"];
        $meses      = Yii::$app->params["meses"];
        //Rifa
        $titulo_rifa  = $model->name;
        $fecha_rifa   = $diassemana[date('w',strtotime($model->date_init))]." ".date('d',strtotime($model->date_init))." de ".$meses[date('n',strtotime($model->date_init))-1]. " del ".date('Y',strtotime($model->date_init));
        $terms_rifa   = $model->terms;

        //Tickets
        $num_tickets          = count($tickets_play_all);
        $tickets_play_all_str = "";
        $h                    = 0;

        $domainFront = "https://rifaspabman.com.mx/site/boleto/";
        $uri_ticket_payment = "";
        foreach ($tickets_play_all as $key__ => $tickets__) {
            $uri_ticket_payment .= $domainFront.$model->id."?number=".$key__."

";
        }//end foreach

$custom_msg = "¡LISTO! Pago registrado con éxito, muchas gracias.

*{$name}* 
Encuentra todos tus bolestos PAGADOS aquí:

{$uri_ticket_payment}
*¡MUCHA SUERTE!*
🍀🍀
";
        

        $link = "https://wa.me/+52{$phone}/?text=".urlencode($custom_msg);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ["status"=>true,"link"=>$link];
    }//end function


    public function actionSendmsn($id){
        $modelTicket = $this->findModel($id);
        $rifaId      = $modelTicket->rifa_id;
        $folio       = $modelTicket->folio;
        $phone       = $modelTicket->phone;
        $name        = $modelTicket->name;

        $diassemana = Yii::$app->params["diassemana"];
        $meses      = Yii::$app->params["meses"];

        //Rifa
        $modelRifa   = Rifas::find()->where(["id" => $rifaId])->one();
        $titulo_rifa = $modelRifa->name;
        $fecha_rifa  = $diassemana[date('w',strtotime($modelRifa->date_init))]." ".date('d',strtotime($modelRifa->date_init))." de ".$meses[date('n',strtotime($modelRifa->date_init))-1]. " del ".date('Y',strtotime($modelRifa->date_init));
        $terms_rifa  = $modelRifa->terms;

        //Tickets
        $modelTicketsFolio = Tickets::find()->where(["rifa_id"=>$rifaId,"folio"=>$folio,"type"=>"S"])->all();

        $domainFront = "https://rifaspabman.com.mx/site/boleto/";
        $uri_ticket_payment = "";
        foreach ($modelTicketsFolio as $ticketFolio) {
            $uri_ticket_payment .= $domainFront.$rifaId."?number=".$ticketFolio->ticket."

";
        }//end foreach

$custom_msg = "¡LISTO! Pago registrado con éxito, muchas gracias.

*{$name}* 
Encuentra todos tus bolestos PAGADOS aquí:

{$uri_ticket_payment}
*¡MUCHA SUERTE!*
🍀🍀
";
    
        $link = "https://wa.me/+52{$phone}/?text=".urlencode($custom_msg);
        return $this->redirect($link);
    }//end function

    public function actionSearch(){
        $modelRifas = Rifas::find()->orderBy(['date_init' => SORT_ASC])->all();

        return $this->render('search',[
            'modelRifas' => $modelRifas,
        ]);
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
