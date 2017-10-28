<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\json_decode;

class Emails_model extends CI_Model {
	/**
	 * Variables para el rest client
	 * @var string
	 */
	private $base_uri 	= 'http://localhost:3000';
	private $client;
	private $timeout = 5.0;
	
	/**
	 * Variables para los atributos del modelo
	 * @var string
	 */
	
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
	
	/**
	 * Enviar correo con datos
	 * @param		structure	$data
	 * @return 		bool   Si la baja fue exitosa
	 */
	public function send_mail_api($data)
	{
		try {
			$response = $this->client->request('POST', 'emails', [
				'json' => $data
			]);
			if($response->getStatusCode()==HTTP_OK)
			{
				return TRUE;
			}
			return FALSE;
		}
		catch (ServerException $e) {
			return $this->errorMessage($e);
		}
	}
};

