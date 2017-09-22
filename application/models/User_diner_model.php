<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class  User_diner_model extends CI_Model {
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
	public $idUser;
	public $name;
	public $surname;
	public $alias;
	public $pass;
	public $mail;
	public $idDiner;
	public $phone;
	public $state;
	public $role;
	public $docNumber;
	public $bornDate;

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
	 * Consulta de tipo de insumo
	 * 
	 * Consulta tipos de insumo por id o devuelve toda la tabla
	 * @param 		string 		$id
	 * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
	 */
	public function search($id=NULL)
	{
		$response = $this->client->request('GET', $idUser != NULL ? 'api/user/' . $idUser : 'api/user/');
		if($response->getStatusCode()==HTTP_OK)
		{
			$body = $response->getBody();
			return json_decode($body,TRUE);
		}
		else
			return NULL;
	}
	
	/**
	 * Alta de input type
	 * @param		object	$user_diner
	 * @return 		array   Si el alta fue exitosa, devuelve un array con el input type, sino devuelve NULL
	 */
	public function add($user_diner)
	{
		$response = $this->client->request('POST', 'api/user', [
				    'json' => $user_diner
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
	 * Edición de input type
	 * @param		object	$user_diner
	 * @return 		array   Si la edición fue exitosa, devuelve un array con el input type, sino devuelve NULL
	 */
	public function edit($user_diner)
	{
		$response = $this->client->request('PUT', 'api/user/' . $user_diner->id, [
				    'json' => $user_diner
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
	 * Delete de input type
	 * @param		string	$id
	 * @return 		bool   Si la baja fue exitosa, devuelve un array con el input type, sino devuelve NULL
	 */
	public function delete($id)
	{
		$response = $this->client->request('DELETE', 'api/user/' . $id);
		if($response->getStatusCode()==HTTP_OK)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
};