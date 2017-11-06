<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/css/comercial/comercial.css" media="screen,projection">

	<div class="top-nav">
			<div class="nav-wrapper"><a class="page-title">Performance Comercial</a></div>
	</div>

	<div class="row container-card-1">

		<!-- consultor -->
		<div class="col s12 m6 l4">
		<div class="card z-depth-2">
			<div class="card-image">
				<img src="<?php echo base_url();?>static/images/comercial/consultant.png">
				<a href="<?php echo base_url();?>comercial/con_desempenho" class="btn-floating btn-large  halfway-fab waves-effect waves-light blue btn-comercial"><i class="material-icons">chevron_right</i></a>
			</div>
			<div class="card-content">
				<span class="card-title">Consultor</span>        
				<p>Presenta, separado por consultor, el resultado de receitas (ganancias) generadas por cada profesional</p>
			</div>
		</div>
		</div>
		<!-- fin consultor -->

		<!-- cliente -->
		<div class="col s12 m6 l4">
		<div class="card z-depth-2 card-disabled">
			<div class="card-image">
				<img src="<?php echo base_url();?>static/images/comercial/client.png">
				<a href="#" class="btn-floating btn-large disabled halfway-fab waves-effect waves-light blue btn-comercial"><i class="material-icons">chevron_right</i></a>
			</div>
			<div class="card-content">
				<span class="card-title">Cliente</span>        
				<p>Presenta, separado por cliente, el resultado de distintos datos generados por cada cliente</p>
			</div>
		</div>
		</div>
		<!-- fin cliente -->

	</div>