<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<!-- consultor -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/css/comercial/consultor.css" media="screen,projection">

	<!-- top-nav -->
	<div class="top-nav">
  		<a href="#" id="btn-back-master" class="btn-floating waves-effect waves-light blue btn-back-left"><i class="material-icons">chevron_left</i></a>
		<div class="nav-wrapper"><a class="page-title">Performance Comercial / <?php echo $breadcrumb?> / Relatório</a></div>
	</div>
	<!-- fin top-nav -->

	<div class="container-periodo">
		 <?php echo $periodo?>
	</div>	

	<ul class="collapsible popout" data-collapsible="expandable">
		<?php
		if (isset($consultores) && $consultores != "")
		{
	        foreach ($consultores as $llave => $periodo)
	        {

		        if ($periodo['estado'])
		        {

				    echo '<li>
				      <div class="collapsible-header responsive-table"><i class="material-icons">person</i>'.$periodo['no_usuario'].'</div>
				      <div class="collapsible-body">
				          <span>
				            <table class="highlight bordered table-result responsive-table">
				                <thead>
				                  <tr>
				                      <th>Período</th>
				                      <th>Receita Líquida</th>
				                      <th>Custo Fixo</th>
				                      <th>Comissão</th>
				                      <th>Lucro</th>
				                  </tr>
				                </thead>
				                  <tbody class="t-small">';
							        foreach ($periodo['periodos'] as $datos)
							        {				        	
					                  echo '<tr>
							                    <td>'.$datos['periodo'].'</td>
							                    <td>R$ '.number_format($datos['ganacia-neta'],2,',','.').'</td>
							                    <td>R$ '.number_format($datos['costo-fijo'],2,',','.').'</td>
							                    <td>R$ '.number_format($datos['comision'],2,',','.').'</td>';

							                    if ($datos['beneficio'] > 0){
							                    	echo ' <td class="green-text text-bold">R$ '.number_format($datos['beneficio'],2,',','.').'</td>  ';
							                    }else{
							                    	echo ' <td class="red-text text-bold">R$ '.number_format($datos['beneficio'],2,',','.').'</td>  ';
							                    }
							         echo '</tr>';
							        }

				                echo '<tr>
					                    <td class="text-bold">SALDO</td>
							            <td class="text-bold">R$ '.number_format($periodo['ganancias-netas'],2,',','.').'</td>
							            <td class="text-bold">R$ '.number_format($periodo['costo-fijo'],2,',','.').'</td>
							            <td class="text-bold">R$ '.number_format($periodo['comision'],2,',','.').'</td>
					                    <td class="text-bold blue-text">R$ '.number_format($periodo['beneficio'],2,',','.').'</td>                              
					                  </tr>
				                </tbody>
				            </table>
				          </span>
				      </div>
				    </li>';

		        }
			}
		echo '</ul>';
			
		}else{
			echo ' 
			<ul class="collapsible" data-collapsible="expandable">
				<li class="active">
				<div class="collapsible-header active"><i class="material-icons">person</i>No encontrado</div>
					<div class="collapsible-body" style="display: block;">
						<span>
							<p class="caption">No se encontraron resultados.</p>					
						</span>
					</div>
				</li>
			</ul>';
		}
		?>
	
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