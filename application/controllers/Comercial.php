<?php
/**
 * prototipo-agence
 *
 * Protótipo para Avaliação de Candidato.
 *
 * Este proyecto está licenciado bajo MIT License
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2017, Álvaro Güette
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	   prototipo-agence
 * @author	   Álvaro Güette
 * @copyright  Copyright (c) 2017 - Álvaro Güette (https://github.com/alvaroraafael/prototipo-agence)
 * @license	   https://raw.githubusercontent.com/alvaroraafael/prototipo-agence/master/LICENSE.md MIT License
 * @link	   http://agence.guettsoft.com/
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comercial
 *
 * Controlador de la funcionalidad comercial de la aplicacion 
 * con las funciones necesarias para interactuar con el 
 * modelo de la funcionalidad
 *
 * @package	   prototipo-agence
 * @category   Controllers
 * @author	   Álvaro Güette
 * @link	   http://agence.guettsoft.com/
 */
class Comercial extends CI_Controller {

	// --------------------------------------------------------------------

	/**
	 *  Constructor de la clase
	 *
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('layout');
		$this->load->model('consultores');		
		log_message('info', 'El controlador comercial se ha iniciado');
	}

	// --------------------------------------------------------------------

	/**
	 * Index
	 *
	 * Esta funcion muestra la pantalla index de comercial
	 *
	 * @return	html
	 */
	function index()
	{
		$data['author'] = $this->config->item('author');
		$data['email'] = $this->config->item('email');
		$data['url_github'] = $this->config->item('url_github');
		
		$html = $this->load->view('comercial/inicio',$data,true);
		return $this->layout->response_view($html);
	}

	// --------------------------------------------------------------------    

	/**
	 * 
	 * con_desempenho
	 * 	 	 
	 * Esta funcion muestra la lista de consultores y cada una de las
	 * opciones disponibles para ser procesadas 
	 *
	 * @return html
	 */
	public function con_desempenho(){
		$data['breadcrumb'] = 'Consultor';
		$data['author'] = $this->config->item('author');
		$data['email'] = $this->config->item('email');		
		$data['min_data_emissao'] = $this->consultores->menor_data_emissao();
		$data['consultores'] = $this->consultores->obtener_consultores();

		$html = $this->load->view('comercial/con_desempenho',$data,true);
		return $this->layout->response_view($html);		
	}

	// --------------------------------------------------------------------    

	/**
	 * 
	 * relatorio
	 * 	 	 
	 * Esta funcion procesa los resultados para la pestaña relatorio
	 *
	 * @param array $consultores       Lista de consultores ['alvaro.guette','ejemplo.ejeplo']
	 * @param string $fechas_inicio    Fecha de inicio del periodo a consultar '2003-01-01'
	 * @param stering $fecha_fin       Fecha de fin del periodo a consultar '2004-01-01'
	 * @return string $respuesta	   Vista html renderizada con los datos
	 */
	public function relatorio(){

		$parametros = $this->input->post('data');
		$consultores = $parametros["consultores"];
		$fecha_inicio = $parametros["fecha_inicio"];
		$fecha_fin = $parametros["fecha_fin"];

		if (verificar_periodo($fecha_inicio, $fecha_fin) && $consultores)
		{
			// consultores
			$consultores = $this->consultores
								->listado_co_usuario($consultores);
			// facturas
			$facturas = $this->consultores
							 ->listado_facturas_ordenes_servicios_usuario($consultores, 
																		  $fecha_inicio, 
																		  $fecha_fin);
			if ($facturas)
			{
				// facturas agrupadas por consultor
				$facturas_consultores = $this->consultores
											 ->facturas_agrupadas_consultores($facturas, 
																			  $consultores);
				// facturas agrupadas por periodo
				$facturas_fechas = $this->consultores
										->fechas_agrupadas_consultores($facturas_consultores, 
																		$consultores);			
		    	// costos fijos por consultor
		    	$costos_fijos =  $this->consultores
		    						  ->listado_costo_fijo($consultores);
				// resumen relatorio
				$data['consultores'] = $this->consultores
											->procesar_relatorio($facturas_consultores, 
																 $facturas_fechas,
																 $costos_fijos,
																 $consultores);
			}else{
				// Si no hay facturas
				$data['consultores'] = false;
			}
			$data['breadcrumb'] = 'Consultor';
			$data['periodo'] = $this->consultores->periodo($fecha_inicio, $fecha_fin);			
			return $this->load->view('comercial/con_desem_consultor_rel',$data,false);
		}else{
			return false;
		}

	}

}
