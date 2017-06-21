<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Diner_application_model extends CI_Model {
	/**
	 * Variables para el rest client
	 * @var string
	 */
	private $base_uri 	= 'http://localhost:3000';
	private $client;
	private $timeout = 5.0;
	
	/**
	 * Constructor de clase
	 * Se encarga de hacer el load de los modulos necesarios
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->client = new Client([
			'base_uri' => $this->base_uri,
			'timeout'  => $this->timeout,
			]);
	}
	
	/**
	 * Consulta de diner application
	 *
	 * Consulta diner application por id o devuelve todos los que tengan estado pendiente
	 * @param 		string 		$id
	 * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
	 */
	public function search($id=NULL)
	{
		$response = $this->client->request('GET', $id != NULL ? 'api/diners/' . $id : 'api/diners/');
		if($response->getStatusCode()==HTTP_OK)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
		else
			return NULL;
	}
	
	/**
	 * Alta de comedor y usuario
	 * @param		object	$diner_application
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el comedor y usuario, sino devuelve NULL
	 */
	public function add($diner_application)
	{
		$response = $this->client->request('POST', 'api/diners', [
				'json' => $diner_application
		]);
		if($response->getStatusCode()==HTTP_CREATED)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
		else
			return NULL;
	}
};