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
 * Inicio
 *
 * Controlador inicial de la aplicacion con las 
 * funciones basicas para interactuar con el 
 * modelo de la funcionalidad
 *
 * @package	   prototipo-agence
 * @category   Controllers
 * @author	   Álvaro Güette
 * @link	   http://agence.guettsoft.com/
 */
class Inicio extends CI_Controller {

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
		log_message('info', 'El controlador inicio se ha iniciado');
	}

	// --------------------------------------------------------------------

	/**
	 * Index
	 *
	 * Esta funcion muestra la pantalla index
	 *
	 * @return	view
	 */
	function index()
	{
		$data['author'] = $this->config->item('author');
		$data['email'] = $this->config->item('email');
		$data['url_github'] = $this->config->item('url_github');
		
		$html = $this->load->view('inicio',$data,true);
		return $this->layout->response_view($html);
	}

}
