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
	//public $chekPass;
	public $mail;
	public $idDiner;
	public $phone;
	//public $state;
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
			'base_uri' 	=> $this->base_uri,
			'timeout'  	=> $this->timeout,
			]);
	}
	
	/**
	 * Busco usuarios
	 * 
	 * Consulta tipos de insumo por id o devuelve toda la tabla
	 * @param 		string 		$id
	 * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
	 */
	public function search($idUser=NULL)
	{
		$response = $this->client->request('GET', $idUser != NULL ? 'api/users/' . $idUser : 'api/users/');
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
		$response = $this->client->request('POST', 'api/users', ['json' => $user_diner]);
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
		$response = $this->client->request('PUT', 'api/users/' . $user_diner->idUser , [
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
		$response = $this->client->request('DELETE', 'api/users/' . $id);
		if($response->getStatusCode()==HTTP_OK)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
};