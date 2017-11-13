<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<script type="text/javascript">mostrarPrecarga();</script>

	<!-- materialTable -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/libs/datatable/css/materialTable.min.css" media="screen,projection">

	<!-- comercial -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/css/comercial/comercial.min.css" media="screen,projection">

	<!-- container-master -->
	<div id="container-master">

		<!-- top-nav -->
		<div class="top-nav">
	  		<a href="<?php echo base_url();?>comercial/" id="btn-back" class="btn-floating waves-effect waves-light blue btn-back-left"><i class="material-icons">chevron_left</i></a>		
			<div class="nav-wrapper"><a class="page-title">Performance Comercial / <?php echo $breadcrumb?></a></div>
		</div>
		<!-- fin top-nav -->

		<div class="container-option">
	        <div class="row">
	            <div class="input-field col s12 m6 l2 responsive">
	                <label class="active" for="fecha_inicio">Fecha de inicio</label>
	                <input id="fecha-inicio" name="fecha_inicio" type="text" class="datepickerInicio pointer">
	            </div>
	            <div class="input-field col s12 m6 l2 responsive">
	                <label class="active" for="fecha_fin">Fecha de fin</label>
	                <input id="fecha-fin" name="fecha_fin" type="text" class="datepickerFin pointer">
	            </div>
	        </div>
	        <div class="list-option">
				<a id="btn-relatorio" class="waves-effect waves-light btn blue"><i class="material-icons left">description</i>Relatório</a>
				<a id="btn-grafico" class="waves-effect waves-light btn blue"><i class="material-icons left">poll</i>Gráfico</a>
				<a id="btn-pizza" class="waves-effect waves-light btn blue"><i class="material-icons left">donut_large</i>Pizza</a>
	        </div>
		</div>

		<div class="material-table z-depth-1"">
		  <table id="consultores-table" class="display bordered" width="100%" cellspacing="0"  style="display: none;">
		      <thead>
		          <tr>
		              <th class="td-space">#</th>
		              <th style="display:none;">id</th>	              
		              <th>Nombre</th>
		              <th class="hide-field">Correo</th>
		          </tr>
		      </thead>
		      <tbody>
		          <?php
		          if (isset($consultores) && $consultores['status'] == 200)
		          {
		              foreach ($consultores['data'] as $clave => $valor)
		              {
		                  $numero = $clave+1;
		                  $email = $valor['no_email'];
		                  if (empty($email))
		                  {
		                      $email = 'No disponible';
		                  }
		                  echo'<tr>	                  
		                          <td class="td-space">'.$numero.'</td>                
		                          <td style="display:none;">'.$valor['co_usuario'].'</td>	                          
		                          <td>'.$valor['no_usuario'].'</td>
		                          <td class="hide-field">'.$email.'</td>
		                      </tr>';
		              }

		          }else{
		                echo'<tr><td colspan="3" class="dataTables_empty">No exiten consultores disponibles</td></tr>';           
		          }
		          ?>
		      </tbody>
		  </table>
		</div>

	</div>
	<!-- container-master -->

	<!-- container-secondary-->
	<div id="container-secondary"></div>
	<!-- container-secondary-->	

	<!-- datetable-->
	<script type="text/javascript" src="<?php echo base_url();?>static/libs/datatable/js/jquery.dataTables.min.js"></script>
	
	<!-- comercial-->
	<script type="text/javascript" src="<?php echo base_url();?>static/js/comercial/comercial.js"></script>

	<script type="text/javascript">

		// fecha minima para realizar consultas 
		var min_data_emissao = '<?php echo $min_data_emissao?>';

		$(function(){
			$(document).ready(function() {
				ocultarPrecarga();
				$('#consultores-table').show();
				consultores.init();
			});
		})
	</script>