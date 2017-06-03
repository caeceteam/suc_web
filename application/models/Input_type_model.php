<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Input_type_model extends CI_Model {
	/**
	 * Variables para el rest client
	 * @var string
	 */
	private $base_uri 	= 'http://localhost:3000';
	private $client;
	private $timeout = 5.0;
	
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
		parent::__construct();
		$this->client = new Client([
			'base_uri' => $this->base_uri,
			'timeout'  => $this->timeout,
			]);
	}
	
	/**
	 * Consulta de tipo de insumo
	 * 
	 * Consulta tipos de insumo por id o devuelve toda la tabla
	 * @param 		string 		$id
	 * @return 		array 		Devuelve un array
	 */
	public function search($id=NULL)
	{
		$response = $this->client->request('GET', 'api/inputtypes');
		if($response->getStatusCode()==HTTP_OK)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
	}
	
	/**
	 * Alta de input type
	 * @param		object	$input_type
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function add($input_type)
	{
		$response = $this->client->request('POST', 'api/inputtypes', [
				    'json' => $input_type
					]);
		if($response->getStatusCode()==HTTP_CREATED)
		{
			$resultado['resultado']='OK';
			//$resultado['id']=$query->row_array()["id_torneo"];
		}
		else{
			$resultado['resultado']='ERROR';
		}
		return $resultado;
	}
}