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
 * Layout
 *
 * Libreria para cargar el layout principal
 *
 * @package	   prototipo-agence
 * @category   Libraries
 * @author	   Álvaro Güette
 * @link	   http://agence.guettsoft.com/
 */
class Layout {

	/**
	 * Vista del header
	 *
	 * @var string
	 */
	protected $_header = '/_header';

	/**
	 * Vista del body
	 *
	 * @var string
	 */
	protected $_body = '/_body';

	/**
	 * Vista del footer
	 *
	 * @var string
	 */
	protected $_footer = '/_footer';	

	/**
	 *  Constructor de la clase
	 *
	 * @return	void
	 */
    public function __construct()
    {
        $this->CI =& get_instance();
		$this->CI->load->helper('url');	        
		$this->CI->load->library('parser');
		log_message('info', 'La libreria layout se ha iniciado');
    }

	// --------------------------------------------------------------------

	/**
	 * add_style
	 *
	 * Esta funcion carga todas las hojas de estilo
	 *
	 * @param	array	$href = array()
	 * @return	string
	 */
	private function add_style($href = array())
	{
		$link = "";
		foreach ($href as $_href) 
		{
		    $link .= '<link rel="stylesheet" type="text/css" href="'.
		    		  base_url().$_href.'"/>'."\n\t\t";
		}  
		return $link;
	}

	// --------------------------------------------------------------------

	/**
	 * add_script
	 *
	 * Esta funcion carga todas los scripts
	 *
	 * @param	array	$src = array()
	 * @return	string
	 */
	private function add_script($src = array()){
		$script = "";
		foreach ($src as $_src) 
		{
		    $script .= '<script type="text/javascript" src="'.
		               base_url().$_src.'"></script>'."\n\t\t";
		}  
		return $script;
	}

	// --------------------------------------------------------------------

	/**
	 * add_header
	 *
	 * Esta funcion carga los estilos y los scripts en la 
	 * vista parcial del _header del layout
	 *
	 * @return	string
	 */
	private function add_header()
	{
		$styles = $this->CI->config->item('layout_styles');
		$scripts = $this->CI->config->item('layout_scripts_header');

		$data['metas'] = $this->CI->config->item('layout_metas');
		$data['styles'] = $this->add_style($styles);
		$data['scripts_header'] = $this-> add_script($scripts);	

		return $this->CI->load->view('/layout'.$this->_header, $data, true);
	}

	// --------------------------------------------------------------------

	/**
	 * add_body
	 *
	 * Esta funcion carga una vista en la vista
	 * parcial del _body del layout
	 *
	 * @param	string	$view
	 * @return	string
	 */
	private function add_body($view)
	{
		$data['view'] = $view;
		$data['version'] =  $this->CI->config->item('version');
		$data['url_license'] = $this->CI->config->item('url_license');

		return $this->CI->load->view('/layout'.$this->_body, $data, true);
	}	

	// --------------------------------------------------------------------

	/**
	 * add_footer
	 *
	 * Esta funcion carga los scripts en la 
	 * vista parcial del _footer del layout
	 *
	 * @return	string
	 */

	private function add_footer()
	{
		$scripts = $this->CI->config->item('layout_scripts_footer');
		$data['scripts_footer'] = $this->add_script($scripts);

		return $this->CI->load->view('/layout'.$this->_footer, $data, true);
	}

	// --------------------------------------------------------------------	

	/**
	 * response_view
	 *
	 * Esta funcion carga una vista en la vista
	 * en la parcial del body y estruta el layout 
	 * con el header y el footer
	 *
	 * @param	string	$data
	 * @return	void
	 */
	public function response_view($data)
	{
		echo $this->add_header();
		echo $this->add_body($data);		
		echo $this->add_footer();
	}

}
