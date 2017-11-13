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
 * Comunes
 *
 * Helpers de funciones comunes utilizadas en los controladores
 * o en los modelos si se requieren
 *
 * @package	   prototipo-agence
 * @category   Helpers
 * @author	   Álvaro Güette
 * @link	   http://agence.guettsoft.com/
 */

// ------------------------------------------------------------------------

if ( ! function_exists('formatear_respuesta'))
{
	/**
	 * 
	 * formatear_respuesta
	 * 	 	 
	 * Esta funcion formatea una respueta en forma de array
	 *
	 * @param string $data
	 * @param string $message
	 * @param int $status	 
	 * @return array (status, data, message)
	 */
	function formatear_respuesta($data='', $message='', $status='')
	{
        return array("status" => $status,
                     "data" => $data,
                     "message" => $message);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('formatear_fecha'))
{
	/**
	 * 
	 * formatear_fecha
	 * 	 	 
	 * Esta funcion determina formatea una cadena fecha
	 *
	 * @param string $date
	 * @param string $formato
	 * @return string $respuesta
	 */
	function formatear_fecha($date, $formato='m-Y')
	{
		$fecha = new DateTime($date);
		return $fecha->format($formato);
	}
}

// -------------------------------------------------------------------- 

if ( ! function_exists( 'verificar_periodo' ) )
{
	/**
	 * 
	 * verificar_periodo
	 * 	 	 
	 * Esta funcion determina si el rango es valido para el 
	 * periodo a consultar 
	 * 
	 * @param string $fechas_inicio
	 * @param stering $fecha_fin
	 * @return bool $respuesta
	 */
    function verificar_periodo($fecha_inicio, $fecha_fin){

    	$respuesta = false;

    	if ( !empty( $fecha_inicio ) && !empty( $fecha_fin ) )
    	{
			$fecha_inicio = new DateTime( $fecha_inicio );
			$fecha_fin = new DateTime( $fecha_fin );

	    	$respuesta = ( $fecha_inicio <= $fecha_fin ) ? true : false;
    	}

    	return $respuesta;
    }
}