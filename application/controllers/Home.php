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
		$this->load->model('Diner_model');
		$this->load->model('Event_model');
		$this->load->model('Assistant_model');
		$this->load->model('User_diner_model');
		$this->form_data = new stdClass();
		$this->login->is_logged_in();
		$this->_initialize_fields();
	}	
	
	public function index()
	{
		$this->load->view($this->strategy_context->get_url('home/home'));
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->diner_pending_approvals = $this->get_diner_pending_approvals();
		$this->form_data->donation_pending_approvals = $this->get_donation_pending_approvals();
		$diner = $this->Diner_model->search_by_id($this->session->idDiner); 
		$this->form_data->diner_name = $diner['name'];
		$this->form_data->diner_address = $diner['street'].' '.$diner['streetNumber'];
		$this->form_data->diner_phone = $diner['phone'];
		$this->form_data->pending_events = $this->get_pending_events($this->session->idDiner);
		$this->form_data->assistants_count = $this->get_assistants_count($this->session->idDiner);
		$this->form_data->users_diners_count = $this->get_users_diners_count($this->session->idDiner);
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
	
	/**
	 * Funcion que devuelve la cantidad de eventos del comedor
	 * @return int
	 */
	public function get_pending_events($idDiner)
	{
		$response = $this->Event_model->get_events_by_idDiner($idDiner);
		return $response['pagination']['total_elements'];
	}
	
	/**
	 * Funcion que devuelve la cantidad de concurrentes del comedor
	 * @return int
	 */
	public function get_assistants_count($idDiner)
	{
		$response = $this->Assistant_model->get_assistants_by_idDiner($idDiner);
		return $response['pagination']['total_elements'];
	}

	/**
	 * Funcion que devuelve la cantidad de concurrentes del comedor
	 * @return int
	 */
	public function get_users_diners_count($idDiner)
	{
		$response = $this->User_diner_model->get_user_diner_by_idDiner($idDiner);
		return $response['pagination']['total_elements'];
	}	
	
}