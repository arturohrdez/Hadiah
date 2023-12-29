<?php

/** @var yii\web\View $this */
use yii\bootstrap4\Html;
use yii\helpers\Url;


use backend\models\Config;
$searchConfig = Config::find()->count();
if($searchConfig > 0){
    $modelConfig = Config::find()->one();
}else{
    $modelConfig = new Config();
}//end if 
$sitename_      = empty($modelConfig->sitename) ? "RIFAS" : $modelConfig->sitename;
$sitelogo_      = empty($modelConfig->logo) ? null : $modelConfig->logo;

$sitetitlecolor_     = $modelConfig->titlecolor;
$sitefontcolor_      = $modelConfig->fontcolor;

$this->title = $sitename_.' - Métodos de Pago';

$this->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
$this->registerMetaTag(['property' => 'og:type', 'content' => '']);
$this->registerMetaTag(['property' => 'og:image', 'content' => Url::to('/frontend/web/images/pabmanlogo.jpeg', true)]);
$this->registerMetaTag(['property' => 'og:url', 'content' => Url::to('/',true)]);
$this->registerMetaTag(['property' => 'og:description', 'content' => 'Rifas PabMan - Métodos de pago.']);
?>

<!-- ======= About Section ======= -->
<section id="quienessomos" class="about mt-5">
    <div class="container">
        <div class="row col-lg-12 pb-5">
            <h1 class="text-center <?php echo !empty($sitetitlecolor_) ? $sitetitlecolor_ : "text-danger"; ?> fs-1">
                Métodos de Pago
            </h1>
        </div>
        <div class="row">
            <div class="col-12 fs-2 text-center  <?php echo !empty($sitefontcolor_) ? $sitefontcolor_ : "";  ?>">
                Debes realizar el pago por alguna de éstas opciones y enviar tu comprobante de pago.
            </div>
        </div>
        <div class="row mt-3">
        	<div class="col-12 text-center">
        		<div class="fs-3 <?php echo !empty($sitetitlecolor_) ? $sitetitlecolor_ : "text-danger"; ?>">
        			CUENTAS DE PAGO
        		</div>
        		<div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped mt-5 ">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">BANCO</th>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">NÚMERO DE TARJETA</th>
                                    <th scope="col">NÚMERO DE CUENTA</th>
                                    <th scope="col">CLABE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!empty($model)){
                                    foreach ($model as $item) {
                                        ?>
                                        <tr class="fw-bold">
                                            <td class="<?php echo !empty($sitefontcolor_) ? $sitefontcolor_ : "";  ?>"><?php echo $item->banco;?></td>
                                            <td class="<?php echo !empty($sitefontcolor_) ? $sitefontcolor_ : "";  ?>"><?php echo $item->nombre;?></td>
                                            <td class="<?php echo !empty($sitefontcolor_) ? $sitefontcolor_ : "";  ?>"><?php echo $item->tarjeta;?></td>
                                            <td class="<?php echo !empty($sitefontcolor_) ? $sitefontcolor_ : "";  ?>"><?php echo $item->cuenta;?></td>
                                            <td class="<?php echo !empty($sitefontcolor_) ? $sitefontcolor_ : "";  ?>"><?php echo $item->clabe;?></td>
                                        </tr>
                                        <?php
                                    }
                                }//end if
                                ?>
                                <!-- <tr class="fw-bold">
                                    <td>BBVA</td>
                                    <td>LAURA HERNANDEZ LUNA</td>
                                    <td>4152314077111014</td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
        		</div>
        	</div>
        	<div class="col-12 fs-3 text-center">
        		<?php 
                    echo Html::img(Yii::$app->params["baseUrlBack"].$sitelogo_,['alt'=>$sitename_,'class'=>'img-fluid col-6 mt-5',]); 
                ?>
        	</div>
        </div>
    </div>
    <div class="row">
        <hr>
    </div>
</section>
<!-- End About Section -->