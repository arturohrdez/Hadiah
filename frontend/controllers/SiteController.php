<?php

namespace frontend\controllers;

use Yii;
use backend\models\Rifas;
use backend\models\Tickets;
use backend\models\Ticketstorage;
use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\TicketForm;
use frontend\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;


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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {   
        $modelRifas = Rifas::find()->where(['status' => 1])->orderBy(['date_init' => SORT_ASC])->limit(5)->all();
        return $this->render('index',['rifas'=>$modelRifas]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * 
     * HELPERS
     * 
     * */
    public static function addcero($digitos,$number){
        return str_pad($number, $digitos, "0", STR_PAD_LEFT);
    }//end function

    public static function createTickets($init,$end){
        $digitos = strlen($end);
        $tickets = [];
        for ($i=$init; $i <= $end ; $i++) { 
            $tickets[$i] = self::addcero($digitos,$i);
        }//end foreach

        $tickets_div = array_chunk($tickets,6500);
        //$tickets_div = array_chunk($tickets,5);
        
        Yii::$app->session->set('tickets', $tickets);
        return $tickets_div;
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

    public static function saveTicketStorage($rifaId = null,$tn = null){
        //$lock = Yii::$app->db->createCommand('LOCK TABLES `ticketstorage` WRITE');
        
        $modelTS           = new Ticketstorage();
        $modelTS->rifa_id  = $rifaId;
        $modelTS->ticket   = $tn;
        $modelTS->date_ini = date("Y-m-d H:i:s");
        $modelTS->date_end = date("Y-m-d H:i:s",strtotime(Yii::$app->params['ticketstorage'],strtotime(date("Y-m-d H:i:s"))));
        $modelTS->uuid     = NULL;
        $modelTS->save();

        //$unlock = Yii::$app->db->createCommand('UNLOCK TABLES');
    }//end function

    public static function removeTicketStorage($rifaId = null, $tn = null){
        $modelTS = Ticketstorage::find()->where(["rifa_id" => $rifaId,"ticket"=>$tn])->one()->delete();
    }//end if

    public static function getTicketStorage($rifaId = null,$type = null,$tn = null){
        if(is_null($type)){
            $TicketsStorage = [];
            $modelTS = Ticketstorage::find()->where(["rifa_id" => $rifaId])->all();
            if(!empty($modelTS)){
                foreach ($modelTS as $ticket) {
                    $TicketsStorage[] = $ticket->ticket;
                }//end foreach
            }//end if
            return $TicketsStorage;
        }elseif($type == 2){
            $modelTS = Ticketstorage::find()->where(["rifa_id" => $rifaId,"ticket"=>$tn])->count();
            if(!empty($modelTS)){
                return ["status"=>false,"rows"=>$modelTS];
            }else{
                return ["status"=>true];
            }//end if
        }//end if
    }//end if

    /**
     * 
     * MAINS
     * 
     * */
    public function actionRifa(){
        Yii::$app->session->set('countClick',0);
        Yii::$app->session->set('tickets_play_all',[]);
        Yii::$app->session->set('tickets', []);
        $rifaId = Yii::$app->request->get()["id"];
        $model  = Rifas::find()->where(["id" => $rifaId])->one();

        //Rifa no activas
        if(is_null($model) || !$model->status){
            return $this->render('rifaEnd', [
                'model'        => $model,
            ]);
        }//end if


        //$promos_ = !empty($model->promos) ? 1 : 0;
        $init    = $model->ticket_init;
        $end     = $model->ticket_end;
        //$tickets_list = self::createTickets($init,$end);

        //Tickets apartados y vendidos
        //$tickets_ac = self::dumpTicketAC($model->tickets);

        return $this->render('rifaDetail', [
            'model'        => $model,
            //'tickets_list' => $tickets_list,
            //'tickets_ac'   => $tickets_ac
        ]);
    }//end function

    public function actionLoadtickets(){
        $model = Rifas::find()->where(["id" => Yii::$app->request->post()["id"]])->one();
        $init  = $model->ticket_init;
        $end   = $model->ticket_end;
        //Tickets List
        $tickets_list = self::createTickets($init,$end);
        //Tickets apartados y vendidos
        $tickets_ac   = self::dumpTicketAC($model->tickets);
        //Tickets Storage
        $tickets_st   = self::getTicketStorage(Yii::$app->request->post()["id"],null,null);

        return $this->renderAjax('_loadTickets',[
            'model'        => $model,
            'tickets_list' => $tickets_list,
            'tickets_ac'   => $tickets_ac,
            'tickets_st'   => $tickets_st,

        ]);
    }//end function

    public function actionPromos(){
        //Count Clicks
        Yii::$app->session->set('countClick',Yii::$app->session->get('countClick')+1);
        $post         = Yii::$app->request->post();
        $rifaId       = $post["id"];
        $elements     = $post["tickets"];
        $elements_rnd = $post["tickets_rnd"];
        $tn           = $post["tn"];

        $model   = Rifas::find()->where(["id" => $rifaId])->one();
        self::createTickets($model->ticket_init,$model->ticket_end);
        $tickets = Yii::$app->session->get('tickets');

        if(!empty($model->promos)){
            if($model->promos[0]->buy_ticket > 1){
                $return = ["status"=>"NA"];
                return json_encode($return);
            }//end if

            if(Yii::$app->session->get('countClick') == $model->promos[0]->buy_ticket){
                //Guarda ticket seleccionado en el storage
                self::saveTicketStorage($rifaId,$tn);

                //Tickets apartados y vendidos
                $tickets_ac = self::dumpTicketAC($model->tickets);
                $allTickets = array_merge($elements,$tickets_ac);


                //Aquí hace otro merge con los tickets random
                if(!empty($elements_rnd)){
                    $elements_rnd = explode(",", $elements_rnd);
                    $allTickets = array_merge($allTickets,$elements_rnd);
                }//end if

                //Busca los tickets en storage
                $allTicketsStorage = self::getTicketStorage($rifaId,null,null);
                if(!empty($allTicketsStorage)){
                    $allTickets_ = array_merge($allTickets,$allTicketsStorage);
                    $allTickets = array_unique($allTickets_);
                }//end if

                //Elimina los Tickets seleccionados del conjunto de Tickets
                foreach ($allTickets as $element) {
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
                        //Guarda ticket seleccionado en el storage
                        self::saveTicketStorage($rifaId,$tickets[$key_random]);
                        //Elimina los tickets random del conjutno de tickets
                        unset($tickets[$key_random]);
                    }//end foreahc
                }else{
                    if(!is_null($keys_random)){
                        $tickets_play[$tn][] = $tickets[$keys_random];
                        //Guarda ticket seleccionado en el storage
                        self::saveTicketStorage($rifaId,$tickets[$keys_random]);
                        //Elimina los tickets random del conjutno de tickets
                        unset($tickets[$keys_random]);
                    }//end if
                }//end if

                $dump_tickets_play_all      = Yii::$app->session->get('tickets_play_all');
                if(is_null($keys_random)){
                    $dump_tickets_play_all[$tn] = [$tn];
                }else{
                    $dump_tickets_play_all[$tn] = $tickets_play[$tn];
                }//end if

                Yii::$app->session->set('tickets',$tickets);
                Yii::$app->session->set('tickets_play_all',$dump_tickets_play_all);
                Yii::$app->session->set('countClick',0);
                //$json_tickets_play = Yii::$app->session->get('tickets_play_all');
                $return            = ["status"=>true,"tickets_play"=>Yii::$app->session->get('tickets_play_all')];
                return json_encode($return);
            }else{
                $return = ["status"=>"NA"];
                return json_encode($return);

                /*//Tickets apartados y vendidos
                $tickets_ac = self::dumpTicketAC($model->tickets);
                $allTickets = array_merge($elements,$tickets_ac);


                //Aquí hace otro merge con los tickets random
                if(!empty($elements_rnd)){
                    $elements_rnd = explode(",", $elements_rnd);
                    $allTickets = array_merge($allTickets,$elements_rnd);
                }//end if

                //Elimina los Tickets seleccionados del conjunto de Tickets
                foreach ($allTickets as $element) {
                    if (($key = array_search($element, $tickets)) !== false) {
                        unset($tickets[$key]);
                    }//end if
                }//end foreach

                $tickets_play[$tn]          = $tn;
                $dump_tickets_play_all      = Yii::$app->session->get('tickets_play_all');
                $dump_tickets_play_all[$tn] = $tickets_play[$tn];
                Yii::$app->session->set('tickets_play_all',$dump_tickets_play_all);
                //$json_tickets_play = json_encode(Yii::$app->session->get('tickets_play_all'));
                $return            = ["status"=>false,"tickets_play"=>Yii::$app->session->get('tickets_play_all')];
                return json_encode($return);*/
            }//end if
        }else{
            //No existe promo
            //Guarda ticket seleccionado en el storage
            self::saveTicketStorage($rifaId,$tn);

            //Tickets apartados y vendidos
            $tickets_ac        = self::dumpTicketAC($model->tickets);
            $allTickets        = array_merge($elements,$tickets_ac);

            //Elimina los Tickets seleccionados del conjunto de Tickets
            foreach ($allTickets as $element) {
                if (($key = array_search($element, $tickets)) !== false) {
                    unset($tickets[$key]);
                }//end if
            }//end foreach

            $tickets_play[$tn]          = $tn;
            $dump_tickets_play_all      = Yii::$app->session->get('tickets_play_all');
            $dump_tickets_play_all[$tn] = $tickets_play[$tn];
            
            Yii::$app->session->set('tickets',$tickets);
            Yii::$app->session->set('tickets_play_all',$dump_tickets_play_all);
            //$json_tickets_play = json_encode(Yii::$app->session->get('tickets_play_all'));
            $return            = ["status"=>false,"tickets_play"=>Yii::$app->session->get('tickets_play_all')];
            return json_encode($return);
        }//end if
    }//end function

    public function actionTicketremove(){
        $rifaId  = Yii::$app->request->post()["id"];
        $tn      = Yii::$app->request->post()["tn"];
        self::removeTicketStorage($rifaId,$tn);


        $tickets_play_all = Yii::$app->session->get('tickets_play_all');
        $ticketRemove_    = $tickets_play_all[$tn];
        if(is_array($ticketRemove_)){
            foreach ($ticketRemove_ as $tnr) {
                self::removeTicketStorage($rifaId,$tnr);
            }//end foreach
        }//end if


        unset($tickets_play_all[$tn]);
        Yii::$app->session->set('tickets_play_all',$tickets_play_all);
        $ticketRemove = json_encode($ticketRemove_);
        return $ticketRemove;
    }//end function

    public function actionSearchticket(){
        $tn_s = Yii::$app->request->post()["tn_s"];
        $max  = Yii::$app->request->post()["max"];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($tn_s > $max){
            return ["status"=>false];
        }//end if

        $model  = Tickets::find()->where(['ticket' => $tn_s])->one();
        if(is_null($model)){
            return ["status"=>true];
        }//end if

        return ["status"=>false];
    }//end function

    public static function getTicketSelected($rifaId = null,$ticket = null){
        $model  = Tickets::find()->where(['rifa_id'=>$rifaId,'ticket' => $ticket])->one();
        if(is_null($model)){
            return true;
        }//end if

        return false;
    }//end function

    public function actionApartar(){
        //$dump_tickets_play_all = Yii::$app->session->get('tickets_play_all');
        $modelTicket = new TicketForm();
        if ($modelTicket->load(Yii::$app->request->post())) {
            $rifaId            = $modelTicket->rifa_id;
            $ticket_duplicados = [];
            $tickets_play_all  = Yii::$app->session->get('tickets_play_all');
            
            //Valida cada ticket vs Apartados o vendidos
            foreach ($tickets_play_all as $key__ => $tickets__) {
                //Valida cada ticket vs ticketstorage
                //Parea evitar la concurrencia, no se pueden guardar duplicados
                $ticketstorageS = self::getTicketStorage($rifaId,2,$key__);
                //Existe más de un registro en storage
                if(!$ticketstorageS["status"] && $ticketstorageS["rows"] > 1){
                    //Concurrencia
                    $ticket_duplicados[] = $key__;
                }//end if

                if(!self::getTicketSelected($rifaId,$key__)){
                    $ticket_duplicados[] = $key__;
                }//end if

                if(is_array($tickets__)){
                    foreach ($tickets__ as $ticket_) {
                        $ticketstorageR = self::getTicketStorage($rifaId,2,$ticket_);
                        if(!$ticketstorageR["status"] && $ticketstorageR["rows"] > 1){
                            //Concurrencia
                            $ticket_duplicados[] = $ticket_;
                        }//end if

                        if(!self::getTicketSelected($rifaId,$ticket_)){
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


            //No existes tickets registrados con anterioridad
            //Guarda información
            foreach ($tickets_play_all as $key__ => $tickets__) {
                $model            = new Tickets();
                $model->rifa_id   = $modelTicket->rifa_id;
                $model->ticket    = (string) $key__;
                $model->date      = date("Y-m-d H:i");
                $model->date_end  = date("Y-m-d H:i",strtotime ( '+24 hour',strtotime (date("Y-m-d H:i"))));
                $model->phone     = $modelTicket->phone;
                $model->name      = $modelTicket->name;
                $model->lastname  = $modelTicket->lastname;
                $model->state     = $modelTicket->state;
                $model->type      = "S";
                $model->status    = "A";
                $model->parent_id = null;
                $model->save();
                //Vacía storage
                self::removeTicketStorage($rifaId,$key__);

                if(is_array($tickets__)){
                    foreach ($tickets__ as $ticket_) {
                        $modelTR            = new Tickets();
                        $modelTR->rifa_id   = $modelTicket->rifa_id;
                        $modelTR->ticket    = (string) $ticket_;
                        $modelTR->date      = date("Y-m-d H:i");
                        $modelTR->date_end  = date("Y-m-d H:i",strtotime ( '+24 hour',strtotime (date("Y-m-d H:i"))));
                        $modelTR->phone     = $modelTicket->phone;
                        $modelTR->name      = $modelTicket->name;
                        $modelTR->lastname  = $modelTicket->lastname;
                        $modelTR->state     = $modelTicket->state;
                        $modelTR->type      = "R";
                        $modelTR->status    = "A";
                        $modelTR->parent_id = $model->id;
                        $modelTR->save();

                        //Vacía storage
                        self::removeTicketStorage($rifaId,$ticket_);
                    }//end foreach
                }//end if
            }//end foreach

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                "status"   => true,
                "name"     => $modelTicket->name,
                "lastname" => $modelTicket->lastname,
                "phone"    => $modelTicket->phone
            ];
        }//end if

        $modelRifa   = Rifas::find()->where(["id" => Yii::$app->request->get()["id"]])->one();
        return $this->renderAjax('_apartarPopup',[
            'modelRifa'=>$modelRifa,
            'modelTicket'=>$modelTicket
        ]);
    }//end function

    public function actionSendwp(){
        $model            = Rifas::find()->where(["id" => Yii::$app->request->post()["id"]])->one();
        $tickets_play_all = Yii::$app->session->get('tickets_play_all');

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
        foreach ($tickets_play_all as $key__ => $tickets__) {
            $tickets_play_all_str .= $key__." ";
            if(is_array($tickets__)){
                $tickets_play_all_str .= "(".implode(",", $tickets__).")";
            }//end if
            $tickets_play_all_str .= "
";
        }//end foreach


        $custom_msg = "Hola, Aparte boletos de la rifa:
🎉*{$titulo_rifa}*
🗓️*FECHA SORTEO:* {$fecha_rifa} 
------------
🍀*{$num_tickets} - BOLETO(S):*
{$tickets_play_all_str}
------------
*NOMBRE :* {$name} {$lastname}
*CELULAR:* {$phone}
------------
↘️⬇️↙️
{$terms_rifa}
------------
El siguiente paso es enviar foto del comprobante de pago por aquí.
DA CLICK EN ENVIAR➡️
*¡MUCHA SUERTE!*
";

        $link = Yii::$app->params["social-networks"]["whatsapp"]."/?text=".urlencode($custom_msg);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ["status"=>true,"link"=>$link];
    }//end function

    public function actionBoleto(){
        $rifaId = Yii::$app->request->get()["id"];
        if(isset(Yii::$app->request->get()["number"])){
            $ticket = Yii::$app->request->get()["number"];
        }else{
            die("Número de Boleto es requerido");
        }//end if


        $model  = Rifas::find()->where(["id" => $rifaId])->one();
        //Rifa no activas
        if(is_null($model) || !$model->status){
            return $this->render('rifaEnd', [
                'model'        => $model,
            ]);
        }//end if

        //Busca boleto (Oportunidades)
        $modelTicket = Tickets::find()->where(['rifa_id'=>$model->id,'ticket' => $ticket])->one();
        if(is_null($modelTicket)){
            return $this->render('rifaTickets', [
                'model'  => $model,
                'ticket' => $ticket,
                'status' => false,
            ]);
        }//end if

        //Busca si tiene oportunidades
        $modelOportunidades = Tickets::find()->where(['rifa_id'=>$model->id,'parent_id' => $modelTicket->id])->all();


        return $this->render('rifaTickets', [
            'model'         => $model,
            'modelTicket'   => $modelTicket,
            'oportunidades' => $modelOportunidades, 
            'status'        => true
        ]);
    }//end function

    public function actionValidstorageticket(){
        $rifaId = Yii::$app->request->post()["id"];
        $tn     = Yii::$app->request->post()["tn"];

        $modelTS = Ticketstorage::find()->where(["rifa_id" => $rifaId,"ticket"=>$tn])->count();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //Existe registros en el storage
        if($modelTS > 0){
            return ["status"=>false];
        }
        // No existe registro en el storaga
        return ["status"=>true];
    }//end function

}
