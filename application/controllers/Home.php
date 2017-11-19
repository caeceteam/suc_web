<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Array para guardar todas las variables de la pagina
	 * @var array
	 */
	private $variables;
	
	/**
	 * Array para guardar exclusivamente los values del formulario
	 * @var array
	 */
	public $form_data;
	
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
		$this->load->model('Home_model');
		$this->form_data = new stdClass();
		$this->login->is_logged_in();
		$this->_initialize_fields();
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
		$this->form_data->diner_pending_approvals = $this->get_diner_pending_approvals();
		$this->form_data->donation_pending_approvals = $this->get_donation_pending_approvals();
	}
	
	/**
	 * Funcion que devuelve la cantidad pendiente de aprobaciones de comedor
	 * @return int
	 */
	public function get_diner_pending_approvals()
	{
		$response = $this->Home_model->diner_search(NULL,DINER_PENDING);
		return $response['pagination']['total_elements'];	
	}
	
	/**
	 * Funcion que devuelve la cantidad pendiente de aprobaciones de donaciones
	 * @return int
	 */
	public function get_donation_pending_approvals()
	{
		$response = $this->Home_model->donation_search(NULL,DONATION_PENDING);
		return $response['pagination']['total_elements'];
	}
}