<?php

use GuzzleHttp\Client;

class Input_type_model extends CI_Model {
	/**
	 * Variables para el rest client
	 * @var string
	 */
	private $base_uri 	= 'http://demo2175273.mockable.io/input_type';
	private $client;
	
	/**
	 * Variables para los atributos del modelo
	 * @var string
	 */
	public $id;
	public $code;
	public $name;
	public $description;
	
	public function __construct()
	{
		$this->client = new Client([
			// Base URI is used with relative requests
			'base_uri' => $base_uri,
			// You can set any number of default request options.
			'timeout'  => 2.0,
			]);
	}
	
	/**
	 * Consulta de tipo de insumo
	 * 
	 * Consulta personas por cuil o devuelve toda la tabla
	 * @param 		string 		$name
	 * @return 		mixed 		array Devuelve un array
	 */
	public function consulta($name=NULL)
	{
		$response = $client->request('GET', 'input_type');
		$body = $response->getBody();
		echo $body;
	}
	
	/**
	 * Alta de tipo de insumo
	 * @param		object	$persona
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function alta($persona)
	{	
		if($this->db->query($this->sp_alta, 
				array(
						'cuil' 		=> $persona->cuil, 
						'Nombre' 	=> $persona->nombre, 
						'Apellido' 	=> $persona->apellido, 
						'Mail' 		=> $persona->mail))
				)
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
	
	/**
	 * Edicion de tipo de insumo
	 * @param		object	$persona
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function editar($persona)
	{
		if($this->db->query($this->sp_editar, 
				array(
						'cuil' 		=> $persona->cuil, 
						'Nombre' 	=> $persona->nombre, 
						'Apellido' 	=> $persona->apellido, 
						'Mail' 		=> $persona->mail))
				)
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
	
	/**
	 * Baja de tipo de insumo
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function baja($cuil = FALSE)
	{
		if($query = $this->db->query($this->sp_baja, array('cuil' => $cuil)))
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
}