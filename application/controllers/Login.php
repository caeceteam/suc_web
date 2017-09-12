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
		$this->load->library('form_validation');
		$this->load->helper(array('url', 'form'));
		$this->load->model('Login_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['action'] = site_url('login/login');
	}	
	
	public function index()
	{
		$this->_initialize_fields();
		$this->load->view('login/save', $this->variables);
	}
	
	/**
	 * Funcion que genera guarda la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function add()
	{
		$this->_set_rules();
		if($this->form_validation->run() == FALSE || $this->_save_image($_FILES['photo']['tmp_name']) == FALSE)
		{
			$this->variables['message'] = isset($this->variables['message']) ? $this->variables['message'].validation_errors() : validation_errors();
		}
		else
		{
			$diner_application = ($this->_get_post());
			if(($this->Diner_application_model->add($diner_application))!=NULL)
			{
				if($this->_send_mail($diner_application->user->mail, $this->variables['password']))
					$this->variables['message'] = 'Se envío un mail con su contraseña!';
					else
						$this->variables['message'] = 'Ocurrio un error al enviar el mail, por favor revise el campo mail!';
						$this->variables['reset'] = TRUE;
			}
			else
			{
				$this->variables['message'] = 'Error al guardar';
			}
		}
		$this->load->view('diner_application/save', $this->variables);
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
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->userName = '';
		$this->form_data->password = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('userName', 'Nombre de usuario/Email', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required');
	}
}