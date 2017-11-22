<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\ServerException;

class Donation_model extends CI_Model {
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
		$url = 'api/donations/' . $id;
		return $this->search($url);
	}
	
	/**
	 * Consulta de insumos por página para el listado
	 * @param 	string 	$page
	 */
	public function get_donations_by_page($page)
	{
		$url = 'api/donations?page=' . $page;
		return $this->search($url);
	}
	/**
	 * Consulta de donaciones por página y búsqueda para el listado
	 * @param 	string 	$page
	 * 			string	$searchTxt
	 */
	// TODO: Cambiar búsqueda por name por búsqueda genérica
	public function get_donations_by_page_and_search($page, $searchTxt)
	{
		$url = 'api/donations?page=' . $page . '&title=' . $searchTxt;
		return $this->search($url);
	}
	/**
	 * Consulta de donaciones por página y búsqueda para el listado
	 * @param 	string 	$page
	 * 			string	$searchTxt
	 */
	public function get_donations_by_idDiner_page_and_search($idDiner, $page, $searchTxt)
	{
		$url = 'api/donations?idDinerReceiver=' . $idDiner . '&page=' . $page . '&title=' . $searchTxt;
		return $this->search($url);
	}	
	
	/**
	 * Alta de donations
	 * @param		object	$donations
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el donations, sino devuelve NULL
	 */		
	public function add($donations)
	{
		try {
			$response = $this->client->request('POST', 'api/donations', [
				'json' => $donations
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
	 * Edición de dionations
	 * @param		object	$donations
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el donation, sino devuelve NULL
	 */
	public function edit($donations)
	{
		try {
			$response = $this->client->request('PUT', 'api/donations/' . $donations->id, [
					'json' => $donations
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
	 * Busco los usuarios por ID, es usado para seleccionar un unico Usuarios (ABM)
	 * @param 	int 	$id
	 */
	public function search_user_name($id)
	{
		$url = 'api/users/' . $id;
		$user = $this->user_search($url);
		return $user['user']['name']  . ' ' . $user['user']['surname'];
	}
	/**
	 * Busqueda primera pagina, la uso para ver primera pagina segun la cantidad de usuarios
	 * que quiera visualizar
	 *
	 * Consulta los usuarios
	 * @param 		string 		$url
	 * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
	 *
	 */
	private function user_search($url)
	{    $response = $this->client->request('GET', $url);
	if($response->getStatusCode()==HTTP_OK)
	{
		$body = $response->getBody();
		return json_decode($body,TRUE);
	}
	else
		return NULL;
	}
	
	
	/**
	 * Delete de donations
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve TRUE
	 */
	public function delete($id)
	{
		$response = $this->client->request('DELETE', 'api/donations/' . $id);
		if($response->getStatusCode()==HTTP_OK)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
};

