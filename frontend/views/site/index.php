<?php

/** @var yii\web\View $this */
use yii\bootstrap4\Html;
use yii\helpers\Url;

$sitename_         = empty($siteConfig->sitename) ? "RIFAS" : $siteConfig->sitename;
$siteslogan_       = empty($siteConfig->slogan) ? "---------------" : $siteConfig->slogan;
$sitequienessomos_ = empty($siteConfig->quienessomos) ? "---------------" : $siteConfig->quienessomos;
$sitelogo_         = empty($siteConfig->logo) ? null : $siteConfig->logo;
$sitewhatsapp_     = empty($siteConfig->whatsapp) ? null : $siteConfig->whatsapp;
$siteinstagram_    = empty($siteConfig->instagram) ? null : $siteConfig->instagram;
$sitefacebook_     = empty($siteConfig->facebook) ? null : $siteConfig->facebook;
$siteyoutube_      = empty($siteConfig->youtube) ? null : $siteConfig->youtube;
$sitetiktok_       = empty($siteConfig->tiktok) ? null : $siteConfig->tiktok;
$sitevideo_        = empty($siteConfig->video) ? null : $siteConfig->video;

$this->title = $sitename_." - ".$siteslogan_;

$this->registerMetaTag(['property' => 'og:title', 'content' => $sitename_]);
$this->registerMetaTag(['property' => 'og:type', 'content' => '']);
$this->registerMetaTag(['property' => 'og:image', 'content' => Url::to('/frontend/web/images/pabmanlogo.jpeg', true)]);
$this->registerMetaTag(['property' => 'og:url', 'content' => Url::to('/',true)]);
$this->registerMetaTag(['property' => 'og:description', 'content' => $sitename_.' - '.$siteslogan_]);
?>

