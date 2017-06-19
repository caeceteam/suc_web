<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diner_application extends CI_Controller {

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
		$this->load->model('Diner_application_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->_initialize_fields();
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
	 * @return void
	 */
	public function add()
	{
		$this->variables['action'] = site_url('diner_application/add');
		$this->_set_rules();
		if($this->form_validation->run() == FALSE)
		{
			$this->variables['message']= validation_errors();
		}
		else
		{
			if(($this->Diner_application_model->add($this->_get_post()))!=NULL)
			{
				$this->variables['message'] = 'Datos grabados!';
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
	 * @return		object		$diner_application
	 */
	private function _get_post()
	{
		$diner_application 			= new stdClass();
		$diner_application->diner 	= new stdClass();
		$diner_application->user 	= new stdClass();
		$diner_application->diner->name			= $this->input->post('name');
		$diner_application->diner->mail			= $this->input->post('mail');
		$diner_application->diner->street		= $this->input->post('street');
		$diner_application->diner->streetNumber	= $this->input->post('streetNumber');
		$diner_application->diner->floor		= $this->input->post('floor');
		$diner_application->diner->door			= $this->input->post('door');
		$diner_application->diner->latitude		= $this->input->post('latitude');
		$diner_application->diner->longitude	= $this->input->post('longitude');
		$diner_application->diner->zipCode		= $this->input->post('zipCode');
		$diner_application->diner->phone		= $this->input->post('phone');
		$diner_application->diner->link			= $this->input->post('link');
		$diner_application->diner->description	= $this->input->post('description');
		$diner_application->user->name			= $this->input->post('user_name');
		$diner_application->user->surname		= $this->input->post('surname');
		$diner_application->user->pass			= '123456';
		$diner_application->user->alias 		= 'test' . time();//@TODO Ver como resolvemos esto
		$diner_application->user->mail			= $this->input->post('user_mail');
		$diner_application->user->state 		= 1;//@TODO Ver como resolvemos esto
		$diner_application->user->role 			= 1;//@TODO Ver como resolvemos esto
		return $diner_application;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->name = '';
		$this->form_data->street = '';
		$this->form_data->streetNumber = '';
		$this->form_data->floor = '';
		$this->form_data->door = '';
		$this->form_data->latitude = '';
		$this->form_data->longitude = '';
		$this->form_data->zipCode = '';
		$this->form_data->phone = '';
		$this->form_data->description = '';
		$this->form_data->link = '';
		$this->form_data->mail = '';
		$this->form_data->idCity = '';
		$this->form_data->user_name = '';
		$this->form_data->surname = '';
		$this->form_data->pass = '';
		$this->form_data->alias = '';
		$this->form_data->user_mail = '';
		$this->form_data->user_phone = '';
		$this->form_data->state = '';
		$this->form_data->role = '';
		$this->form_data->docNumber = '';
		$this->form_data->bornDate = '';
	}
	
	private function _set_rules()
	{
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('mail', 'Mail', 'trim|required');
		$this->form_validation->set_rules('street', 'Calle', 'trim|required');
		$this->form_validation->set_rules('streetNumber', 'Número', 'trim|required');
		$this->form_validation->set_rules('floor', 'Piso', 'trim');
		$this->form_validation->set_rules('door', 'Departamento', 'trim');
		$this->form_validation->set_rules('latitude', 'Latitud', 'trim');
		$this->form_validation->set_rules('longitude', 'Longuitud', 'trim');
		$this->form_validation->set_rules('zipCode', 'CP', 'trim|required');
		$this->form_validation->set_rules('phone', 'Teléfono', 'trim|required');
		$this->form_validation->set_rules('link', 'Página', 'trim');
		$this->form_validation->set_rules('description', 'Descripción', 'trim');
		$this->form_validation->set_rules('user_name', 'Nombre del solicitante', 'trim|required');
		$this->form_validation->set_rules('surname', 'Apellido del solicitante', 'trim|required');
		$this->form_validation->set_rules('user_mail', 'Mail del solicitante', 'trim|required');
	}
}