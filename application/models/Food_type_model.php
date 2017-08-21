<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Food_type_model extends CI_Model {
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
	public $perishable;
	
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
	 * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
	 */
	public function search($id=NULL)
	{
		$response = $this->client->request('GET', $id != NULL ? 'api/foodtypes/' . $id : 'api/foodtypes/');
		if($response->getStatusCode()==HTTP_OK)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
		else
			return NULL;
	}
	
	/**
	 * Alta de input type
	 * @param		object	$food_type
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el input type, sino devuelve NULL
	 */
	public function add($food_type)
	{
		$response = $this->client->request('POST', 'api/foodtypes', [
				    'json' => $food_type
					]);
		if($response->getStatusCode()==HTTP_CREATED)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
		else
			return NULL;
	}
	
	/**
	 * Edición de input type
	 * @param		object	$food_type
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el input type, sino devuelve NULL
	 */
	public function edit($food_type)
	{
		$response = $this->client->request('PUT', 'api/foodtypes/' . $food_type->id, [
				    'json' => $food_type
					]);
		if($response->getStatusCode()==HTTP_ACCEPTED)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
		else
			return NULL;
	}
	
	/**
	 * Delete de input type
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve un array con el input type, sino devuelve NULL
	 */
	public function delete($id)
	{
		$response = $this->client->request('DELETE', 'api/foodtypes/' . $id);
		if($response->getStatusCode()==HTTP_OK)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
};