<!-- ======= Hero Section ======= -->
<?php 
if(!empty($rifasBanner)){
?>
<section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
        <div class="carousel-inner" role="listbox">
            <?php 
            $i = 0;
            foreach ($rifasBanner as $rifa) {
                $rifa_id          = $rifa->id;
                $rifa_title       = $rifa->name;
                $rifa_description = $rifa->description;
                $rifa_image       = $rifa->main_image;
                $rifa_date        = $rifa->date_init;
            ?>
            <div class="carousel-item <?php echo ($i == 0) ? "active" : ""; ?>" style="background-image: url('<?php echo Yii::$app->params["baseUrlBack"].$rifa_image; ?>')">
            <!--<div class="carousel-item <?php //echo ($i == 0) ? "active" : ""; ?>" style="background-image: url('<?php //echo Url::base()."/backend/web/".$rifa_image; ?>')">-->
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">
                            <?php echo $rifa_title; ?>
                        </h2>
                        <p class="animate__animated animate__fadeInUp fs-3">
                            <?php
                                $diassemana = Yii::$app->params["diassemana"];
                                $meses      = Yii::$app->params["meses"];
                                echo $diassemana[date('w',strtotime($rifa_date))]." ".date('d',strtotime($rifa_date))." de ".$meses[date('n',strtotime($rifa_date))-1]. " de ".date('Y',strtotime($rifa_date)) ; 
                            ?>
                        </p>
                        <a href="<?php echo Url::to(['site/rifa','id'=>$rifa_id]) ?>" class="btn-get-started animate__animated animate__fadeInUp">Comprar Boletos</a>
                    </div>
                </div>
            </div>
            <?php 
                $i++;
            }//end foreach
            ?>
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


<!-- ======= About Section ======= -->
<section id="quienessomos" class="about">
    <div class="container">
        <div class="row col-lg-12 pb-5">
            <h2 class="text-center text-danger fs-1">
                QUIENES SOMOS
            </h2>
        </div>
        <div class="row">
            <div class="col-12 fs-3 text-justify">
                <?php echo $sitequienessomos_?>
                <!-- Bienvenido(a) a la web oficial de <span class="text-danger fw-bold">🍀<?//php echo $sitename_;?>🍀</span>, somos una asociación de amigos con sede en la ciudad de Puebla, México; con nosotros tienes la oportunidad de ganar muchos premios. 
                <span class="text-danger fw-bold"><?php //echo $siteslogan_;?></span> -->
                
                <div class="text-center">
                    <?php 
                        echo Html::img(Yii::$app->params["baseUrlBack"].$sitelogo_,['alt'=>$sitename_,'class'=>'img-fluid col-6 mt-3',]); 
                        //echo Html::img('@web/images/pabmanlogo.jpeg',['alt'=>'Banner PABMAN','class'=>'img-fluid col-6 mt-3',]); 
                    ?>
                    <!-- <?//php echo Html::img('@web/images/bannerpabman.jpeg',['alt'=>'LOGO PABMAN','class'=>'img-fluid col-6',]); ?> -->
                </div>
            </div>
        </div>
    </div>
</section>
<hr>
<!-- End About Section -->

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
                    En nuestra página oficial de <a href="<?php echo $sitefacebook_ ?>" target="_blank">Facebook</a> puedes encontrar todos y cada uno de nuestros sorteos anteriores, así como las transmisiones en vivo con Lotería Nacional y las entregas de premios a los ganadores!
                    Se elige un nuevo ganador realizando la misma dinámica en otra fecha cercana (se anunciará la nueva fecha).
                </div>
            </div>
        </div><!-- End F.A.Q Item-->
        <div class="row">
            <p class="fs-4 text-center">Encuentra transmisión en vivo de los sorteos en nuestra página de Facebook en las fechas indicadas a las 20:00 hrs CDMX. ¡No te lo pierdas!</p>
        </div>
    </div>
</section>
<hr>

<?php 
if(!empty($rifasActivas)){
?>
<section id="team" class="team ">
    <div class="container">
        <div class="row">
            <div class="section-title">
                <p class="text-center text-danger fs-1">Rifas Activas</p>
            </div>
        </div>
        <div class="row">
            <?php 
            foreach ($rifasActivas as $rifa) {
                $rifa_id    = $rifa->id;
                $rifa_title = $rifa->name;
                $rifa_terms = $rifa->terms;
                $rifa_image = $rifa->main_image;
                $rifa_date  = $rifa->date_init;
            ?>
            <div class="col-lg-6 mt-4">
                <div class="member d-flex align-items-start">
                    <div class="pic">
                        <!--<img src="<?php //echo Url::base()."/backend/web/".$rifa_image; ?>" class="img-fluid" alt="">-->
                        <img src="<?php echo Yii::$app->params["baseUrlBack"].$rifa_image; ?>" class="img-fluid" alt="">
                    </div>
                    <div class="member-info">
                        <h4><?php echo $rifa_title;?></h4>
                        <span>
                            <?php
                                $diassemana = Yii::$app->params["diassemana"];
                                $meses      = Yii::$app->params["meses"];
                                echo $diassemana[date('w',strtotime($rifa_date))]." ".date('d',strtotime($rifa_date))." de ".$meses[date('n',strtotime($rifa_date))-1]. " de ".date('Y',strtotime($rifa_date)) ; 
                            ?>
                        </span>
                        <p>
                            <?php echo nl2br($rifa_terms); ?>
                            
                        </p>
                        <div class="mt-2">
                            <a class="btn btn-outline-danger" href="<?php echo Url::to(['site/rifa','id'=>$rifa_id]) ?>">
                                Comprar Boleto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }//end foreach 
            ?>
        </div>
    </div>
</section>
<hr>
<?php 
}//end if
?>

<!-- ======= About Section ======= -->
<section id="about" class="about">
    <div class="container">
        <div class="row col-lg-12">
            <h2 class="text-center text-danger fs-1">
                <?php echo $siteslogan_;?>
            </h2>
        </div>
    </div>
</section>
<hr>
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
                <?php
                    if(!is_null($sitewhatsapp_)){
                        echo Html::a("WHATSAPP: ".$sitewhatsapp_, $url = "https://wa.me/+521".$sitewhatsapp_, ['target' => '_blank']); 
                    }
                ?>
            </p>
        </div>
        <div class="row col-lg-12 pt-3">
            <p class="fs-5 text-center">
                Envíanos tus preguntas a
            </p>
            <p class="fs-1 text-center">
                <?php
                    if(!is_null($sitewhatsapp_)){ 
                        echo Html::a("<i class='bi bi-whatsapp'></i>", $url = $url = "https://wa.me/+521".$sitewhatsapp_, ['target' => '_blank']); 
                    }//end if
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                <?php
                    if(!is_null($sitefacebook_)){ 
                        echo Html::a("<i class='bi bi-facebook'></i>", $url = $sitefacebook_, ['target' => '_blank']); 
                    }//end if
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                <?php
                    if(!is_null($siteinstagram_)){
                        echo Html::a("<i class='bi bi-instagram'></i>",$url = $siteinstagram_,['target' => '_blank']);
                    } 
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                <?php
                    if(!is_null($sitetiktok_)){
                        echo Html::a("<i class='bi bi-tiktok'></i>",$url = $sitetiktok_,['target' => '_blank']);
                    } 
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                <?php
                    if(!is_null($siteyoutube_)){
                        echo Html::a("<i class='bi bi-youtube'></i>",$url = $siteyoutube_,['target' => '_blank']);
                    } 
                    ?>
            </p>
            <?php
                if(!is_null($sitevideo_)){
            ?>
            <p class="text-center mt-5">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $sitevideo_ ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </p>
            <?php 
            }//end if
            ?>
        </div>
    </div>
</section>
<!-- End Contact Us Section -->





