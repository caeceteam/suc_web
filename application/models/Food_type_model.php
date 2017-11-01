<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Food_type_model extends CI_Model {
	/**
	 * Variables para el rest client
	 * @var string
	 */
	private $base_uri;
	private $client;
	private $timeout;
	
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
		$this->config->load('api');
		$this->base_uri = $this->config->item('api_base_uri');
		$this->timeout	= $this->config->item('api_timeout');
		$this->client  	= new Client([
			'headers' => ['x-access-token' => $this->session->token],//Se agrega el header con los datos de la session
			'base_uri' 	=> $this->base_uri,
			'timeout'  	=> $this->timeout,
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
	 * Consulta de tipos de insumos by id
	 * @param 	int 	$id
	 */
	public function search_by_id($id)
	{
		$url = 'api/foodtypes/' . $id;
		return $this->search($url);
	}
	
	/**
	 * Consulta de tipos de insumos por p�gina para el listado
	 * @param 	string 	$page
	 */
	public function get_foodtypes_by_page($page)
	{
		//$url = 'api/foodtypes?page=' . $page;
		return $this->search();
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
	 * Edici�n de input type
	 * @param		object	$food_type
	 * @return 		array   Si la edici�n fue exitosa, devuelve un array con el input type, sino devuelve NULL
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
	 * @return 		bool   Si la baja fue exitosa, devuelve TRUE
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