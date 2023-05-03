<?php

/** @var yii\web\View $this */
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'RIFAS PABMAN - Métodos de Pago';

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
            <h1 class="text-center text-danger fs-1">
                Métodos de Pago
            </h1>
        </div>
        <div class="row">
            <div class="col-12 fs-2 text-center">
                Debes realizar el pago por alguna de éstas opciones y enviar tu comprobante de pago.
            </div>
        </div>
        <div class="row mt-3">
        	<div class="col-12 text-center">
        		<div class="fs-3 text-danger">
        			CUENTAS DE PAGO
        		</div>
        		<div class="col-12">
        			<table class="table mt-5">
        				<thead>
        					<tr>
        						<th scope="col">BANCO</th>
        						<th scope="col">NOMBRE</th>
        						<th scope="col">NÚMERO DE TARJETA</th>
        					</tr>
        				</thead>
        				<tbody>
        					<tr class="fw-bold">
        						<td>BBVA</td>
        						<td>LAURA HERNANDEZ LUNA</td>
        						<td>4152314077111014</td>
        					</tr>
        				</tbody>
        			</table>
        		</div>
        	</div>
        	<div class="col-12 fs-3 text-center">
        		<?php echo Html::img('@web/images/bannerpabman.jpeg',['alt'=>'LOGO PABMAN','class'=>'img-fluid col-6',]); ?>
        	</div>
        </div>
    </div>
    <div class="row">
        <hr>
    </div>
</section>
<!-- End About Section -->