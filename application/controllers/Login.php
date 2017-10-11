<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
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
		$this->load->library(array('form_validation', 'session'));
		$this->load->helper(array('url', 'form'));
		$this->load->model('Login_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['action'] = site_url('login/validate_credentials');
		$this->_initialize_fields();
	}	
	
	public function index()
	{
		$this->load->view('login/save', $this->variables);
	}
	
	/**
	 * Funcion que genera guarda la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function validate_credentials()
	{
		$this->_set_rules();
		if($this->form_validation->run() == FALSE)//@TODO Validar si el usuario esta activo
		{
			$this->variables['message'] = '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
			$this->load->view('login/save', $this->variables);
		}
		else
		{
			$user = ($this->_get_post());
			$response = $this->Login_model->validate($user);
			if($response!=NULL)
			{
				$data = array(
						'userName' 		=> $this->input->post('userName'),
						'token'			=> $response['token'],
						'idDiner'		=> $response['diners']['idDiner'],
						'is_logged_in' 	=> true,
						'role'			=> $response['user']['role'] 
				);
				$this->session->set_userdata($data);
				redirect('home');
			}
			else
			{
				$this->variables['message'] = '<div class="alert alert-danger" role="alert">Nombre de usuario/contraseña incorrectos.</div>';
				$this->load->view('login/save', $this->variables);
			}
		}
	}
	
	/**
	 * Funcion que deslogea al usuario eliminando sus datos de la session
	 * @return		void
	 */
	public function logout()
	{
		$this->session->sess_destroy();
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del diner para cuando se trata de una edición
	 * @return		object		$diner_application
	 */
	private function _get_post($id=NULL)
	{
		$user 			= new stdClass();
		$user->userName = $this->input->post('userName');
		$user->password	= $this->input->post('password');
		return $user;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->variables['message'] = '';
		$this->form_data->userName 	= '';
		$this->form_data->password 	= '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_message('required', 'Complete {field}.');
		$this->form_validation->set_rules('userName', 'Nombre de usuario/Email', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required');
	}
}