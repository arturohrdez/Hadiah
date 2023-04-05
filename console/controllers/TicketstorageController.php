<?php

namespace console\controllers;

use backend\models\Ticketstorage;
use yii\console\Controller;

/**
 * Test controller
 */
class TicketstorageController extends Controller {

    public function actionIndex() {
        //Verificación de los tickets no pagados
        //Se toma la fecha de expiración 
        $date = date("Y-m-d H:i");
        $modelTicketstorage = Ticketstorage::find()->where(["<=","date_end",$date])->all();
        if(!empty($modelTicketstorage)){
            foreach ($modelTicketstorage as $ticketstorage) {
                $ticketstorage->delete();
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