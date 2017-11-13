<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<!-- consultor -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/css/comercial/consultor.css" media="screen,projection">

	<!-- top-nav -->
	<div class="top-nav">
  		<a href="#" id="btn-back-master" class="btn-floating waves-effect waves-light blue btn-back-left"><i class="material-icons">chevron_left</i></a>
		<div class="nav-wrapper"><a class="page-title">Performance Comercial / <?php echo $breadcrumb?> / Grafico</a></div>
	</div>
	<!-- fin top-nav -->

	<div class="container-periodo">
		 <?php echo $periodo?>
	</div>

	<div>
		<ul class="collapsible popout" data-collapsible="expandable">
		<?php
		if (isset($consultores) && $consultores != "")
		{

			echo ' <ul class="collapsible" data-collapsible="expandable">
				<li class="active">
				<div class="collapsible-header active"><i class="material-icons">person</i>Grafico disponible en la proxima Version.</div>
					<div class="collapsible-body" style="display: block;">
						<span>
							<p class="caption">Grafico disponible en la proxima Version.</p>					
						</span>
					</div>
				</li>
			</ul>';


		echo '</ul>';
			
		}else{
			echo ' 
			<ul class="collapsible" data-collapsible="expandable">
				<li class="active">
				<div class="collapsible-header active"><i class="material-icons">person</i>Grafico no disponible</div>
					<div class="collapsible-body" style="display: block;">
						<span>
							<p class="caption">Grafico no disponible no se encontraron resultados.</p>					
						</span>
					</div>
				</li>
			</ul>';
		}
		?>

	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.collapsible').collapsible();			
	        $('#btn-back-master').unbind('click').click(function(e) {
                $(consultores.contenedorPrincipal).show();
                $(consultores.contenedorSecundario).hide();
                $(consultores.contenedorSecundario).empty();                
	        });
		});
	</script>