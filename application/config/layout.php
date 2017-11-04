<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Opciones del Layout
|--------------------------------------------------------------------------
|  
| Esta configuracion permite definir distintos parametros entre los 
| que destacan los metas para la cabezsera, las hojas de estilo 
| y los scripts. Se debe tener mucha precaucion al momeneto de configurar
| puesto que afecta directamente la vista final de la aplicacion.
|
*/

$config['version'] = 	 'Alpha';
$config['author'] = 	 'Álvaro Güette';
$config['email'] = 		 'alvaro.guette@guettsoft.com';
$config['url_license'] = 'https://raw.githubusercontent.com/alvaroraafael/prototipo-agence/master/LICENSE.md';
$config['url_github'] =  'https://github.com/alvaroraafael/prototipo-agence';

$config['layout_metas'] =  array(
									'title' => 'CAOL - Controle de Atividades Online - Agence Interativa',
									'robots' => 'noindex',
									'geography' => 'Venezuela',
									'copyright' => '(c) 2017 Álvaro Güette. All rights reserved.',
									'author' => $config['author'],
								);

$config['layout_styles'] =  array(   
									'static/libs/materialize/fonts/material-icons/material-icons.min.css',
									'static/libs/materialize/fonts/roboto/google-font-roboto.min.css',
									'static/libs/materialize/css/materialize-0.100.2.min.css',
									'static/css/layout.min.css',									
								);

$config['layout_scripts_header'] =  array(
									'static/libs/jquery/jquery-3.2.1.min.js',								
								);

$config['layout_scripts_footer'] =  array(
									'static/libs/materialize/js/materialize-0.100.2.min.js',
									'static/js/layout.min.js',
								);