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
			  log_message('error', 'Error al intentar listar todos los consultores');		      

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
			  log_message('error', 'Error al intentar listar los consultores por sus co_usuario');		      

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
			  log_message('error', 'Error al intentar listar las ordenes de servicio del consultor');			      

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
			  log_message('error', 'Error al intentar obtener la factura de menor fecha');		      

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

	// --------------------------------------------------------------------

	/**
	 * 
	 * query_facturas_ordenes_servicios_usuario
	 * 	 	
	 * Esta funcion selecciona todas las facturas asociadas a las ordenes
	 * de servicio de cada uno de los consultor en un determinado 
	 * mes de referencia
	 *
	 * @param array $co_usuario 
	 * @param date $fecha_inicio
	 * @param date $fecha_fin	 	 
	 * @return array $respuesta
	 */
    private function query_facturas_ordenes_servicios_usuarios($co_usuario, 
    														   $fecha_inicio, 
    														   $fecha_fin)
    {
    	$respuesta = false;

		try {

			$this->db->select('cao_fatura.co_os');
			$this->db->select('cao_fatura.co_fatura');			
			$this->db->select('cao_fatura.valor');			
			$this->db->select('cao_fatura.data_emissao');
			$this->db->select('cao_fatura.comissao_cn');
			$this->db->select('cao_fatura.total_imp_inc');
			$this->db->select('cao_usuario.co_usuario');
			$this->db->from('cao_fatura');
			$this->db->join('cao_os', 'cao_os.co_os = cao_fatura.co_os');
			$this->db->join('cao_usuario', 'cao_usuario.co_usuario = cao_os.co_usuario');
			$this->db->where('cao_fatura.co_os is NOT NULL', NULL, FALSE);
			$this->db->where('cao_fatura.co_fatura is NOT NULL', NULL, FALSE);			
			$this->db->where('cao_fatura.data_emissao >=', $fecha_inicio);
			$this->db->where('cao_fatura.data_emissao <=', $fecha_fin);
			$this->db->where_in('cao_os.co_usuario',$co_usuario);		
			$this->db->order_by("cao_fatura.data_emissao", "asc");

			$query = $this->db->get();

		    if ($query && $query->num_rows() > 0)
		    {
				$respuesta = $query->result_array();

		    }else{

		      throw new Exception('Error al intentar listar las facturas asociadas a los consultores');
			  log_message('error', 'Error al intentar listar las facturas asociadas a los consultores');			      

		      $respuesta = false;				
			}

		} catch (Exception $e) {

			$respuesta = false;
		}			

		return $respuesta;
    }


	// --------------------------------------------------------------------   

    public function obtener_facturas_ordenes_servicios_usuario($co_usuario, 
    														   $fecha_inicio, 
    														   $fecha_fin)
    {
    	$query = $this->query_facturas_ordenes_servicios_usuarios($co_usuario, $fecha_inicio, $fecha_fin);

		if($query)
		{
			return formatear_respuesta($query, 'AAA', 200);

		}else{

			return formatear_respuesta('AAA', 404);
		}
    }  

	// --------------------------------------------------------------------

	/**
	 * 
	 * listado_facturas_ordenes_servicios_usuario
	 * 	 	
	 * Esta funcion obtienen todas las facturas asociadas a las ordenes
	 * de servicio de cada uno de los consultor en un determinado 
	 * mes de referencia y las formatea
	 *
	 * NOTA: Si existe el caso para el cual no exista una factura asociada 
	 * a un consultor o no exista orden de servicio se manejan con 
	 * arreglos vacios
	 *
	 * @param array $co_usuario 
	 * @param date $fecha_inicio
	 * @param date $fecha_fin	 	 
	 * @return array $respuesta
	 */
	public function listado_facturas_ordenes_servicios_usuario($co_usuario, 
    														   $fecha_inicio, 
    														   $fecha_fin){
    	$respuesta = false;

		if ($co_usuario && !empty($co_usuario))
		{
			$query = $this->obtener_facturas_ordenes_servicios_usuario($co_usuario, 
				 													   $fecha_inicio, 
				 													   $fecha_fin);
          	if (isset($query) && $query['status'] == 200)
          	{
          		$query = $query['data'];
		      	$listado = array();

				foreach ($co_usuario  as $k1 => $v1) 
				{ 	
					if (! in_array($v1, array_column($query, 'co_usuario')) )
					{
						$datos  = array('co_os' => null,
									    'co_fatura' => null,
									    'valor' => '0',
									    'data_emissao' => '0000-00-00',
									    'comissao_cn' => '0',
									    'total_imp_inc' => '0',
									    'co_usuario' => $v1
									   );
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
	 * facturas_agrupadas_consultores
	 * 	 	
	 * Esta funcion agrupa por consultor cada una 
	 * de las facturas
	 * 
	 *
	 * @param array $factura 
	 * @param array $co_usuario 	 	 
	 * @return array $respuesta
	 */
    public function facturas_agrupadas_consultores($factura, $co_usuario){

    	$respuesta = false;

		if( $factura )
	    {
			$agrupado = array();

			foreach ($co_usuario as $k1 => $v1) 
			{ 
				$elementos = array();				
				
				foreach ($factura as $k2 => $v2) 
				{
					if ( strcmp ($v1, $v2['co_usuario'] ) == 0 )
					{

						// Se formatea la fecha m-Y "IMPORTANTE"
						$fecha = formatear_fecha($v2['data_emissao']);

						$items = array ('co_fatura' => $v2['co_fatura'],
										    'co_os' => $v2['co_os'],
										    'valor' => $v2['valor'],
								     'data_emissao' => $fecha,
									  'comissao_cn' => $v2['comissao_cn'],								     
								    'total_imp_inc' => $v2['total_imp_inc']);

						array_push($elementos,$items);
					}

					$agrupado[$k1] = array ( 'co_usuario' => $v1,
											     'fatura' => $elementos );						
				}
			}

			$respuesta = $agrupado;			
		}

	    return $respuesta;
    }

	// --------------------------------------------------------------------    

	/**
	 * 
	 * fechas_agrupadas_consultores
	 * 	 	 
	 * Esta funcion agrupa por periodo cada una
	 * de las facturas de los consultores
	 * 
	 *
	 * @param array $factura 	 
	 * @return array $respuesta
	 */
    public function fechas_agrupadas_consultores($factura, $co_usuario){

    	$respuesta = false;

		if( $factura )
	    {
			$agrupado = array();

			foreach ($factura as $k1 => $v1) 
			{ 
				$elementos = array();				
				
				foreach ($v1['fatura'] as $k2 => $v2) 
				{
					array_push($elementos,$v2['data_emissao']);
				}
				
				$agrupado[$k1] = array ( 'co_usuario' => $v1['co_usuario'],
										 'data_emissao' => array_values( 
										 	               array_unique( $elementos ) ) );
			}

			$respuesta = $agrupado;				
		}

	    return $respuesta;
    }

	// --------------------------------------------------------------------    

	/**
	 * 
	 * query_costo_fijo
	 *
	 * @return array (status, data, message)
	 */
    public function query_costo_fijo($co_usuario){

    	$respuesta = false;

		try {

			$this->db->select('cao_salario.co_usuario');
			$this->db->select('cao_salario.brut_salario');																	
			$this->db->from('cao_salario');
			$this->db->where('cao_salario.co_usuario is NOT NULL', NULL, FALSE);						
			$this->db->where_in('cao_salario.co_usuario', $co_usuario);			

			$query = $this->db->get();

		    if ($query && $query->num_rows() > 0)
		    {
				$respuesta = $query->result_array();
		    }else{

		      throw new Exception('Error al intentar listar el costo fijo del consultor');
			  log_message('error', 'Error al intentar listar el costo fijo del consultor');		      
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
	 * obtener_costo_fijo
	 * 	 	
	 * Esta funcion solicita los consultores en el sistema
	 * por su llave correspondiente y formatea la respuesta
	 *
	 * @param array $co_usuario
	 * @return array (status, data, message)
	 */
    public function obtener_costo_fijo($co_usuario)
    {
    	$query = $this->query_costo_fijo($co_usuario);

		if($query)
		{
			return formatear_respuesta($query, 'Lista completa de costos fijos por sus co_usuario', 200);

		}else{

			return formatear_respuesta('No se pudieron listar los costos fijos por sus co_usuario', 404);
		}
    }  

	// --------------------------------------------------------------------

	/**
	 * 
	 * listado_costo_fijo
	 * 	 	
	 * Esta funcion intersecta los consultores solicitados
	 * con los que se encuentra en el sistema
	 * para evitar datos inexistentes
	 *	 
	 * @param array $co_usuario
	 * @return array $co_usuario
	 */
	public function listado_costo_fijo($co_usuario){

    	$respuesta = false;

		if ($co_usuario && !empty($co_usuario))
		{

			$query = $this->obtener_costo_fijo($co_usuario);

          	if (isset($query) && $query['status'] == 200)
          	{
          		$query = $query['data'];
		      	$listado = array();

				foreach ($co_usuario  as $k1 => $v1) 
				{ 	
					if (! in_array($v1, array_column($query, 'co_usuario')) )
					{
						$datos  = array('brut_salario' => 0,
									    'co_usuario' => $v1
									   );
						array_push($listado, $datos);		
					}	
				}
				$respuesta = array_merge($query, $listado);			
      
          	}else{
				    $listado = array();
					foreach ($co_usuario as $k1 => $v1) 
					{
						$datos  = array('brut_salario' => 0,
									    'co_usuario' => $v1
									   );									    
						array_push($listado, $datos);			
					}

				$respuesta = $listado;
			}
		}

    	return $respuesta;		
	}

	// --------------------------------------------------------------------    

	/**
	 * 
	 * calcular_valor_neto
	 * 	 	 
	 * Esta funcion calcula el porcentaje del valor asignado
	 * Para obtener el tanto por ciento se contruye una regla de 3 simple 
	 * 
	 *
	 * @param float $valor 	
	 * @param float $total_imp_inc
	 * @return float
	 */
    private function calcular_valor_neto(float $valor, float $total_imp_inc){
    	return round( $valor - ( ( $valor * $total_imp_inc ) / 100 ) , 3 );
    }

	// --------------------------------------------------------------------    

	/**
	 * 
	 * calcular_ganancia_neta
	 * 	 	 
	 * Esta funcion acumula las ganancia netas a partir de 
	 * la suma de las facturas emitidas
	 * 
	 *
	 * @param float $valor 	
	 * @param float $total_imp_inc
	 * @return float;
	 */
    private function calcular_ganancia_neta($valor_incremento, $valor_neto){
    	return round( $valor_incremento + $valor_neto , 3 );
    }

	// --------------------------------------------------------------------   

	/**
	 * 
	 * calcular_valor_comision
	 * 	 	 
	 * Esta funcion calcula el valor de la comision
	 * del mes de referencia
	 * 
	 *
	 * @param float $valor_neto
	 * @param float $total_imp_inc
	 * @param float $comissao_cn
	 * @return float $valor;
	 */
    private function calcular_valor_comision($valor_neto, $total_imp_inc, $comissao_cn){
    	$porcentaje_total_imp_inc = ( ( $valor_neto * $total_imp_inc ) / 100 );
    	$valor = $valor_neto - $porcentaje_total_imp_inc;
		$valor = ( ( $valor * $comissao_cn ) / 100 );
    	return round( $valor, 3 );
    }

	// --------------------------------------------------------------------   

	/**
	 * 
	 * calcular_beneficios
	 * 	 	 
	 * Esta funcion calcula el valor de los beneficios
	 * del mes de referencia
	 * 
	 *
	 * @param float $valor_neto
	 * @param float $total_imp_inc
	 * @param float $comissao_cn
	 * @return float
	 */
    private function calcular_beneficios($ganancias_netas, $costo_fijo, $comision){
    	return round( $ganancias_netas - ( $costo_fijo + $comision ) , 3 );
    }

	// --------------------------------------------------------------------   

	/**
	 * 
	 * costo fijo
	 * 	 	 
	 * Esta funcion seleciona el costo fijo
	 * segun el consultor 
	 * 
	 *
	 * @param float $valor_neto
	 * @param float $total_imp_inc
	 * @param float $comissao_cn
	 * @return float
	 */
    private function costo_fijo($costo_fijo, $co_usuario){
    	foreach ($costo_fijo as $k1 => $v1)
    	{
    		if ( $co_usuario ==  $v1['co_usuario'])
    		{
    			$respuesta = $v1['brut_salario'];
    			break;
    		}
    	}
    	return $respuesta;
    }

	// --------------------------------------------------------------------    

	/**
	 * 
	 * procesar_relatorio
	 * 	 	 
	 * Esta funcion procesa los resultados para cada uno de los 
	 * consultores a parir de la relacion entre las facturas y las 
	 * fechas de emision de las ordenes de servicio de cada uno
	 *
	 * @param array $fechas
	 * @param array $factura
	 * @param array $co_usuario
	 * @return array $respuesta
	 */
    public function procesar_relatorio($factura, $consultores, $costo_fijo, $co_usuario){
    	$respuesta = false;
		if( $factura && $consultores && $co_usuario && $costo_fijo);
	    {
			// Se hacen cero todos los totales
			$total_ganacias_netas = 0;
			$total_costo_fijo = 0;
			$total_comision = 0;
			$total_beneficio = array();

			// return resumen
			$resumen = array();
			// Para obtener los nombres completos
			$listado_nombre = $this->listado_no_usuario($co_usuario);				    	

			// facturas agrupadas consultor-fecha	
			foreach ($consultores as $i_consultor => $v_consultor) 
			{
				// arreglo relatorio
				$l_relatorio = array();
				$total_beneficio = array();
				$fijo = 0;
				$nombre = '';

				// COSTO FIJO (Custo Fixo)
				$fijo = $this->costo_fijo($costo_fijo, $v_consultor['co_usuario']);

				// COSTO FIJO (Custo Fixo)	
				if ($listado_nombre[$i_consultor]['co_usuario'] == $v_consultor['co_usuario']) 
				{
					$nombre = $listado_nombre[$i_consultor]['no_usuario'];
				}				

				// facturas agrupadas por fechas	
				foreach ($v_consultor['data_emissao'] as $i_periodo => $v_periodo) 
				{
					// se hacen cero
					$ganancias_netas = 0;
					$comision = 0;

					$total_ganacias_netas = 0;
					$total_costo_fijo = 0;
					$total_comision = 0;

					// lista de todas las facturas del consultor
					$lista_facturas = $factura[$i_consultor]['fatura'];
					
					// facturas
					foreach ($lista_facturas as $i_factura => $v_factura) 
					{
						// CALCULO DE GANACIAS NETAS ( Receita Liquida )
						$valor_neto = $this->calcular_valor_neto($v_factura['valor'],
																 $v_factura['total_imp_inc']);
						// CALCULO DE COMISIONES ( Comissão )
						$valor_comision = $this->calcular_valor_comision( $v_factura['valor'],
																		  $v_factura['total_imp_inc'],
																		  $v_factura['comissao_cn']);
					   	// FACTURAS DEL MISMO PERIODO 
						if ($v_factura["data_emissao"] == $v_periodo)
						{						
							// GANACIAS NETAS ( Receita Liquida )
							$ganancias_netas = $this->calcular_ganancia_neta( $ganancias_netas, $valor_neto );	
							// se suman todas las comisiones por mes de referencia
							$comision = ($comision + $valor_comision);
							// CALCULO DE BENEFICIO (Lucro)
							$beneficio = $this->calcular_beneficios($ganancias_netas, $fijo, $comision);					
							// total beneficios
							$total_beneficio[$i_periodo] = $beneficio;
						   	// relatorio
						   	$l_relatorio[$i_periodo] = array('periodo' => $v_factura["data_emissao"],
						   							    'ganacia-neta' => round($ganancias_netas, 3),
						   								  'costo-fijo' => round($fijo, 3),
						   								    'comision' => round($comision, 3),
						   								   'beneficio' => round($beneficio, 3)
						   								);
						}
						// FIN FACTURAS DEL MISMO PERIODO 

							// se suman todas las ganacias netas
							$total_ganacias_netas = ( $total_ganacias_netas + $valor_neto);

							// se suman todas las comisiones
							$total_comision = ( $total_comision + $valor_comision );
					}
					// fin facturas 

					// se suman todos los costos fijos
					$total_costo_fijo = ($fijo * ($i_periodo+1));						
				}
				// fin facturas agrupadas por fechas					

			// Se agrega el bloque completo de acuerdo al indice fecha del consultor
			$resumen[$i_consultor]['co_usuario'] = $v_consultor['co_usuario'];
			$resumen[$i_consultor]['no_usuario'] = $nombre;				 
			$resumen[$i_consultor]['periodos'] = $l_relatorio;
			$resumen[$i_consultor]['ganancias-netas'] = round( $total_ganacias_netas, 3);
			$resumen[$i_consultor]['costo-fijo'] = round( $total_costo_fijo, 3);
			$resumen[$i_consultor]['comision'] = round( $total_comision, 3);
			$resumen[$i_consultor]['beneficio'] = round( array_sum($total_beneficio), 3);	
			$resumen[$i_consultor]['estado'] = $v_factura['co_fatura'];

			$total_ganacias_netas = 0;
			$total_costo_fijo = 0;
			$total_comision = 0;

			}
			// fin facturas agrupadas consultor-fecha		

		$respuesta = $resumen;
		}
	 return $respuesta;
    }

	// --------------------------------------------------------------------   

	/**
	 * 
	 * periodo
	 * 	 	 
	 * Esta funcion muestra el periodo selecionado de 
	 * forma amigable en una cadena
	 *
	 * @param string $fecha_inicio
	 * @param string $fecha_fin
	 * @return string $respuesta
	 */
    public function periodo($fecha_inicio, $fecha_fin){
		$fecha_inicio = formatear_fecha($fecha_inicio);
		$fecha_fin = formatear_fecha($fecha_fin);
		return ('Desde ('.$fecha_inicio.') hasta ('.$fecha_fin.')');
	}

}