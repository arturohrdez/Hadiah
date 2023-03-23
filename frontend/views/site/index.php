<?php

/** @var yii\web\View $this */
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Rifas';
?>

<!-- ======= Hero Section ======= -->
<?php 
if(!empty($rifas)){
?>
<section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
        <div class="carousel-inner" role="listbox">
            <?php 
            foreach ($rifas as $rifa) {
                $rifa_id          = $rifa->id;
                $rifa_title       = $rifa->name;
                $rifa_description = $rifa->description;
                $rifa_image       = $rifa->main_image;
            ?>
            <!-- Slide 1 -->
            <div class="carousel-item active" style="background-image: url('<?php echo Yii::$app->params["baseUrlBack"].$rifa_image; ?>')">
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">
                            <?php echo $rifa_title; ?>
                        </h2>
                        <a href="<?php echo Url::to(['site/rifa','id'=>$rifa_id]) ?>" class="btn-get-started animate__animated animate__fadeInUp">Comprar Boletos</a>
                    </div>
                </div>
            </div>
            <?php 
            }//end foreach
            ?>
            <!-- Slide 2 -->
            <!-- <div class="carousel-item" style="background-image: url(assets/img/slide/slide-2.jpg)">
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">Lorem Ipsum Dolor</h2>
                        <p class="animate__animated animate__fadeInUp">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam. Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus deleniti vel. Minus et tempore modi architecto.</p>
                        <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
                    </div>
                </div>
            </div> -->
            <!-- Slide 3 -->
            <!-- <div class="carousel-item" style="background-image: url(assets/img/slide/slide-3.jpg)">
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">Sequi ea ut et est quaerat</h2>
                        <p class="animate__animated animate__fadeInUp">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam. Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus deleniti vel. Minus et tempore modi architecto.</p>
                        <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
                    </div>
                </div>
            </div> -->
        </div>
        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>
    </div>
</section>
<?php 
}//end if
?>
<!-- End Hero -->


<section id="faq" class="faq">
    <div class="container">
        <div class="section-title">
            <p class="text-center text-danger fs-1">Preguntas Frecuentes</p>
        </div>
        <div class="row faq-item d-flex align-items-stretch">
            <div class="col-lg-5">
                <i class="bx bx-help-circle"></i>
                <h4 class="fs-4">¿CÓMO SE ELIGE A LOS GANADORES?</h4>
            </div>
            <div class="col-lg-7">
                <div class="text-justify fs-6">
                    Todos nuestros sorteos se realizan en base a la <?= Html::a('Lotería Nacional para la Asistencia', $url = "https://www.lotenal.gob.mx/", ['target' => '_blank']); ?> Pública mexicana.
                    <br>
                    <br>
                    El ganador de la Rifa será el participante cuyo número de boleto coincida con las últimas cifras del primer premio ganador de la Lotería Nacional (las fechas serán publicadas en nuestra página oficial).
                </div>
            </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch">
            <div class="col-lg-5">
                <i class="bx bx-help-circle"></i>
                <h4 class="fs-4">¿QUÉ SUCEDE CUANDO EL NÚMERO GANADOR ES UN BOLETO NO VENDIDO?</h4>
            </div>
            <div class="col-lg-7">
                <div class="text-justify fs-6">
                    Se elige un nuevo ganador realizando la misma dinámica en otra fecha cercana (se anunciará la nueva fecha).
                    <br>
                    Esto significa que, ¡Tendrías el doble de oportunidades de ganar con tu mismo boleto!
                </div>
            </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch">
            <div class="col-lg-5">
                <i class="bx bx-help-circle"></i>
                <h4 class="fs-4">¿DÓNDE SE PUBLICA A LOS GANADORES?</h4>
            </div>
            <div class="col-lg-7">
                <div class="text-justify fs-6">
                    En nuestra página oficial de Facebook {!page} puedes encontrar todos y cada uno de nuestros sorteos anteriores, así como las transmisiones en vivo con Lotería Nacional y las entregas de premios a los ganadores!
                    Se elige un nuevo ganador realizando la misma dinámica en otra fecha cercana (se anunciará la nueva fecha).
                </div>
            </div>
        </div><!-- End F.A.Q Item-->
        <div class="row">
            <p class="fs-4 text-center">Encuentra transmisión en vivo de los sorteos en nuestra página de Facebook en las fechas indicadas a las 20:00 hrs CDMX. ¡No te lo pierdas!</p>
        </div>
        <div class="row">
            <hr>
        </div>
    </div>
</section>

<!-- ======= About Section ======= -->
<section id="about" class="about">
    <div class="container">
        <div class="row col-lg-12">
            <h2 class="text-center text-danger fs-1">
                ACERCA DE NOSOTROS
            </h2>
        </div>
        <div class="row col-lg-12 pt-4 pt-lg-0">
            <p class="text-center fs-5">
                SORTEOS ENTRE AMIGOS EN BASE A LOTERIA NACIONAL
            </p>
            <p class="text-center fs-5">
                ARRIESGA POCO Y GANA MUCHO!
            </p>
        </div>
        <br>
        <div class="row">
            <hr>
        </div>
    </div>
</section>
<!-- End About Section -->

<!-- ======= Contact Us Section ======= -->
<section id="contactus" class="about">
    <div class="container">
        <div class="row col-lg-12">
            <h2 class="text-center text-danger fs-1">
                CONTACTÁNOS
            </h2>
        </div>
        <div class="row col-lg-12 pt-4 pt-lg-0">
            <p class="text-center fs-4">
                <?= Html::a("WHATSAPP: (221) 222 4619", $url = 'https://wa.me/+5212212224916', ['target' => '_blank']); ?>
            </p>
        </div>
        <div class="row col-lg-12 pt-3">
            <p class="fs-5 text-center">
                Envíanos tus preguntas a
            </p>
            <p class="fs-1 text-center">
                <?= Html::a("<i class='bi bi-whatsapp'></i>", $url = 'https://wa.me/+5212212224916', ['target' => '_blank']); ?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?= Html::a("<i class='bi bi-facebook'></i>", $url = 'https://es-es.facebook.com/', ['target' => '_blank']); ?>
            </p>
        </div>
    </div>
</section>
<!-- End Contact Us Section -->





