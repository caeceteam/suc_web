<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

/**
 * Controlador para testear el cliente rest 
 * @author marco cupo
 */

class Test extends CI_Controller {

	/**
	 * Variables para el rest client
	 * @var string
	 */
	private $base_uri 	= 'http://demo2175273.mockable.io';
	private $client;
	private $timeout = 5.0;
	
	/**
	 * Variables para los atributos del modelo
	 * @var string
	 */
	public $id;
	public $code;
	public $name;
	public $description;
	
	public function __construct()
	{
		parent::__construct();
		$this->client = new Client([
			// Base URI is used with relative requests
			'base_uri' => $this->base_uri,
			// You can set any number of default request options.
			'timeout'  => $this->timeout,
			]);
	}
	
	public function index()
	{
		$this->search();
	}
	
	public function search($name=NULL)
	{
		$response = $this->client->request('GET', 'input_type');
		$status = $response->getStatusCode();
		$body = $response->getBody();
		echo 'respuesta normal' . $body;
		$body2 = json_decode($body);
		echo '\njson decode';
		var_dump($body2);
		$body3 = json_decode($body, TRUE);
		echo 'json decode asociativo';
		var_dump($body3);		
	}
}