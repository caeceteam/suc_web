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
	 * Consulta comedor por id o devuelve toda la tabla
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
	 * Edición de diner
	 * @param		object	$diner
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el diner, sino devuelve NULL
	 */
	public function edit($diner)
	{
		$response = $this->client->request('PUT', 'api/diners/' . $diner->id, [
				    'json' => $diner
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