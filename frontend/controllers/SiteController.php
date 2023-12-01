<?php

namespace frontend\controllers;

use Yii;
use backend\models\Rifas;
use backend\models\Tickets;
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

//use \aracoool\uuid\Uuid;
use yii\db\Transaction;


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
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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
        $modelRifasBanner  = Rifas::find()->where(['<>','status', 0])->andWhere(['banner'=>1])->orderBy(['date_init' => SORT_ASC])->limit(5)->all();
        $modelRifasActivas = Rifas::find()->where(['<>','status', 0])->orderBy(['date_init' => SORT_ASC])->all(); 
        return $this->render('index',[
            'rifasBanner'  =>$modelRifasBanner,
            'rifasActivas' =>$modelRifasActivas,
        ]);
    }

    public function actionPagos()
    {   
        return $this->render('metodospagos');
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
        return (string) str_pad($number, $digitos, "0", STR_PAD_LEFT);
    }//end function

    public static function createTickets($init,$end,$rifaId,$tickets_ac){
        //Obtener el componente de caché
        //Yii::$app->cache->flush();
        $cache    = Yii::$app->cache;
        $cacheKey = 'tickets_'.$init.'_'.$end;
        $tickets  = $cache->get($cacheKey);

        if($tickets === false){
            $digitos = strlen($end);
            $tickets = [];
            for ($i=$init; $i <= $end ; $i++) {
                $ticket_           = self::addcero($digitos,$i);
                $tickets[$ticket_] = $ticket_;
            }//end foreach

            $cache->set($cacheKey,$tickets);
        }//end if

        $all_tickets_clean = [];
        if(!empty($tickets_ac)){
            $all_tickets_clean = array_diff($tickets, $tickets_ac);
        }else{
            $all_tickets_clean = $tickets;
        }//end if

        return $all_tickets_clean;

        //$tickets_div = array_chunk($tickets,5000,true);
        //return ["tickets_div"=>$tickets_div,"tickets"=>$tickets];
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

    public static function chunkTickets($tickets_list){
        $tickets_div = array_chunk($tickets_list,5000,true);
        return $tickets_div;
    }//end function

    /**
     * 
     * MAINS
     * 
     * */
    public function actionRifa(){
        \Yii::$app->session->set('countClick',0);
        \Yii::$app->session->set('tickets_play_all',[]);
        \Yii::$app->session->set('tickets_list', []);
        \Yii::$app->session->set('tickets_div', []);
        /*$uuid = Yii::$app->session->get('uuid');
        if(empty($uuid)){
            Yii::$app->session->set('uuid', Uuid::v4());
        }//end if*/
        $rifaId = Yii::$app->request->get()["id"];
        $model  = Rifas::find()->where(["id" => $rifaId])->one();

        //Rifa no activas
        if(is_null($model) || $model->status != 1){
            return $this->render('rifaEnd', [
                'model'        => $model,
            ]);
        }//end if

        //Valida si existen oportunidades
        if(!empty($model->promos)){
            \Yii::$app->session->set('oportunities',$model->promos[0]->get_ticket);
        }else{
            \Yii::$app->session->set('oportunities',0);
        }//end if

        $init  = $model->ticket_init;
        $end   = $model->ticket_end;

        //Apartados o vendidos
        $tickets_ac   = self::dumpTicketAC($model->tickets);

        //Tickets List
        $tickets_list = self::createTickets($init,$end,$model->id,$tickets_ac);
        $tickets_div  = self::chunkTickets($tickets_list);

        //Paginador
        $pages = count($tickets_div);

        //Tickets Sessions 
        \Yii::$app->session->set('tickets_list', $tickets_list);
        \Yii::$app->session->set('tickets_div', $tickets_div);

        return $this->render('rifaDetail', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }//end function

    public function actionShowtickets($page,$tickets_end){
        //Todos los tickets disponibles y en memoría
        $tickets  = \Yii::$app->session->get('tickets_div');
        $page_end = count($tickets) - 1;
        
        if($page_end < 0){
            return "<div class='col-12 alert alert-warning text-center h1'>LO SENTIMOS, POR EL MOMENTO NO HAY BOLETOS DISPONIBLES. <br> <sub>Regresa en un par de horas y estar atento a la lista de despreciados.</sub></div>";
        }//end if

        return $this->renderAjax('_loadTickets',[
            //'model'      => $model,
            'tickets_list' => $tickets[$page],
            'page'         => $page,
            'page_end'     => $page_end,
            'tickets_end'  => $tickets_end
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
        self::createTickets($model->ticket_init,$model->ticket_end,$model->id,null);
        $tickets = Yii::$app->session->get('tickets');
        //$uuid    = Yii::$app->session->get('uuid');

        //$arrStorage = [];
        if(!empty($model->promos)){
            if($model->promos[0]->buy_ticket > 1){
                $return = ["status"=>"NA"];
                return json_encode($return);
            }//end if

            if(Yii::$app->session->get('countClick') == $model->promos[0]->buy_ticket){
                //Guarda ticket seleccionado en el storage
                //self::saveTicketStorage($rifaId,$tn,$uuid);
                //$arrStorage[] = $tn; 

                //Tickets apartados y vendidos
                $tickets_ac = self::dumpTicketAC($model->tickets);
                $allTickets = array_merge($elements,$tickets_ac);


                //Aquí hace otro merge con los tickets random
                if(!empty($elements_rnd)){
                    $elements_rnd = explode(",", $elements_rnd);
                    $allTickets = array_merge($allTickets,$elements_rnd);
                }//end if

                //Busca los tickets en storage
                /*$allTicketsStorage = self::getTicketStorage($rifaId,null,null);
                if(!empty($allTicketsStorage)){
                    $allTickets_ = array_merge($allTickets,$allTicketsStorage);
                    $allTickets = array_unique($allTickets_);
                }//end if*/

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
                        //self::saveTicketStorage($rifaId,$tickets[$key_random],$uuid);
                        //$arrStorage[] = $tickets[$key_random];
                        //Elimina los tickets random del conjutno de tickets
                        unset($tickets[$key_random]);
                    }//end foreahc
                }else{
                    if(!is_null($keys_random)){
                        $tickets_play[$tn][] = $tickets[$keys_random];
                        //Guarda ticket seleccionado en el storage
                        //self::saveTicketStorage($rifaId,$tickets[$keys_random],$uuid);
                        //$arrStorage[] = $tickets[$keys_random];
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

                //Guarda los tickets seleccionados en storage
                //$resStorage = self::saveTicketStorage($rifaId,$arrStorage,$uuid);
                /*if(!$resStorage){
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ["status"=>true,"duplicate"=>true];
                }//end if*/


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
            //self::saveTicketStorage($rifaId,$tn,$uuid);

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

    /*public function actionTicketremove(){
        $rifaId  = Yii::$app->request->post()["id"];
        $tn      = Yii::$app->request->post()["tn"];

        $tickets_play_all = Yii::$app->session->get('tickets_play_all');
        $ticketRemove_    = $tickets_play_all[$tn];

        unset($tickets_play_all[$tn]);
        Yii::$app->session->set('tickets_play_all',$tickets_play_all);
        $ticketRemove = json_encode($ticketRemove_);
        return $ticketRemove;
    }//end function*/

    public function actionSearchticket(){
        $id   = Yii::$app->request->post()["id"];
        $tn_s = Yii::$app->request->post()["tn_s"];
        $max  = Yii::$app->request->post()["max"];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($tn_s > $max){
            return ["status"=>false];
        }//end if

        $model  = Tickets::find()->where(['rifa_id'=>$id,'ticket' => $tn_s])->one();
        if(is_null($model)){
            return ["status"=>true];
        }//end if

        return ["status"=>false];
    }//end function

    /*public static function getTicketSelected($rifaId = null,$ticket = null){
        $model  = Tickets::find()->where(['rifa_id'=>$rifaId,'ticket' => $ticket])->one();
        if(is_null($model)){
            return true;
        }//end if

        return false;
    }//end function*/

    public static function getTicketSelected($rifaId = null,$tickets = null){
        $model  = Tickets::find()->select(['ticket'])->where(['rifa_id'=>$rifaId])->andWhere(['IN','ticket',$tickets])->all();
        //$sql = $model->createCommand()->getRawSql();
        if(empty($model)){
            return ["status"=>true];
        }//end if

        return ["status"=>false,"model"=>$model];
    }//end function


    public function actionApartar(){
        date_default_timezone_set('America/Mexico_City');
        
        //$dump_tickets_play_all = Yii::$app->session->get('tickets_play_all');
        $modelTicket = new TicketForm();
        if ($modelTicket->load(Yii::$app->request->post())) {
            if(!empty(Yii::$app->request->post()["token"])){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    "status" => false,
                    "valid"  => false,
                    "errors" => ["Lo sentimos, falló al procesar su solicitud por favor intente más tarde."]
                ];
            }//end if

            if($modelTicket->validate()){
                $mutex = \Yii::$app->mutex;
                // Adquirir el bloqueo
                if (!$mutex->acquire('lock_apartar')) {
                    // Esperar 2 segundos antes de volver a ejecutar la acción
                    sleep(2);
                    // Volver a ejecutar la acción
                    $this->actionApartar();
                    // Si no se puede adquirir el mutex, se está ejecutando otra instancia de la acción.
                    // Puede mostrar un mensaje de error o redirigir a otra página.
                    //throw new \yii\web\HttpException(503, 'La acción ya se está ejecutando en otra instancia.');
                }//end if

                try{
                    $rifaId            = $modelTicket->rifa_id;
                    $ticket_duplicados = [];
                    //$tickets_play_all  = Yii::$app->session->get('tickets_play_all');
                    $tickets_play_all  = explode(",", $modelTicket->tickets_selected);

                    //Verifica que los tickets seleccionados no estén vendidos o apartados
                    $resGetTicektSelected = self::getTicketSelected($rifaId,$tickets_play_all);
                    if(!$resGetTicektSelected["status"]){
                        //Existen tickets previamente apartados
                        foreach ($resGetTicektSelected["model"] as $key__) {
                            $ticket_duplicados[] = $key__->ticket;
                        }//end foreach
                    }//end if


                    /**
                     * 
                     * Procedimiento para tickets randoms
                     * 
                     * */
                    if(Yii::$app->session->get('oportunities') > 0){
                        //Verifica que los tickets randoms no estén vendidos o apartados
                        $tickets_play_rnd = json_decode($modelTicket->tickets_rand,true);
                        if(is_null($tickets_play_rnd)){
                            $errorMessage = json_last_error_msg(); //Json mal formado
                            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            return [
                                "status" => false,
                                "valid"  => false,
                                "errors" => $errorMessage,
                            ];
                        }//end if

                        // Convertir el arreglo multidimensional en un arreglo simple
                        $arr_base_rnd = array_reduce($tickets_play_rnd, function ($result, $item) {
                            return array_merge($result, array_values($item));
                        }, []);

                        foreach ($arr_base_rnd as $ticket_play_rnd) {
                            //Valida que no hayan filtrado más oportunidades desde front
                            $c_opt = count($ticket_play_rnd);
                            if($c_opt > \Yii::$app->session->get('oportunities')){
                                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                                return [
                                    "status"             => false,
                                    "valid"              => false,
                                    "errors" => "Valores Modificados"
                                ];
                            }//end if

                            $resGetTicektRnd = self::getTicketSelected($rifaId,$ticket_play_rnd);
                            if(!$resGetTicektRnd["status"]){
                                //Existen tickets previamente apartados
                                foreach ($resGetTicektRnd["model"] as $key__) {
                                    $ticket_duplicados[] = $key__->ticket;
                                }//end foreach
                            }//end if
                        }//end foreach
                    }//end if
                    /**************/


                    //Existen tickets ya registrados por alguien más
                    if(!empty($ticket_duplicados)){
                        $ticket_duplicados = implode(",", $ticket_duplicados);
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ["status"=>false,"valid"=>true,"tickets_duplicados"=>$ticket_duplicados];
                    }//end if


                    $resFolio   = Tickets::find()->where(["rifa_id"=>$rifaId])->orderBy(["id"=>SORT_DESC])->one();
                    $time_apart = Yii::$app->request->post()["time_apart"];

                    if(is_null($resFolio)){
                        $folio = self::addcero(5,1);
                    }else{
                        $folio_ = (int)$resFolio->folio+1;
                        $folio = self::addcero(5,$folio_);
                    }//end if

                    //No existes tickets registrados con anterioridad
                    //Guarda información
                    $connection  = \Yii::$app->db;
                    $transaction = $connection->beginTransaction();
                    try {

                        foreach ($tickets_play_all as $ticket_aparta) {
                            $model             = new Tickets();
                            $model->rifa_id    = $modelTicket->rifa_id;
                            $model->ticket     = (string) $ticket_aparta;
                            $model->folio      = $folio;
                            $model->date       = date("Y-m-d H:i");
                            $model->date_end   = date("Y-m-d H:i",strtotime ( '+'.$time_apart.' hour',strtotime (date("Y-m-d H:i"))));
                            $model->phone      = \yii\helpers\HtmlPurifier::process($modelTicket->phone);
                            $model->name       = \yii\helpers\HtmlPurifier::process($modelTicket->name);
                            $model->lastname   = \yii\helpers\HtmlPurifier::process($modelTicket->lastname);
                            $model->state      = \yii\helpers\HtmlPurifier::process($modelTicket->state);
                            $model->type       = "S";
                            $model->type_sale  = "online";
                            $model->status     = "A";
                            $model->parent_id  = null;
                            $model->expiration = "0";
                            $model->save(false);

                            /**
                             *  
                             * Procedimiento para tickets randoms
                             * 
                             * */
                            if(\Yii::$app->session->get('oportunities') > 0){
                                foreach ($tickets_play_rnd as $ticket_play_rnd) {
                                    foreach ($ticket_play_rnd as $ticket_s => $ticket_r) {
                                        if($ticket_aparta == $ticket_s){
                                            $data_insert = [];
                                            foreach ($ticket_r as $t_r) {
                                                $data_insert[] = [
                                                    'rifa_id'    => $modelTicket->rifa_id,
                                                    'ticket'     => (string) $t_r,
                                                    'folio'      => $folio,
                                                    'date'       => date("Y-m-d H:i"),
                                                    'date_end'   => date("Y-m-d H:i",strtotime ( '+'.$time_apart.' hour',strtotime (date("Y-m-d H:i")))),
                                                    'phone'      => \yii\helpers\HtmlPurifier::process($modelTicket->phone),
                                                    'name'       => \yii\helpers\HtmlPurifier::process($modelTicket->name),
                                                    'lastname'   => \yii\helpers\HtmlPurifier::process($modelTicket->lastname),
                                                    'state'      => \yii\helpers\HtmlPurifier::process($modelTicket->state),
                                                    'type'       => "R",
                                                    'type_sale'  => "online",
                                                    'status'     => "A",
                                                    'parent_id'  => $model->id,
                                                    'expiration' => "0",
                                                ];
                                            }//end foreach

                                            $columnNameArray = ['rifa_id','ticket','folio','date','date_end','phone','name','lastname','state','type','type_sale','status','parent_id','expiration'];
                                            Yii::$app->db->createCommand()->batchInsert("tickets", $columnNameArray, $data_insert)->execute();
                                        }//end if
                                    }//end forecha
                                }//end foreach
                            }//end if
                            /**************/
                        }//end foreach

                        $transaction->commit();
                    }catch(\Throwable $e){
                        $transaction->rollBack();
                    }//end try

                    // Liberar el bloqueo
                    //$this->mutex->release('lock_apartar');

                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        "status"   => true,
                        "name"     => $modelTicket->name,
                        "lastname" => $modelTicket->lastname,
                        "phone"    => $modelTicket->phone,
                        "folio"    => $folio
                    ];

                } finally {
                    // Liberar el mutex para que otras instancias puedan ejecutar la acción.
                    $mutex->release('lock_apartar');
                }
            }else{
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    "status" => false,
                    "valid"  => false,
                    "errors" => $modelTicket->getErrors()
                ];
            }//end if
        }//end if


        $modelRifa   = Rifas::find()->where(["id" => Yii::$app->request->get()["id"]])->one();
        return $this->renderAjax('_apartarPopup',[
            'modelRifa'   =>$modelRifa,
            'modelTicket' =>$modelTicket
            //'tickets'     => $tickets
        ]);
    }//end function

    public function actionSendwp(){
        $model            = Rifas::find()->where(["id" => Yii::$app->request->post()["id"]])->one();
        //$tickets_play_all = Yii::$app->session->get('tickets_play_all');

        $tickets_play_all = json_decode(Yii::$app->request->post()["json_tickets"]);

        //Usuario
        $name     = Yii::$app->request->post()["name"];
        $lastname = Yii::$app->request->post()["lastname"];
        $phone    = Yii::$app->request->post()["phone"];
        $folio    = Yii::$app->request->post()["folio"];

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

        //Totales
        /*$precioxboleto = $model->price;
        $totalpago     = ($num_tickets * $precioxboleto);
        $totalpago     = number_format($totalpago,2,'.',',');*/

        if(\Yii::$app->session->get('oportunities') > 0){
            $tickets_play_rnd = json_decode(Yii::$app->request->post()["json_tickets_rnd"],true);
            foreach ($tickets_play_rnd as $ticket_play_rnd) {
                foreach ($ticket_play_rnd as $ticket_s => $ticket_r) {
                    $tickets_play_all_str .= $ticket_s."[".implode(",",$ticket_r)."]
";
                }//end foreach
            }//end foreach
        }else{
            foreach ($tickets_play_all as $ticket__) {
                $tickets_play_all_str .= $ticket__."
";
            }//end foreach
        }//end if




        /*foreach ($tickets_play_all as $key__ => $tickets__) {
            $tickets_play_all_str .= $key__." ";
            if(is_array($tickets__)){
                $tickets_play_all_str .= "(".implode(",", $tickets__).")";
            }//end if
            $tickets_play_all_str .= "
";
        }//end foreach*/


        $custom_msg = "Hola, Aparte boletos de la rifa:
🎉*{$titulo_rifa}*
🗓️*FECHA SORTEO:* {$fecha_rifa}
------------
⚠️*FOLIO:*{$folio}⚠️
------------
🍀*{$num_tickets} - BOLETO(S):*
{$tickets_play_all_str}
------------
*NOMBRE:* {$name} {$lastname}
*CELULAR:* {$phone}
------------
↘️⬇️↙️
{$terms_rifa}
------------
*CUENTAS DE PAGO AQUÍ:* https://rifaspabman.com.mx/site/pagos
El siguiente paso es enviar foto del comprobante de pago por aquí.
*¡MUCHA SUERTE!*
DA CLICK EN ENVIAR➡️
";
        
        if(!empty($model->phone)){
            $link = "https://wa.me/+52".$model->phone."/?text=".urlencode($custom_msg);
        }else{
            $link = Yii::$app->params["social-networks"]["whatsapp"]."/?text=".urlencode($custom_msg);
        }//end if
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


    public function actionTicketsrandom(){
        $tn                 = Yii::$app->request->post()["tn"]; //Ticket seleccionado
        $tickets_list       = \Yii::$app->session->get('tickets_list');
        /*echo "<pre>";
        var_dump(count($tickets_list));
        echo "</pre>";*/

        unset($tickets_list[$tn]);
        \Yii::$app->session->set('tickets_list',$tickets_list);
        $tickets_list_clean = \Yii::$app->session->get('tickets_list'); //Lista de tickets para obtener randoms

        //Número de oportunidades por boleto seleccionado
        $oportunidades =  \Yii::$app->session->get('oportunities');


        //Obtiene un número aleatorio del conjunto de Tickets
        $total_tickets_ls = count($tickets_list_clean);
        //Existe tickets para generar un aleatoreo
        if($total_tickets_ls > 0){
            if($total_tickets_ls < $oportunidades){
                $keys_random = array_rand($tickets_list_clean,$total_tickets_ls);
            }else{
                $keys_random = array_rand($tickets_list_clean,$oportunidades);
            }//end if
        }elseif($total_tickets_ls == 0){
            //Ya no existen tickets para generar aleatoreo
            $keys_random = null;
        }//end if

        /*echo "<pre>";
        var_dump(count($tickets_list_clean));
        echo "</pre>";*/

        if(is_array($keys_random)){
            foreach ($keys_random as $key_random) {
                $tickets_play[$tn][] = $tickets_list_clean[$key_random];
                //Elimina los tickets random del conjutno de tickets
                unset($tickets_list_clean[$key_random]);
            }//end foreahc
        }else{
            if(!is_null($keys_random)){
                $tickets_play[$tn][] = $tickets_list_clean[$keys_random];
                //Elimina los tickets random del conjutno de tickets
                unset($tickets_list_clean[$keys_random]);
            }//end if
        }//end if

        \Yii::$app->session->set('tickets_list',$tickets_list_clean);

        if(is_null($keys_random)){
            $tickets_play[$tn][] = $tn;
        }//end if

        //Aquí retorna los randoms en formato json
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ["status"=>true,"tickets_play_ls"=>$tickets_play];
    }//end function

    public function actionTicketremove(){
        $tn = Yii::$app->request->post()["tn"];
        $tr = Yii::$app->request->post()["tr"];
        /*if(isset(Yii::$app->request->post()["tr"])){
        }else{
            $tr = null;
        }//end if*/

        $tickets_list = \Yii::$app->session->get('tickets_list');
        //Agregar Seleccionado
        $tickets_list[(string) $tn] = (string) $tn;

        //Agrega Randoms
        foreach ($tr as $r) {
            $tickets_list[(string) $r] = (string)$r;
        }//end foreach

        \Yii::$app->session->set('tickets_list',$tickets_list);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ["status"=>true];
    }//end function

}
