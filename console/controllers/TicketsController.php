<?php

namespace console\controllers;

use backend\models\Tickets;
use yii\console\Controller;

/**
 * Test controller
 */
class TicketsController extends Controller {

    public function actionIndex() {
        //Verificación de los tickets no pagados
        //Se toma la fecha de expiración 
        date_default_timezone_set('America/Mexico_City');
        $date = date("Y-m-d H:i");
        $modelTickets = Tickets::find()->where(["<=","date_end",$date])->andWhere(["status"=>"A",'expiration'=>0])->all();
        if(!empty($modelTickets)){
            foreach ($modelTickets as $ticket) {
                $ticket->expiration = 1;
                $ticket->save(false);
            }//end foreach

            die("Proceso terminado");
        }else{
            die("Sin información para procesar");
        }//end if
    }//end functio

    /*public function actionMail($to) {
        echo "Sending mail to " . $to;
    }*/

}