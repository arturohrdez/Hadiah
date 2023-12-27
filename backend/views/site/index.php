<?php
use yii\helpers\Url;
$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center">
            <span class="h1">REPORTE DE BOLETOS VENDIDOS</span>
        </div>
        <div class="col-12">
            <canvas id="barChart" class="col-12 bg-gradient-dark" height="250"></canvas>
        </div>
    </div> 
    <div class="row">
        <div class="col-12 p-2">
            <h4>RIFAS</h4>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => 'Rifas',
                'text'  => 'Administra la creación y edicioń de Rifas.',
                'icon'  => 'fa fa-bolt',
                'theme' => 'gradient-dark',
                'linkText' => 'Ver Más',
                'linkUrl' => Url::to(['/rifas/index'])
            ]) ?>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => 'Ganadores',
                'text'  => 'Muestra la lista de ganadores que podras filtrar por rifa y tipo de ganador.',
                'icon'  => 'fas fa-trophy',
                'theme' => 'gradient-dark',
                'linkText' => 'Ver Más',
                'linkUrl' => Url::to(['/ganadores/index'])
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 p-2">
            <h4>BOLETOS</h4>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => 'Boletos Activos',
                'text'  => 'Listado de boletos apartados y vendidos.',
                'icon'  => 'fas fa-ticket-alt',
                'theme' => 'gradient-dark',
                'linkText' => 'Ver Más',
                'linkUrl' => Url::to(['/tickets/index'])
            ]) ?>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => 'Boletos Vencidos',
                'text'  => 'Listado de boletos expirados',
                'icon'  => 'far fa-calendar-times',
                'theme' => 'gradient-dark',
                'linkText' => 'Ver Más',
                'linkUrl' => Url::to(['/tickets/index'])
            ]) ?>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => 'Despreciados',
                'text'  => 'Listado de boletos despreciados.',
                'icon'  => 'fa fa-ban',
                'theme' => 'gradient-dark',
                'linkText' => 'Ver Más',
                'linkUrl' => Url::to(['/ticketstorage/index'])
            ]) ?>
        </div>
        
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => 'Buscador',
                'text'  => 'Busca boletos en específico y verifica la información.',
                'icon'  => 'fas fa-search',
                'theme' => 'gradient-dark',
                'linkText' => 'Ver Más',
                'linkUrl' => Url::to(['/tickets/search'])
            ]) ?>
        </div>
    </div>

        <!-- <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?/*= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => 'Punto de Venta',
                'text'  => 'Terminal de venta de Boletos',
                'icon'  => 'fas fa-cart-arrow-down',
                'theme' => 'gradient-dark',
                'linkText' => 'Ver Más',
                'linkUrl' => Url::to(['/tickets/sales'])
            ])*/ ?>
        </div> -->
    <div class="row">
        <div class="col-12 p-2">
            <h4>CONFIGURACIONES</h4>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => 'Generales',
                'text'  => 'Configuración de logos, redes sociales y más.',
                'icon'  => 'fas fa-tools',
                'theme' => 'gradient-dark',
                'linkText' => 'Ver Más',
                'linkUrl' => Url::to(['/site/config'])
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => 'Métodos de pagos',
                'text'  => 'Administra la información de tus métodos de pagos.',
                'icon'  => 'fas fa-money-check-alt',
                'theme' => 'gradient-dark',
                'linkText' => 'Ver Más',
                'linkUrl' => Url::to(['/metodospagos/index'])
            ]) ?>
        </div>
    </div>
    
    <!-- <div class="row">
        <div class="col-lg-6">
            <?= \hail812\adminlte\widgets\Alert::widget([
                'type' => 'success',
                'body' => '<h3>Congratulations!</h3>',
            ]) ?>
            <?= \hail812\adminlte\widgets\Callout::widget([
                'type' => 'danger',
                'head' => 'I am a danger callout!',
                'body' => 'There is a problem that we need to fix. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'CPU Traffic',
                'number' => '10 <small>%</small>',
                'icon' => 'fas fa-cog',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Messages',
                'number' => '1,410',
                'icon' => 'far fa-envelope',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Bookmarks',
                'number' => '410',
                 'theme' => 'success',
                'icon' => 'far fa-flag',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Uploads',
                'number' => '13,648',
                'theme' => 'gradient-warning',
                'icon' => 'far fa-copy',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Bookmarks',
                'number' => '41,410',
                'icon' => 'far fa-bookmark',
                'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ]
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?php $infoBox = \hail812\adminlte\widgets\InfoBox::begin([
                'text' => 'Likes',
                'number' => '41,410',
                'theme' => 'success',
                'icon' => 'far fa-thumbs-up',
                'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ]
            ]) ?>
            <?= \hail812\adminlte\widgets\Ribbon::widget([
                'id' => $infoBox->id.'-ribbon',
                'text' => 'Ribbon',
            ]) ?>
            <?php \hail812\adminlte\widgets\InfoBox::end() ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Events',
                'number' => '41,410',
                'theme' => 'gradient-warning',
                'icon' => 'far fa-calendar-alt',
                'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ],
                'loadingStyle' => true
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '150',
                'text' => 'New Orders',
                'icon' => 'fas fa-shopping-cart',
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
                'title' => '150',
                'text' => 'New Orders',
                'icon' => 'fas fa-shopping-cart',
                'theme' => 'success'
            ]) ?>
            <?= \hail812\adminlte\widgets\Ribbon::widget([
                'id' => $smallBox->id.'-ribbon',
                'text' => 'Ribbon',
                'theme' => 'warning',
                'size' => 'lg',
                'textSize' => 'lg'
            ]) ?>
            <?php \hail812\adminlte\widgets\SmallBox::end() ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '44',
                'text' => 'User Registrations',
                'icon' => 'fas fa-user-plus',
                'theme' => 'gradient-success',
                'loadingStyle' => true
            ]) ?>
        </div>
    </div> -->
</div>

<?php 
/* $data = [
    'labels' => [],
    'data' => [],
]; */


$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js');
$this->registerJs("
    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: " . json_encode($data['labels']) . ",
            datasets: [{
                label: '% DE BOLETOS VENDIDOS',
                data: " . json_encode($data['items']) . ",
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        color: '#FFF' // Color del texto en el eje Y
                    }
                },
                x: {
                    ticks: {
                        color: '#FFF' // Color del texto en el eje Y
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#FFF' // Color del texto de la leyenda
                    }
                }
            }
        }
    });
");
?>