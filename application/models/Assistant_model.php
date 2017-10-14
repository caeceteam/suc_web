<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

class Assistant_model extends CI_Model {
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
	public $idDiner;
	public $name;
	public $surname;
	public $bornDate;
	public $street;
	public $streetNumber;
	public $floor;
	public $door;
	public $zipcode;
	public $phone;
	public $contactName;
	public $scholarship;
	public $eatAtOwnHouse;
	public $economicSituation;
	public $celiac;
	public $diabetic;
	public $document;
	
	public function __construct()
	{
		parent::__construct();
		$this->client = new Client([
			'base_uri' => $this->base_uri,
			'timeout'  => $this->timeout,
			]);
	}
	
	/**
	 * Consulta asistentes
	 * 
	 * Consulta de asistentes a la API
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
	 * Consulta de concurrentes by id
	 * @param 	int 	$id
	 */
	public function search_by_id($id)
	{
		$url = 'api/assistants/' . $id;
		return $this->search($url);
	}
	
	/**
	 * Consulta de concurrentes por p�gina para el listado
	 * @param 	string 	$page
	 */
	public function get_assistants_by_page($page)
	{
		$url = 'api/assistants?page=' . $page;
		return $this->search($url);
	}
		
	/**
	 * Alta de concurrentes
	 * @param		object	$assistant
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el assistant, sino devuelve NULL
	 */		
	public function add($assistant)
	{
		try {
			$response = $this->client->request('POST', 'api/assistants', [
				'json' => $assistant
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
	 * Edici�n de concurrente
	 * @param		object	$assistant
	 * @return 		array   Si la edici�n fue exitosa, devuelve un array con el assistant, sino devuelve NULL
	 */
	public function edit($assistant)
	{
		try {
			$response = $this->client->request('PUT', 'api/assistants/' . $assistant->id, [
					'json' => $assistant
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
	 * Delete de concurrentes
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve un array con el assistant, sino devuelve NULL
	 */
	public function delete($id)
	{
		$response = $this->client->request('DELETE', 'api/assistants/' . $id);
		if($response->getStatusCode()==HTTP_OK)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
};

