<?php

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

class Login_model extends CI_Model {
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
			'base_uri' 	=> $this->base_uri,
			'timeout'  	=> $this->timeout,
			]);
	}
				
	/**
	 * Login de usuario
	 * @param		object	$user
	 * @return 		array   Si el alta fue exitosa, devuelve un array con los datos del usuario, sino devuelve NULL
	 */		
	public function validate($user)
	{
		try
		{
			$response = $this->client->request('POST', 'authentication', [
				'json' => $user
			]);
			if($response->getStatusCode()==HTTP_OK)
			{
				$body = $response->getBody();
				return json_decode($body,TRUE);
			}
			return NULL;
		}
		catch (ClientException $e)
		{
			return NULL;
		}
		catch (ServerException $e) 
		{
			return $this->errorMessage($e);
		}
	}
	
	/**
	 * Cambio de contraseña
	 * @param		object	$password
	 * @return 		array   Si el cambio fue exitoso, devuelve un array con los datos del usuario, sino devuelve NULL
	 */
	public function change_password($password)
	{
		try
		{
			$response = $this->client->request('PUT', 'authentication', [
					'json' => $password
			]);
			if($response->getStatusCode()==HTTP_OK)
			{
				$body = $response->getBody();
				return json_decode($body,TRUE);
			}
			return NULL;
		}
		catch (ClientException $e)
		{
			return NULL;
		}
		catch (ServerException $e)
		{
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
	
};

