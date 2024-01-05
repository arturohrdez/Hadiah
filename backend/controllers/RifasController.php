<?php

namespace backend\controllers;

use backend\models\Boletera;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use backend\models\Ganadores;
use backend\models\Promos;
use backend\models\Rifas;
use backend\models\RifasSearch;
use backend\models\Tickets;
use backend\models\Ticketstorage;
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
                'class'=> AccessControl::class,
                'only' => ['index','create','update','delete','view','export'],
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
    }//end function

    public function actionSearchticket(){
        $rifa_id = Yii::$app->request->post()["id"];
        $tn_s    = Yii::$app->request->post()["tn_s"];

        $modelT  = Tickets::find()->where(['ticket' => $tn_s])->andWhere(["rifa_id"=>$rifa_id])->one();
        return $this->renderAjax('_searchticket', [
            'modelT' => $modelT,
            'ticket' => $tn_s
        ]);
    }//end function


    /**
     * 
     * HELPERS
     * 
     * */
    public static function addcero($digitos,$number){
        return (string) str_pad($number, $digitos, "0", STR_PAD_LEFT);
    }//end function

    public static function createTemplate($init,$end){
        $digitos = strlen($end);
        $html_template = "";
        for ($i=$init; $i <= $end ; $i++) {
            $ticket           = self::addcero($digitos,$i);
            $html_template .= '<div class="col-lg-1 col-sm-2 col-3"><a id="tn_'.$ticket.'" class="mb-3 btn btn-outline-light btn_ticket" data-tn="'.$ticket.'">'.$ticket.'</a></div>';
        }//end foreach

        return $html_template;
    }//end function

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
            //Crea template para la boletera
            $html_tamplate = self::createTEmplate($model->ticket_init,$model->ticket_end);

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

            #--Boletera
            $modelBoletera = new Boletera();
            $modelBoletera->rifa_id = $model->id;
            $modelBoletera->template = $html_tamplate;
            $modelBoletera->save();
            

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
            //Crea template para la boletera
            $html_tamplate = self::createTEmplate($model->ticket_init,$model->ticket_end);

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

            #--Boletera
            $modelBoletera = new Boletera();
            $modelBoletera->rifa_id = $model->id;
            $modelBoletera->template = $html_tamplate;
            $modelBoletera->save();

            Yii::$app->session->setFlash('success', "Se actualizo correctamente la Rifa :  <strong>".$model->name."</strong>");
            return $this->redirect(['index']);
        }//end if


        return $this->renderAjax('update', [
            'model' => $model,
            'modelPromos' => $modelPromos
        ]);
    }


    public function actionGanadores($id){
        $modelRifa  = Rifas::findOne($id);
        $modelGanadores = new Ganadores();

        $modelGanadores->rifa_id = $modelRifa->id;
        $modelTickets     = Tickets::find()->joinWith(['rifa'])
                                ->where(['<>','rifas.status',0])
                                ->andWhere(['rifas.id'=>$id])
                                ->andWhere(['tickets.status'=>'P'])
                                ->orderBy('tickets.ticket ASC')
                                ->all();

        return $this->render('ganadores', [
            'modelRifa'      => $modelRifa,
            'modelGanadores' => $modelGanadores,
            'modelTickets'   => $modelTickets,
        ]);
    }//end function

    /*public function actionWinners($id){
        $modelRifa  = Rifas::findOne($id);
        //$presorteos = $modelRifa->presorteos;
        // if($presorteos > 0){
        //     $ganadorDetail = Ganadores::find()->where(['rifa_id'=>$id])->all();
        // }else{
        //     $ganadorDetail = Ganadores::find()->where(['rifa_id'=>$id,'type'=>'PM'])->one();
        // }//end if

        $ganadorPM = Ganadores::find()->where(['rifa_id'=>$id,'type'=>'PM'])->one();
        if(!empty($ganadorPM)){
            return $this->renderAjax('_ganadoresView', [
                'modelGanadorPM'    => $ganadorPM,
            ]);
        }//end if
        $modelPM    = new Ganadores();
        if ($modelPM->load(Yii::$app->request->post()) && $modelPM->validate()) {
            $modelPM->type = "PM";
            $modelPM->save();

            $modelRifa->status = "0";
            $modelRifa->save(false);

            // echo "<pre>";
            // var_dump($modelPM->attributes);
            // echo "</pre>";
            // die();


            Yii::$app->session->setFlash('success', "Se guardao registro de ganador para la Rifa :  <strong>".$modelRifa->name."</strong>");
            return $this->redirect(['index']);
        }//end if
                
        $modelPM->rifa_id = $modelRifa->id;
        $modelTickets     = Tickets::find()->joinWith(['rifa'])
                                ->where(['<>','rifas.status',0])
                                ->andWhere(['rifas.id'=>$id])
                                ->andWhere(['tickets.status'=>'P'])
                                ->orderBy('tickets.ticket ASC')
                                ->all();

        return $this->renderAjax('winners', [
            'modelRifa'    => $modelRifa,
            'modelPM'      => $modelPM,
            'modelTickets' => $modelTickets,
        ]);
    }//end function*/

    public function actionTicketdetail($id){
        $modelTicket = Tickets::findOne($id);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            "ticket"             =>$modelTicket->ticket,
            "folio"              =>$modelTicket->folio,
            "phone"              =>$modelTicket->phone,
            "name"               =>$modelTicket->name,
            "lastname"           =>$modelTicket->lastname,
            "state"              =>$modelTicket->state,
            "transaction_number" =>$modelTicket->transaction_number,
            "date_payment"       =>$modelTicket->date_payment
        ];
    }//end function

    // Función para procesar un lote de datos y agregarlos al archivo Excel
    private function procesarLote($sheet, $data, $modelRifa ,$startRow){
        foreach ($data as $index => $record) {
            $estatus_ = ($record->status == "P") ? "PAGADO" : "APARTADO";
            $sheet->setCellValue('A'. ($startRow + $index), $modelRifa->name);
            $sheet->setCellValue('B'. ($startRow + $index), $record->ticket);
            $sheet->setCellValue('C'. ($startRow + $index), $record->folio);
            $sheet->setCellValue('D'. ($startRow + $index), $record->name);
            $sheet->setCellValue('E'. ($startRow + $index), $record->lastname);
            $sheet->setCellValue('F'. ($startRow + $index), $record->phone);
            $sheet->setCellValue('G'. ($startRow + $index), $record->state);
            $sheet->setCellValue('H'. ($startRow + $index), $record->date);
            $sheet->setCellValue('I'. ($startRow + $index), $record->date_payment);
            $sheet->setCellValue('J'. ($startRow + $index), $estatus_);

            $columnas = ['A','B','C','D','E','F','G','H','I','J'];
            foreach ($columnas as $columna) {
                $sheet->getColumnDimension($columna)->setAutoSize(true);
            }
            //$sheet->getColumnDimension('A:J')->setAutoSize(true);
            // Configurar la alineación central en la celda
            $sheet->getStyle("A".($startRow + $index).":J".($startRow + $index))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
    }//end function

    private function procesarLoteVencidos($sheet, $data, $modelRifa ,$startRow){
        foreach ($data as $index => $record) {
            $estatus_ = ($record->status == "P") ? "PAGADO" : "APARTADO";
            $sheet->setCellValue('A'. ($startRow + $index), $modelRifa->name);
            $sheet->setCellValue('B'. ($startRow + $index), $record->ticket);
            $sheet->setCellValue('C'. ($startRow + $index), $record->folio);
            $sheet->setCellValue('D'. ($startRow + $index), $record->name);
            $sheet->setCellValue('E'. ($startRow + $index), $record->lastname);
            $sheet->setCellValue('F'. ($startRow + $index), $record->phone);
            $sheet->setCellValue('G'. ($startRow + $index), $record->state);
            $sheet->setCellValue('H'. ($startRow + $index), $record->date);
            $sheet->setCellValue('I'. ($startRow + $index), $record->date_end);
            $sheet->setCellValue('J'. ($startRow + $index), $estatus_);

            $columnas = ['A','B','C','D','E','F','G','H','I','J'];
            foreach ($columnas as $columna) {
                $sheet->getColumnDimension($columna)->setAutoSize(true);
            }
            //$sheet->getColumnDimension('A:J')->setAutoSize(true);
            // Configurar la alineación central en la celda
            $sheet->getStyle("A".($startRow + $index).":J".($startRow + $index))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
    }//end function

    public function actionReporteactivos($id){
        $modelRifa = Rifas::findOne($id);
        // Crear una instancia de PhpSpreadsheet
        $spreadsheet = new Spreadsheet();

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => '45CA8D',
                ],
            ],
        ];
        // Seleccionar la hoja activa
        $sheet = $spreadsheet->getActiveSheet();
        // Agregar datos y estilo a las cabeceras
        $sheet->setCellValue('A1', 'RIFA');
        $sheet->setCellValue('B1', 'TICKET');
        $sheet->setCellValue('C1', 'FOLIO');
        $sheet->setCellValue('D1', 'NOMBRE(S)');
        $sheet->setCellValue('E1', 'APELLIDO(S)');
        $sheet->setCellValue('F1', 'TELÉFONO');
        $sheet->setCellValue('G1', 'ESTADO');
        $sheet->setCellValue('H1', 'FECHA APARTADO');
        $sheet->setCellValue('I1', 'FECHA PAGO');
        $sheet->setCellValue('J1', 'ESTATUS');
        $sheet->getStyle('A1:J1')->applyFromArray($styleArray);
        
        //DATOS
        $batchSize    = 5000;
        $totalRecords = Tickets::find()->where(["rifa_id" => $modelRifa->id,"expiration"=>0])->count();

        // Procesa por lotes
        for ($offset = 0; $offset < $totalRecords; $offset += $batchSize) {
            // Obtén un lote de registros
            $data = Tickets::find()->where(["rifa_id" => $modelRifa->id,"expiration"=>0])->offset($offset)->limit($batchSize)->all();

            // Procesa el lote y agrega los datos al archivo Excel
            $this->procesarLote($sheet, $data, $modelRifa ,$offset + 2); // Offset + 2 para empezar desde la tercera fila
        }//end foreach

        // Configurar la respuesta de Yii para la descarga
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_RAW;
        $headers = $response->headers;

        // Definir el tipo de contenido y el nombre del archivo
        $filename = "boletospagadosapartados_rifa_".$modelRifa->id."_".$modelRifa->name;
        $headers->add('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $headers->add('Content-Disposition', 'attachment;filename="'.$filename.'".xlsx"');
        $headers->add('Cache-Control', 'max-age=0');

        // Crear el escritor y guardar el archivo Excel en el flujo de salida
        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        // Configurar el tamaño de la respuesta y enviarla
        $response->content = $content;
        $headers->add('Content-Length', strlen($content));
        //return $this->redirect(['index','response'=>$response]);
        return $response;
    }//end function

    public function actionReportevencidos($id){
        $modelRifa = Rifas::findOne($id);
        // Crear una instancia de PhpSpreadsheet
        $spreadsheet = new Spreadsheet();

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'DC3545',
                ],
            ],
        ];
        // Seleccionar la hoja activa
        $sheet = $spreadsheet->getActiveSheet();
        // Agregar datos y estilo a las cabeceras
        $sheet->setCellValue('A1', 'RIFA');
        $sheet->setCellValue('B1', 'TICKET');
        $sheet->setCellValue('C1', 'FOLIO');
        $sheet->setCellValue('D1', 'NOMBRE(S)');
        $sheet->setCellValue('E1', 'APELLIDO(S)');
        $sheet->setCellValue('F1', 'TELÉFONO');
        $sheet->setCellValue('G1', 'ESTADO');
        $sheet->setCellValue('H1', 'FECHA APARTADO');
        $sheet->setCellValue('I1', 'FECHA VENCIDO');
        $sheet->setCellValue('J1', 'ESTATUS');
        $sheet->getStyle('A1:J1')->applyFromArray($styleArray);
        
        //DATOS
        $batchSize    = 5000;
        $totalRecords = Tickets::find()->where(["rifa_id" => $modelRifa->id,"expiration"=>1])->count();

        // Procesa por lotes
        for ($offset = 0; $offset < $totalRecords; $offset += $batchSize) {
            // Obtén un lote de registros
            $data = Tickets::find()->where(["rifa_id" => $modelRifa->id,"expiration"=>1])->offset($offset)->limit($batchSize)->all();

            // Procesa el lote y agrega los datos al archivo Excel
            $this->procesarLoteVencidos($sheet, $data, $modelRifa ,$offset + 2); // Offset + 2 para empezar desde la tercera fila
        }//end foreach

        // Configurar la respuesta de Yii para la descarga
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_RAW;
        $headers = $response->headers;

        // Definir el tipo de contenido y el nombre del archivo
        $filename = "boletosvencidos_rifa_".$modelRifa->id."_".$modelRifa->name;
        $headers->add('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $headers->add('Content-Disposition', 'attachment;filename="'.$filename.'".xlsx"');
        $headers->add('Cache-Control', 'max-age=0');

        // Crear el escritor y guardar el archivo Excel en el flujo de salida
        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        // Configurar el tamaño de la respuesta y enviarla
        $response->content = $content;
        $headers->add('Content-Length', strlen($content));
        //return $this->redirect(['index','response'=>$response]);
        return $response;
    }//end function

    public function actionReportedespreciados($id){
        $modelRifa = Rifas::findOne($id);
        // Crear una instancia de PhpSpreadsheet
        $spreadsheet = new Spreadsheet();

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'D4D2D2',
                ],
            ],
        ];
        // Seleccionar la hoja activa
        $sheet = $spreadsheet->getActiveSheet();
        // Agregar datos y estilo a las cabeceras
        $sheet->setCellValue('A1', 'RIFA');
        $sheet->setCellValue('B1', 'TICKET');
        $sheet->setCellValue('C1', 'FOLIO');
        $sheet->setCellValue('D1', 'NOMBRE(S)');
        $sheet->setCellValue('E1', 'APELLIDO(S)');
        $sheet->setCellValue('F1', 'TELÉFONO');
        $sheet->setCellValue('G1', 'ESTADO');
        $sheet->setCellValue('H1', 'FECHA APARTADO');
        $sheet->setCellValue('I1', 'FECHA VENCIDO');
        $sheet->setCellValue('J1', 'ESTATUS');
        $sheet->getStyle('A1:J1')->applyFromArray($styleArray);
        
        //DATOS
        $batchSize    = 5000;
        $totalRecords = Ticketstorage::find()->where(["rifa_id" => $modelRifa->id,"expiration"=>1])->count();

        // Procesa por lotes
        for ($offset = 0; $offset < $totalRecords; $offset += $batchSize) {
            // Obtén un lote de registros
            $data = Ticketstorage::find()->where(["rifa_id" => $modelRifa->id,"expiration"=>1])->offset($offset)->limit($batchSize)->all();

            // Procesa el lote y agrega los datos al archivo Excel
            $this->procesarLoteVencidos($sheet, $data, $modelRifa ,$offset + 2); // Offset + 2 para empezar desde la tercera fila
        }//end foreach

        // Configurar la respuesta de Yii para la descarga
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_RAW;
        $headers = $response->headers;

        // Definir el tipo de contenido y el nombre del archivo
        $filename = "boletosdespreciados_rifa_".$modelRifa->id."_".$modelRifa->name;
        $headers->add('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $headers->add('Content-Disposition', 'attachment;filename="'.$filename.'".xlsx"');
        $headers->add('Cache-Control', 'max-age=0');

        // Crear el escritor y guardar el archivo Excel en el flujo de salida
        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        // Configurar el tamaño de la respuesta y enviarla
        $response->content = $content;
        $headers->add('Content-Length', strlen($content));
        //return $this->redirect(['index','response'=>$response]);
        return $response;
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
