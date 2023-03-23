<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

//Backend
use backend\models\Rifas;
use backend\models\Tickets;

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
        $modelRifas = Rifas::find()->where(['status' => 1])->all();
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

    public static function addcero($digitos,$number){
        return str_pad($number, $digitos, "0", STR_PAD_LEFT);
    }//end function

    public static function createTickets($init,$end){
        $digitos = strlen($end);
        $tickets = [];
        for ($i=$init; $i <= $end ; $i++) { 
            $tickets[$i] = self::addcero($digitos,$i);
        }//end foreach

        Yii::$app->session->set('tickets', $tickets);
        return $tickets;
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

    public function actionRifa(){
        Yii::$app->session->set('countClick',0);
        Yii::$app->session->set('tickets_play_all',[]);
        Yii::$app->session->set('tickets', []);
        $rifaId = Yii::$app->request->get()["id"];
        $model  = Rifas::find()->where(["id" => $rifaId])->one();

        $promos_ = !empty($model->promos) ? 1 : 0;
        // $init    = $model->ticket_init;
        // $end     = $model->ticket_end;
        //$tickets = self::createTickets($init,$end);

        //Tickets apartados y vendidos
        $tickets_ac = self::dumpTicketAC($model->tickets);

        //Ticket Range
        $ciclos      = round($model->ticket_end / 10000);
        $all_tickets = [];
        $init        = $model->ticket_init;
        //$end         = $model->ticket_end;
        for ($i=1; $i <= $ciclos ; $i++) { 
            $all_tickets[$i] = self::createTickets($init,$end);
            //if($i == )
            /*for ($j=$count; $j <= 10000; $j++) { 
                $all_tickets[$i][$j] = ;
                $count++;
            }//end for*/
        }//end for

        echo "<pre>";
        var_dump($tickets);
        echo "</pre>";
        die();


        return $this->render('rifaDetail', [
            'model'      => $model,
            'tickets'    => $tickets,
            'tickets_ac' => $tickets_ac,
            'promos_'    => (int) $promos_
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

        $tickets = Yii::$app->session->get('tickets');
        $model   = Rifas::find()->where(["id" => $rifaId])->one();

        if(!empty($model->promos)){
            if($model->promos[0]->buy_ticket > 1){
                $return = ["status"=>"NA"];
                return json_encode($return);
            }//end if

            if(Yii::$app->session->get('countClick') == $model->promos[0]->buy_ticket){
                //Tickets apartados y vendidos
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

                //Obtiene un número aleatorio del conjunto de Tickets
                $keys_random = array_rand($tickets,$model->promos[0]->get_ticket);
                if(is_array($keys_random)){
                    foreach ($keys_random as $key_random) {
                        $tickets_play[$tn][] = $tickets[$key_random];
                    }//end foreahc
                }else{
                    $tickets_play[$tn][] = $tickets[$keys_random];
                }//end if



                $dump_tickets_play_all      = Yii::$app->session->get('tickets_play_all');
                $dump_tickets_play_all[$tn] = $tickets_play[$tn];
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
            //Tickets apartados y vendidos
            $tickets_ac        = self::dumpTicketAC($model->tickets);
            $allTickets        = array_merge($elements,$tickets_ac);

            //Elimina los Tickets seleccionados del conjunto de Tickets
            foreach ($allTickets as $element) {
                if (($key = array_search($element, $tickets)) !== false) {
                    unset($tickets[$key]);
                }//end if
            }//end foreach

            $tickets_play[$tn]                = $tn;
            $dump_tickets_play_all            = Yii::$app->session->get('tickets_play_all');
            $dump_tickets_play_all[$tn] = $tickets_play[$tn];
            
            Yii::$app->session->set('ticket',$tickets);
            Yii::$app->session->set('tickets_play_all',$dump_tickets_play_all);
            //$json_tickets_play = json_encode(Yii::$app->session->get('tickets_play_all'));
            $return            = ["status"=>false,"tickets_play"=>Yii::$app->session->get('tickets_play_all')];
            return json_encode($return);
        }//end if
    }//end function

    public function actionTicketremove(){
        $tn               = Yii::$app->request->post()["tn"];
        $tickets_play_all = Yii::$app->session->get('tickets_play_all');
        $ticketRemove_    = $tickets_play_all[$tn];
        unset($tickets_play_all[$tn]);
        Yii::$app->session->set('tickets_play_all',$tickets_play_all);
        $ticketRemove = json_encode($ticketRemove_);
        return $ticketRemove;
    }//end function

    public function actionSearchticket(){
        $ticket_s = Yii::$app->request->post()["ticket_serarch"];
        $model    = Tickets::find()->where(['ticket' => $ticket_s])->one();

        
        echo "<pre>";
        var_dump($model);
        echo "</pre>";
        die();
    }//end function



    public function actionApartar(){
        $rifaId = Yii::$app->request->get()["id"];
        return $this->renderAjax('_apartarPopup');
    }//end function
}
