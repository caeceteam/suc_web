<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Home_model extends CI_Model {
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
		$this->client = new Client([
			'headers'  => ['x-access-token' => $this->session->token], //header con datos de sesión 
			'base_uri' => $this->base_uri,
			'timeout'  => $this->timeout,
			]);
	}
	
	/**
	 * Consulta de diner application
	 *
	 * Consulta diner application por id o estado, o devuelve todos los que tengan estado pendiente
	 * @param 		string 		$id
	 * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
	 */
	public function search($id=NULL, $state=NULL)
	{
		if(isset($id))
			$response = $this->client->request('GET', 'api/diners/' . $id);
		else
			$response = $this->client->request('GET', $state !== NULL ? 'api/diners?state=' . $state : 'api/diners/');
		if($response->getStatusCode()==HTTP_OK)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
		else
			return NULL;
	}
};