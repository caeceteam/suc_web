<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Constructor de clase
	 * Se encarga de hacer el load de los modulos necesarios
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation', 'login'));
		$this->load->helper(array('url', 'form'));
		$this->login->is_logged_in();
	}	
	
	public function index()
	{
		$this->load->view('home/home');
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
	
	}
}