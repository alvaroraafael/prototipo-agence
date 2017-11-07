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
 * Consultores
 *
 * Modelo principal de la funcionalidad consultores 
 * en performance comercial->consultores
 *
 * @package	   prototipo-agence
 * @category   Models
 * @author	   Álvaro Güette
 * @link	   http://agence.guettsoft.com/
 */
class Consultores extends CI_Model 
{

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->helper('comunes');
    }

	/**
	 * Condicion query_consultores
	 *
	 * @var	int
	 */
	protected $_co_sistema = 1;


	/**
	 * Condicion query_consultores
	 *
	 * @var	string
	 */
	protected $_in_ativo = 'S';

	/**
	 * Condicion query_consultores
	 *
	 * @var	array
	 */
	protected $_co_tipo_usuario = array(0,1,2);


	// --------------------------------------------------------------------

	/**
	 * 
	 * query_consultores
	 * 
	 * Esta funcion selecciona todos los consultores en la base de datos
	 * segun las condiciones establecidas 
	 *
	 * @return array $respuesta
	 */
    private function query_consultores(){

    	$respuesta = false;

		try {

			$this->db->select('cao_usuario.co_usuario');
			$this->db->select('cao_usuario.no_usuario');
			$this->db->select('cao_usuario.no_email');	
			$this->db->from('cao_usuario');
			$this->db->join('permissao_sistema', 'permissao_sistema.co_usuario = cao_usuario.co_usuario');
			$this->db->where('cao_usuario.co_usuario is NOT NULL', NULL, FALSE);
			$this->db->where('permissao_sistema.co_sistema',$this->_co_sistema);
			$this->db->where('permissao_sistema.in_ativo',$this->_in_ativo);
			$this->db->where_in('permissao_sistema.co_tipo_usuario', $this->_co_tipo_usuario);
			$this->db->order_by("cao_usuario.co_usuario", "asc");			

			$query = $this->db->get();

		    if ($query && $query->num_rows() > 0)
		    {
				$respuesta = $query->result_array();

		    }else{

		      throw new Exception('Error al intentar listar todos los consultores');

		      $respuesta = false;				
			}

		} catch (Exception $e) {

			$respuesta = false;
		}			

		return $respuesta;
    }

	// --------------------------------------------------------------------    

	/**
	 * 
	 * obtener_consultores 
	 * 	 	
	 * Esta funcion obtiene todos los consultores en el sistema
	 * y formatea la respuesta
	 *
	 * @return array (status, data, message)
	 */
    public function obtener_consultores()
    {
    	$query = $this->query_consultores();

		if($query)
		{
			return formatear_respuesta($query, 'Lista completa de consultores', 200);

		}else{

			return formatear_respuesta('No se pudieron listar los consultores', 404);
		}
    }  

	// --------------------------------------------------------------------    

	/**
	 * 
	 * query_consultores_co_usuario
	 * 	 	
	 * Esta funcion selecciona todos los consultores en la base de datos
	 * por sus llaves correspondientes	 
	 *
	 * @param array $co_usuario
	 * @return array $respuesta
	 */
    private function query_consultores_co_usuario($co_usuario){

    	$respuesta = false;

		try {

			$this->db->select('cao_usuario.co_usuario');
			$this->db->select('cao_usuario.no_usuario');			
			$this->db->from('cao_usuario');
			$this->db->where('cao_usuario.co_usuario is NOT NULL', NULL, FALSE);
			$this->db->where_in('cao_usuario.co_usuario', $co_usuario);	
			$this->db->order_by("cao_usuario.co_usuario", "asc");			

			$query = $this->db->get();

		    if ($query && $query->num_rows() > 0)
		    {
				$respuesta = $query->result_array();

		    }else{

		      throw new Exception('Error al intentar listar los consultores por sus co_usuario');

		      $respuesta = false;				
			}

		} catch (Exception $e) {

			$respuesta = false;
		}			

		return $respuesta;
    }

	// --------------------------------------------------------------------

	/**
	 * 
	 * obtener_consultores_co_usuario
	 * 	 	
	 * Esta funcion solicita los consultores en el sistema
	 * por su llave correspondiente y formatea la respuesta
	 *
	 * @param array $co_usuario
	 * @return array (status, data, message)
	 */
    public function obtener_consultores_co_usuario($co_usuario)
    {
    	$query = $this->query_consultores_co_usuario($co_usuario);

		if($query)
		{
			return formatear_respuesta($query, 'Consultores por co_usuario', 200);

		}else{

			return formatear_respuesta('No se pudo obtener la lista de consultores', 404);
		}
    }  

	// --------------------------------------------------------------------    

	/**
	 * 
	 * listado_co_usuario
	 * 	 	
	 * Esta funcion intersecta los consultores solicitados
	 * con los que se encuentra en el sistema
	 * para evitar datos inexistentes
	 *	 
	 * @param array $co_usuario
	 * @return array $co_usuario
	 */
	public function listado_co_usuario($co_usuario){

    	$respuesta = false;

		if ($co_usuario && !empty($co_usuario)){
			// lista completa de consultores del sistema 
			$consultores = $this->obtener_consultores_co_usuario($co_usuario);

          if (isset($consultores) && $consultores['status'] == 200)
          {

          	$listado = array();
			foreach ($consultores['data'] as $indice => $consultor) {
				array_push($listado,$consultor['co_usuario']);
			}
			// solo retorno los consultores solicitados que existen
			$filtrado = array_intersect($listado,$co_usuario);
          }		
			$respuesta = array_values($filtrado);
		}

    	return $respuesta;		
	}

	// --------------------------------------------------------------------    

	/**
	 * 
	 * listado_no_usuario
	 * 	 	
	 * Esta funcion intersecta los consultores solicitados
	 * con los que se encuentra en el sistema
	 * para evitar datos inexistentes
	 *	 
	 * @param array $co_usuario
	 * @return array $co_usuario
	 */
	public function listado_no_usuario($co_usuario){

    	$respuesta = false;

		if ($co_usuario && !empty($co_usuario))
		{
			// lista completa de consultores del sistema 
			$consultores = $this->obtener_consultores_co_usuario($co_usuario);

          if (isset($consultores) && $consultores['status'] == 200)
          {

          	$listado = array();
			foreach ($consultores['data'] as $indice => $consultor) {

				$datos = array('co_usuario' => $consultor['co_usuario'],
							   'no_usuario' => $consultor['no_usuario']);

				array_push($listado,$datos);
			}
          }
			$respuesta = $listado;
		}

    	return $respuesta;		
	}

	// --------------------------------------------------------------------    

	/**
	 * 
	 *uery_ordenes_servicios
	 * 	 	
	 * Esta funcion selecciona todas las os en la base de datos
	 * por sus llaves correspondientes al consultor	 
	 *
	 * @param array $co_usuario
	 * @return array $respuesta
	 */
    private function query_ordenes_servicios($co_usuario){

    	$respuesta = false;

		try {

			$this->db->select('cao_os.co_os');
			$this->db->select('cao_os.co_usuario');
			$this->db->from('cao_os');
			$this->db->where('cao_os.co_os is NOT NULL', NULL, FALSE);
			$this->db->where_in('cao_os.co_usuario',$co_usuario);
			$this->db->order_by("cao_os.co_usuario", "asc");				

			$query = $this->db->get();

		    if ($query && $query->num_rows() > 0)
		    {
				$respuesta = $query->result_array();

		    }else{

		      throw new Exception('Error al intentar listar las ordenes de servicio del consultor');

		      $respuesta = false;				
			}

		} catch (Exception $e) {

			$respuesta = false;
		}			

		return $respuesta;
    }

	// --------------------------------------------------------------------

	/**
	 * 
	 * obtener_ordenes_servicios
	 * 	 	
	 * Esta funcion obtiene todos los os de los consultores en el sistema
	 * y formatea la respuesta
	 *
	 * @return array (status, data, message)
	 */
	// --------------------------------------------------------------------
    public function obtener_ordenes_servicios($co_usuario)
    {
    	$query = $this->query_ordenes_servicios($co_usuario);

		if($query)
		{
			return formatear_respuesta($query, 'Lista de ordenes de servicio', 200);

		}else{

			return formatear_respuesta('No se pudo obtnener las ordenes de servicio', 404);
		}
    }  


	// --------------------------------------------------------------------

	/**
	 * 
	 * listado_ordenes_servicios_co_usuario(
	 * 	 	
	 * Esta funcion selecciona todas los os asociadas a un consultor
	 * 	 
	 * @param array $co_usuario	 
	 * @return string $respuesta
	 */
	public function listado_ordenes_servicios_co_usuario($co_usuario){

    	$respuesta = false;

		if ($co_usuario && !empty($co_usuario))
		{
			$query = $this->obtener_ordenes_servicios($co_usuario);

          	if (isset($query) && $query['status'] == 200)
          	{
          		$query = $query['data'];
		      	$listado = array();

				foreach ($co_usuario  as $k1 => $v1) 
				{ 	
					if (! in_array($v1, array_column($query, 'co_usuario')) )
					{
						$datos  = array('co_os' => null, 
							       'co_usuario' => $v1);
						array_push($listado, $datos);		
					}	
				}

				$respuesta = array_merge($query, $listado);		
          	}		
		}
    	return $respuesta;		
	}

	// --------------------------------------------------------------------

	/**
	 * 
	 * query_fecha_minima_factura
	 * 	 	
	 * Esta funcion selecciona la factura con la 
	 * fecha mas antigua de la base de datos
	 * 	 
	 * @return string $respuesta
	 */
    private function query_fecha_minima_factura(){

    	$respuesta = false;

		try {

   			$this->db->select_min('cao_fatura.data_emissao');
			$this->db->from('cao_fatura');		

			$query = $this->db->get();

		    if ($query && $query->num_rows() > 0)
		    {
				$respuesta = $query->result_array();

		    }else{

		      throw new Exception('Error al intentar obtener la factura de menor fecha');

		      $respuesta = false;				
			}

		} catch (Exception $e) {

			$respuesta = false;
		}			

		return $respuesta;
    }

	// --------------------------------------------------------------------

	/**
	 * 
	 * obtener_fecha_minima_factura
	 * 	 	
	 * Esta funcion obtiene la fecha de la factura con menor antiguedad
	 *
	 * @return array (status, data, message)
	 */
    public function obtener_fecha_minima_factura()
    {
    	$query = $this->query_fecha_minima_factura();

		if($query)
		{
			return formatear_respuesta($query, 'Fecha minima de factura', 200);

		}else{

			return formatear_respuesta('No se pudo obtnener la fecha minima de factura', 404);
		}
    }

	// --------------------------------------------------------------------

	/**
	 * 
	 * menor_data_emissao
	 * 	 	
	 * Esta funcion obtiene la fecha de la factura con menor antiguedad
	 *
	 * @return inte $respuesta
	 */
    public function menor_data_emissao()
    {

    	$respuesta = false;
		$factura = $this->obtener_fecha_minima_factura();

          if (isset($factura) && $factura['status'] == 200)
          {
			$respuesta = $factura['data'][0]["data_emissao"];
          }		
	
    	return $respuesta;
    }

}