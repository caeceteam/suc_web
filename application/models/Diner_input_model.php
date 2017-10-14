<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\ServerException;

class Diner_input_model extends CI_Model {
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
			'headers' => ['x-access-token' => $this->session->token],//Se agrega el header con los datos de la session
			'base_uri' 	=> $this->base_uri,
			'timeout'  	=> $this->timeout,
			]);
	}
	
	/**
	 * Consulta de tipo de insumo
	 * 
	 * Consulta de insumos a la API
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
	 * Consulta de insumos by id
	 * @param 	int 	$id
	 */
	public function search_by_id($id)
	{
		$url = 'api/dinerinputs/' . $id;
		return $this->search($url);
	}
	
	/**
	 * Consulta de insumos por página para el listado
	 * @param 	string 	$page
	 */
	public function get_dinerinputs_by_page($page)
	{
		$url = 'api/dinerinputs?page=' . $page;
		return $this->search($url);
	}
		
	/**
	 * Alta de diner input
	 * @param		object	$diner_input
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el diner input, sino devuelve NULL
	 */		
	public function add($diner_input)
	{
		try {
			$response = $this->client->request('POST', 'api/dinerinputs', [
				'json' => $diner_input
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
	 * Edición de diner input
	 * @param		object	$diner_input
	 * @return 		array   Si la ediciÃ³n fue exitosa, devuelve un array con el diner input, sino devuelve NULL
	 */
	public function edit($diner_input)
	{
		try {
			$response = $this->client->request('PUT', 'api/dinerinputs/' . $diner_input->id, [
					'json' => $diner_input
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
	 * Delete de diner input
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve TRUE
	 */
	public function delete($id)
	{
		$response = $this->client->request('DELETE', 'api/dinerinputs/' . $id);
		if($response->getStatusCode()==HTTP_OK)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
};

