<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Event_model extends CI_Model {
	/**
	 * Variables para el rest client
	 * @var string
	 */
	private $base_uri;
	private $client;
	private $timeout;
	
	/**
	 * Constructor de clase
	 * Se encarga de hacer el load de los modulos necesarios
	 * @return void
	 */
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
	* Consulta de evento
	* 
	* Consulta de eventos a la API
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
	* Consulta de insumos por id
	* @param 	int 	$id
	*/
	public function search_by_id($id)
	{
		$url = 'api/events/' . $id;
		return $this->search($url);
	}
	
	/**
	 * Consulta de Eventos por página para el listado
	 * @param 	string 	$page
	 */
	public function get_events_by_page($page)
	{
		$url = 'api/events?page=' . $page;
		return $this->search($url);
	}

	/**
	 * Consulta de Eventos por página para el listado
	 * @param 	string 	$idDiner
	 */
	public function get_events_by_idDiner($idDiner)
	{
		$url = 'api/events?idDiner=' . $idDiner;
		return $this->search($url);
	}	
	
	/**
	 * Consulta de Eventos por página para el listado
	 * @param 	string 	$idDiner
	 * 			string	$searchTxt
	 */
	public function get_events_by_idDiner_and_searchTxt($idDiner, $searchTxt)
	{
		$url = 'api/events?idDiner=' . $idDiner . '&name=' . $searchTxt;
		return $this->search($url);
	}
	
	/**
	 * Consulta de Eventos por página y comedor para el listado
	 * @param 	string 	$idDiner
	 * 			string  $page
	 * 			string	$searchTxt
	 */
	public function get_events_by_idDiner_page_and_searchTxt($idDiner, $page, $searchTxt)
	{
		$url = 'api/events?idDiner=' . $idDiner . '&page='. $page . '&name=' . $searchTxt;
		return $this->search($url);
	}	
	
	/**
	 * Alta de comedor y usuario
	 * @param		object	$event
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el comedor y usuario, sino devuelve NULL
	 */
	public function add($event)
	{
		try {
			$response = $this->client->request('POST', 'api/events', [
				'json' => $event
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
	 * Edición de evento
	 * @param		array	$event
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el event, sino devuelve NULL
	 */
	public function edit($event)
	{
		try {
			$response = $this->client->request('PUT', 'api/events/' . $event->id, [
					'json' => $event
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
	 * Borrar imagen del evento
	 * @param		string	$idEvent
	 * 				string	$idPhoto
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el diner, sino devuelve NULL
	 */
	public function deleteImage($idEvent, $idPhoto)
	{
		$response = $this->client->request('DELETE', 'api/eventPhotos/' . $idEvent . '/' . $idPhoto);
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
	 * Delete de Evento
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve TRUE
	 */
	public function delete($id)
	{
		try{
			$response = $this->client->request('DELETE', 'api/events/' . $id);
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