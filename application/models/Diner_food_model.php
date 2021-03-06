<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\ServerException;

class Diner_food_model extends CI_Model {
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
		try{
			$response = $this->client->request('GET', $url);		
			if($response->getStatusCode()==HTTP_OK)
			{
				$body = $response->getBody();
				return json_decode($body,TRUE);
			}
			else
				return NULL;
		}
		catch (ServerException $e) {
			return $this->errorMessage($e);
		}
		catch(Exception $e)
		{
			return NULL;
		}
	}
	
	/**
	 * Consulta de insumos by id
	 * @param 	int 	$id
	 */
	public function search_by_id($id)
	{
		$url = 'api/dinerfoods/' . $id;
		return $this->search($url);
	}
	
	/**
	 * Consulta de insumos por p�gina para el listado
	 * @param 	string 	$page
	 */
	public function get_dinerfoods_by_page($page)
	{
		$url = 'api/dinerfoods?page=' . $page;
		return $this->search($url);
	}
	
	/**
	 * Consulta de insumos por p�gina para el listado
	 * @param 	string 	$page
	 */
	public function get_dinerfoods_by_page_and_searchTxt($page, $searchTxt)
	{
		$url = 'api/dinerfoods?page=' . $page . '&name=' . $searchTxt;
		return $this->search($url);
	}
		
	/**
	 * Alta de diner food
	 * @param		object	$diner_food
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el diner foods, sino devuelve NULL
	 */		
	public function add($diner_food)
	{
		try {
			$response = $this->client->request('POST', 'api/dinerfoods', [
				'json' => $diner_food
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
	 * Edici�n de diner food
	 * @param		object	$diner_food
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el diner food, sino devuelve NULL
	 */
	public function edit($diner_food)
	{
		try {
			$response = $this->client->request('PUT', 'api/dinerfoods/' . $diner_food->id, [
					'json' => $diner_food
			]);
			if($response->getStatusCode()==HTTP_ACCEPTED)
			{
				$body = $response->getBody();
				return json_decode($body,TRUE);
			}
			else
				return NULL;
		}
		catch (ServerException $e) {
			return $this->errorMessage($e);
		}
		catch (Exception $e)
		{
			return NULL;
		}
	}
	
	/**
	 * Funci�n que mapea el mensaje de error desde la API usado en los editores
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
	 * Delete de diner food
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve TRUE
	 */
	public function delete($id)
	{
		try {
			$response = $this->client->request('DELETE', 'api/dinerfoods/' . $id);
			if($response->getStatusCode()==HTTP_OK || $response->getStatusCode()==HTTP_NO_CONTENT)
			{
				return TRUE;
			}
			else
				return FALSE;
		}
		catch (ServerException $e) {
			return $this->errorMessage($e);
		}
		catch (Exception $e)
		{
			return NULL;
		}
	}
};

