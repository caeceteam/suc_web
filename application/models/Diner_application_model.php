<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Diner_application_model extends CI_Model {
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
	
	/**
	 * Alta de comedor y usuario
	 * @param		object	$diner_application
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el comedor y usuario, sino devuelve NULL
	 */
	public function add($diner_application)
	{
		try {
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
		catch (ServerException $e) {
			return $this->errorMessage($e);
		}
	}
	
	/**
	 * Edición de comedor
	 * @param		array	$diner_application
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el diner application, sino devuelve NULL
	 */
	public function edit($diner_application)
	{
		$response = $this->client->request('PUT', 'api/diners/' . $diner_application['diner']['idDiner'], [
				'json' => $diner_application
		]);
		if($response->getStatusCode()==HTTP_ACCEPTED)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
		else
			return NULL;
	}
	
	/**
	 * Función que mapea el mensaje de error desde la API usado en los editores
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
};