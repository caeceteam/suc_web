<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends CI_Controller {

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
		$this->load->model(array('Login_model'));
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'password';
		$this->_initialize_fields();
		$this->login->is_logged_in();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->add();
	}
		
	/**
	 * Funcion que muestra el formulario de alta y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return 	array 	$variables
	 */
	public function add()
	{
		$this->variables['action'] = site_url('password/add');
		$this->variables['request-action'] = 'POST';
		$this->variables['redirect-url'] = site_url('password');
		$this->_set_rules();
		if ($this->input->method() == "get")
		{
			$this->load->view('password/save', $this->variables);
		}
		else
		{// Todo esto corresponde al POST
			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'oldPassword' 	=> form_error('oldPassword'),
						'newPassword'	=> form_error('newPassword'),
				        'confPassword'	=> form_error('confPassword'));
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Login_model->change_password($this->_get_post());
				if (isset($response['errors']))
				{
					$this->output->set_status_header('500');
					$this->variables['error-type'] = 'unique';
					$this->variables['error-fields'] = $response['fields'];
				}
			}
			echo json_encode($this->variables);
		}
	}
		
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del diner input para cuando se trata de una edición
	 * @return		object		$password
	 */
	private function _get_post()
	{
		$password = new stdClass();
		$password->userName 	= $this->session->userName;
		$password->oldPassword 	= $this->input->post('oldPassword');
		$password->newPassword 	= $this->input->post('newPassword');
		$password->confPassword = $this->input->post('confPassword');
		return $password;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->oldPassword  = '';
		$this->form_data->newPassword  = '';
		$this->form_data->confPassword = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('oldPassword',  'clave actual', 'required');
		$this->form_validation->set_rules('newPassword',  'nueva clave', 'required');
		$this->form_validation->set_rules('confPassword', 'confirmacion de clave', 'matches[newPassword]');
	}
}
