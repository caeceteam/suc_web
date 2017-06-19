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
		$this->load->library(array('form_validation', 'email'));
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
				$this->_send_mail($this->form_data->user_mail, $this->variables['password']);
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
		$diner_application->user->pass			= $this->variables['password'];
		$diner_application->user->alias 		= 'test' . time();//@TODO Ver como resolvemos esto
		$diner_application->user->mail			= $this->input->post('user_mail');
		$diner_application->user->state 		= 1;//@TODO Ver como resolvemos esto
		$diner_application->user->role 			= 1;//@TODO Ver como resolvemos esto
		return $diner_application;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edici�n
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->variables['password'] = $this->_generate_password();
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
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('mail', 'Mail', 'trim|required');
		$this->form_validation->set_rules('street', 'Calle', 'trim|required');
		$this->form_validation->set_rules('streetNumber', 'N�mero', 'trim|required');
		$this->form_validation->set_rules('floor', 'Piso', 'trim');
		$this->form_validation->set_rules('door', 'Departamento', 'trim');
		$this->form_validation->set_rules('latitude', 'Latitud', 'trim');
		$this->form_validation->set_rules('longitude', 'Longuitud', 'trim');
		$this->form_validation->set_rules('zipCode', 'CP', 'trim|required');
		$this->form_validation->set_rules('phone', 'Tel�fono', 'trim|required');
		$this->form_validation->set_rules('link', 'P�gina', 'trim');
		$this->form_validation->set_rules('description', 'Descripci�n', 'trim');
		$this->form_validation->set_rules('user_name', 'Nombre del solicitante', 'trim|required');
		$this->form_validation->set_rules('surname', 'Apellido del solicitante', 'trim|required');
		$this->form_validation->set_rules('user_mail', 'Mail del solicitante', 'trim|required');
	}
	
	/**
	 * Funci�n que genera una contrase�a en forma aleatorio
	 * @param    $chars_min largo minimo (opcional, default 6)
	 * @param    $chars_max largo m�ximo (opcional, default 8)
	 * @param    $use_upper_case boolean para indicar si se usan may�suculas (opcional, default false)
	 * @param    $include_numbers boolean para indicar si se usan n�meros (opcional, default false)
	 * @param    $include_special_chars boolean para indicar si se usan caracteres especiales (opcional, default false)
	 * @return    string containing a random password
	 */
	private function _generate_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=false, $include_special_chars=false)
	{
		$length = rand($chars_min, $chars_max);
		$selection = 'aeuoyibcdfghjklmnpqrstvwxz';
		if($include_numbers) {
			$selection .= "1234567890";
		}
		if($include_special_chars) {
			$selection .= "!@\"#$%&[]{}?|";
		}
		$password = "";
		for($i=0; $i<$length; $i++) {
			$current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
			$password .=  $current_letter;
		}
		return $password;
	}
	
	/**
	 * Funci�n que genera una contrase�a en forma aleatorio
	 * @param    $chars_min int largo minimo (opcional, default 6)
	 * @param    $chars_max int largo m�ximo (opcional, default 8)
	 * @param    $use_upper_case boolean para indicar si se usan may�suculas (opcional, default false)
	 * @param    $include_numbers boolean para indicar si se usan n�meros (opcional, default false)
	 * @param    $include_special_chars boolean para indicar si se usan caracteres especiales (opcional, default false)
	 * @return   string containing a random password
	 */
	private function _send_mail($to, $password)
	{
		$this->email->from('suc@no-reply.com', 'Sistema �nico de Comedores');
		$this->email->to($to);
		$this->email->subject('Solicitud de alta de comedor');
		$this->email->message('Bienvenido al sistema �nico de comedores. <br/>
			Su solicitud de alta se encuetra pendiente, recibir� un mail indicando el resultado de la solicitud. <br/>
			Su contrase�a es' . $password . '<br/>');
		$this->email->send();
	}
}