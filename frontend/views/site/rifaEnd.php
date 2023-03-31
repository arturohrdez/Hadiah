<?php 
if(is_null($model)){
?>
<section id="breadcrumbs" class="breadcrumbs">
	<div class="container">
		<div class="d-flex justify-content-between align-items-center">
			<h2>NOT FOUND</h2>
		</div>
	</div>
</section>

<section id="blog" class="blog">
	<div class="container" data-aos="fade-up">
		<div class="row">
			<div class="col-lg-12 entries text-center">
				<div class="alert alert-danger">
					<h1>SITIO NO ENCONTRADO</h1>
				</div>
				<div class="mt-5">
					<a class="btn btn-primary" href="/">Ir al Inicio</a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
}else{
?>
<section id="breadcrumbs" class="breadcrumbs">
	<div class="container">
		<div class="d-flex justify-content-between align-items-center">
			<h2><?php echo $model->name; ?></h2>
		</div>
	</div>
</section>

<section id="blog" class="blog">
	<div class="container" data-aos="fade-up">
		<div class="row">
			<div class="col-lg-12 entries text-center">
				<div class="alert alert-danger"><h1>¡ÉSTE SORTEO YA SE CERRÓ!</h1></div>
				<div class="mt-5">
					<a class="btn btn-primary" href="/">Ir al Inicio</a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
}//end if
?>
