<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

class Food_type_model extends CI_Model {
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
			'timeout'  	=> $this->timeout
			]);
	}
	
	/**
	 * Consulta de tipo de alimento
	 * 
	 * Consulta de tipos de alimento a la API
	 * @param 		string 		$url
	 * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
	 */
	private function search($url)
	{  try{
		$response = $this->client->request('GET', $url);		
	   }catch(Exception $e){
	       return NULL;
	   }
		if($response->getStatusCode()==HTTP_OK)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
		else
			return NULL;		
	}
	
	/**
	 * Consulta de tipos de foodtypes by id
	 * @param 	int 	$id
	 */
	public function search_by_id($id)
	{
		$url = 'api/foodtypes/' . $id;
		return $this->search($url);
	}
	
	/**
	 * Consulta de tipos de alimento por p�gina y b�squeda para el listado
	 * @param 	string 	$page
	 * 			string	$searchTxt
	 */
	// TODO: Cambiar b�squeda por name por b�squeda gen�rica
	public function get_foodtypes_by_page_and_search($page, $searchTxt)
	{
		$url = 'api/foodtypes?page=' . $page . '&name=' . $searchTxt;
		return $this->search($url);
	}

	/**
	* Consulta de tipos de alimento por p�a�gina y b�squeda para el listado
	* @param 	string 	$page
	* 			string	$searchTxt
	*/
	// TODO: Cambiar b�squeda por name por b�squeda gen�rica
	public function get_foodtypes_by_page($page)
	{
		$url = 'api/foodtypes?page=' . $page;
		return $this->search($url);
	}	
	
	/**
	 * Alta de food type
	 * @param		object	$food_type
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el food type, sino devuelve NULL
	 */		
	public function add($food_type)
	{
		try {
			$response = $this->client->request('POST', 'api/foodtypes', [
				'json' => $food_type
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
	 * Edici�n de food type
	 * @param		object	$food_type
	 * @return 		array   Si la edici�n fue exitosa, devuelve un array con el food type, sino devuelve NULL
	 */
	public function edit($food_type)
	{
		try {
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
		catch (Exception $e) {
			return $this->errorMessage($e);
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
		if($exceptionData->getCode() == HTTP_INTERNAL_SERVER)
		{
			return $errorResponse;
		}
		return NULL;
	}
	
	/**
	 * Delete de food type
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve TRUE
	 */
	public function delete($id)
	{
		$response = $this->client->request('DELETE', 'api/foodtypes/' . $id);
		if($response->getStatusCode()==HTTP_OK  || $response->getStatusCode()==HTTP_NO_CONTENT)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
};

