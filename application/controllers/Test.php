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
	private $base_uri 	= 'http://localhost:3000';
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
		$this->load->library('email');
	}
	
	public function index()
	{
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		
		$this->email->initialize($config);
		
		$this->email->from('suc@no-reply.com', 'Sistema Único de Comedores');
		$this->email->to('cuttlas88@yahoo.com.ar');
		$this->email->subject('Solicitud de alta de comedor');
		$this->email->message('Bienvenido al sistema único de comedores. <br/>
			Su solicitud de alta se encuetra pendiente, recibirá un mail indicando el resultado de la solicitud. <br/>
			Su contraseña es' . 'tu vieja' . '<br/>');
		if($this->email->send())
			echo 'Email enviado';
		else
			echo 'Email no enviado';
		//$this->search();
	}
	
	public function search($name=NULL)
	{
		$response = $this->client->request('GET', 'api/inputtypes');
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