<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

class Input_type_model extends CI_Model {
	/**
	 * Variables para el rest client
	 * @var string
	 */
	private $base_uri;
	private $client;
	private $timeout;
	
	public function __construct()
	{
		parent::__construct();
		$this->config->load('api');
		$this->base_uri = $this->config->item('api_base_uri');
		$this->timeout	= $this->config->item('api_timeout');
		$this->client   = new Client([
			'base_uri' 	=> $this->base_uri,
			'timeout'  	=> $this->timeout,
			]);
	}
	
	/**
	 * Consulta de tipo de insumo
	 * 
	 * Consulta de tipos de insumo a la API
	 * @param 		string 		$url
	 * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
	 */
	private function search($url)
	{
		$response = $this->client->request('GET', $url);		
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
		$url = 'api/inputtypes/' . $id;
		return $this->search($url);
	}
	
	/**
	 * Consulta de tipos de insumos por página y búsqueda para el listado
	 * @param 	string 	$page
	 * 			string	$searchTxt
	 */
	// TODO: Cambiar búsqueda por name por búsqueda genérica
	public function get_inputtypes_by_page_and_search($page, $searchTxt)
	{
		$url = 'api/inputtypes?page=' . $page . '&code=' . $searchTxt;
		return $this->search($url);
	}
		
	/**
	 * Alta de input type
	 * @param		object	$input_type
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el input type, sino devuelve NULL
	 */		
	public function add($input_type)
	{
		try {
			$response = $this->client->request('POST', 'api/inputtypes', [
				'json' => $input_type
			]);
			if($response->getStatusCode()==HTTP_CREATED)
			{
				$body = $response->getBody();
				return json_decode($body,TRUE);
			}
			return NULL;
		}
		catch (ServerException $e) {
			return $this->errorMessage($e);
		}
	}
	
	/**
	 * EdiciÃ³n de input type
	 * @param		object	$input_type
	 * @return 		array   Si la ediciÃ³n fue exitosa, devuelve un array con el input type, sino devuelve NULL
	 */
	public function edit($input_type)
	{
		try {
			$response = $this->client->request('PUT', 'api/inputtypes/' . $input_type->id, [
					'json' => $input_type
			]);
			if($response->getStatusCode()==HTTP_ACCEPTED)
			{
				$body = $response->getBody();
				return json_decode($body,TRUE);
			}
			else
				return NULL;
		}
		catch (Exception $e) {
			return $this->errorMessage($e);
		}
	}
	
	/**
	 * Función que mapea el mensaje de error desde la API usado en los editores
	 * @param 	exception $exceptionData
	 */
	private function errorMessage($exceptionData) 
	{
		$errorResponse = json_decode($exceptionData->getResponse()->getBody(), TRUE);
		$errorResponse['errors'] = TRUE;
		if($exceptionData->getCode() == 500)
		{
			return $errorResponse;
		}
		return NULL;
	}
	
	/**
	 * Delete de input type
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve un array con el input type, sino devuelve NULL
	 */
	public function delete($id)
	{
		$response = $this->client->request('DELETE', 'api/inputtypes/' . $id);
		if($response->getStatusCode()==HTTP_OK)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
};

