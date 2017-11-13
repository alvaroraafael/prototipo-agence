<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<!-- consultor -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/css/comercial/consultor.css" media="screen,projection">

	<!-- top-nav -->
	<div class="top-nav">
  		<a href="#" id="btn-back-master" class="btn-floating waves-effect waves-light blue btn-back-left"><i class="material-icons">chevron_left</i></a>
		<div class="nav-wrapper"><a class="page-title">Performance Comercial / <?php echo $breadcrumb?> / Pizza</a></div>
	</div>
	<!-- fin top-nav -->

	<div class="container-periodo">
		 <?php echo $periodo?>
	</div>

	<div style="margin: auto; text-align: center;">
		<ul class="collapsible popout" data-collapsible="expandable">
		<?php

		// ESTO HAY QUE REFACTORIZARLO Y PASARLO AL MODELO  - MOTIVO ENTREGA URGENTE 

		if (isset($consultores) && $consultores != "")
		{
	        $cantidad_consultores = 0;
	        $ganancias = 0;
	        $total_consultores = array();
	        $total_ganancias = array();

	        foreach ($consultores as $llave => $periodo)
	        {	        	
                $cantidad_consultores = $cantidad_consultores + 1; 
                $total_consultores[$llave]['ganancias'] = $periodo['ganancias-netas'];
                $total_ganancias[$llave] = $periodo['ganancias-netas'];
                $total_consultores[$llave]['nombre'] = $periodo['no_usuario'];
			}
			$ganancias = array_sum($total_ganancias);

				    echo '<li class="active">
				      <div class="collapsible-header active"><i class="material-icons">person</i> Pizza Consultores</div>
				      <div class="collapsible-body" style="display: block; margin: auto; text-align: center; overflow: auto;">
				          <span>';

				          $parametros = "";
					        foreach ($total_consultores as $llave => $total)
					        {
				               if ($total['ganancias'] > 0){
				               		$color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
				               		$porcentaje = round( ( ( 100 * $total['ganancias']) / $ganancias ) ,2);
				               		$parametros = $parametros.'<set value="'.$porcentaje.'" name="'.$total['nombre'].'" color="'.$color.'" />';
				               }
							}

					        foreach ($periodo['periodos'] as $datos)
					        {				        	
					                    $datos['periodo'];
					                    $datos['ganacia-neta'];
					                    $datos['costo-fijo'];
					                    $datos['comision'];
					                    $datos['beneficio'];
					        }							

							
								#  Se genera el archivo TXT  'a'
										$txt= fopen('data_pizza.xml', 'w') or die ('Error en XML');
										#  Se establecen los datos que va a conterner el archivo
										fwrite($txt, '
								  
								  <graph caption="Participação na Receita" bgColor="ffffff" decimalPrecision="1" showPercentageValues="1" showNames="1" numberPrefix="" showValues="1" showPercentageInLabel="1" pieYScale="65" pieBorderAlpha="40" pieFillAlpha="70" pieSliceDepth="15" pieRadius="100">'.$parametros.'</graph>

											');
										#  Se hace el ciere para no sobre escribir datos 
										fclose($txt);
												

						echo '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/
						flash/swflash.cab#version=6,0,0,0" WIDTH="650" HEIGHT="300" id="FusionCharts">
						<PARAM NAME=movie VALUE="'.base_url().'static/libs/charts/FC_2_3_Pie3D.swf">
						<PARAM NAME="FlashVars" VALUE="&dataURL='.base_url().'data_pizza.xml&amp;chartWidth=650&amp;chartHeight=300">
						<PARAM NAME=quality VALUE=high>
						<PARAM NAME=bgcolor VALUE=#FFFFFF>
						<EMBED src="'.base_url().'static/libs/charts/FC_2_3_Pie3D.swf" FlashVars="&dataURL='.base_url().'data_pizza.xml&amp;chartWidth=650&amp;chartHeight=300" quality=high bgcolor=#FFFFFF WIDTH="650" HEIGHT="300" NAME="FusionCharts" TYPE="application/x-shockwave-flash" libsPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
						</OBJECT>';

				        echo '</span>
				      </div>
				    </li>';


		echo '</ul>';
			
		}else{
			echo ' 
			<ul class="collapsible" data-collapsible="expandable">
				<li class="active">
				<div class="collapsible-header active"><i class="material-icons">person</i>Pizza no disponible</div>
					<div class="collapsible-body" style="display: block;">
						<span>
							<p class="caption">Pizza no disponible no se encontraron resultados.</p>					
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