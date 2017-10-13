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
		$token = isset($this->session->token) ? $this->session->token : '';
		$this->client = new Client([
			'headers' => ['x-access-token' => $token],//Se agrega el header con los datos de la session
			'base_uri' => $this->base_uri,
			'timeout'  => $this->timeout,
			]);
	}
	
	/**
	* Consulta de evento
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
	 * Alta de comedor y usuario
	 * @param		object	$event
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el comedor y usuario, sino devuelve NULL
	 */
	public function add($event)
	{
		$response = $this->client->request('POST', 'api/events', [
				'json' => $event
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
	 * Edición de evento
	 * @param		array	$event
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el event, sino devuelve NULL
	 */
	public function edit($event)
	{
		$response = $this->client->request('PUT', 'api/events/' . $event['event']['idEvent'], [
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
};