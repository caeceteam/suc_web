<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Diner_model extends CI_Model {
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
	public $name;
	public $street;
	public $streetNumber;
	public $floor;
	public $door;
	public $latitude;
	public $longitude;
	public $zipCode;
	public $phone;
	public $description;
	public $link;
	public $mail;
	public $idCity;
	
	public function __construct()
	{
		parent::__construct();
		$this->config->load('api');
		$this->base_uri = $this->config->item('api_base_uri');
		$this->timeout	= $this->config->item('api_timeout');
		$this->client 	= new Client([
			'headers' => ['x-access-token' => $this->session->token],//Se agrega el header con los datos de la session
			'base_uri' 	=> $this->base_uri,
			'timeout'  	=> $this->timeout,
			]);
	}
	
	/**
	 * Consulta de comedores
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
			return json_decode($body, TRUE);
		}
		else
			return NULL;
	}
	
	/**
	 * Consulta de comedores by id
	 * @param 	int 	$id
	 */
	public function search_by_id($id)
	{
		$url = 'api/diners/' . $id;
		return $this->search($url);
	}
	
	/**
	 * Consulta de comedores por página y búsqueda por name para el listado
	 * @param 	string 	$page
	 */
	// TODO: Cambiar búsqueda por name por búsqueda genérica
	public function get_diners_by_page_and_search($page, $searchTxt)
	{
		$url = 'api/diners?page=' . $page . '&name=' . $searchTxt;
		return $this->search($url);
	}
	
	/**
	 * Edición de diner
	 * @param		object	$diner
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el diner, sino devuelve NULL
	 */
	public function edit($diner)
	{
		try{
			$jsonToSend['diner'] = $diner;
			$response = $this->client->request('PUT', 'api/diners/' . $diner->id, [
					'json' => $jsonToSend
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
	 * Borrar imagen de comedor
	 * @param		string	$idDiner
	 * 				string	$idPhoto
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el diner, sino devuelve NULL
	 */
	public function deleteImage($idDiner, $idPhoto)
	{
		$response = $this->client->request('DELETE', 'api/dinerPhotos/' . $idDiner . '/' . $idPhoto);
		if($response->getStatusCode()==HTTP_NO_CONTENT)
		{
			return TRUE;
		}
		else
			return FALSE;
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
	 * Delete de diner
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve un array con el diner, sino devuelve NULL
	 */
	public function delete($id)
	{
		$response = $this->client->request('DELETE', 'api/diners/' . $id);
		if($response->getStatusCode()==HTTP_OK)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
};