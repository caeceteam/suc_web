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
		$this->load->library(array('form_validation', 'session', 'email'));
		$this->load->helper(array('url', 'form'));
		$this->load->model('Login_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['action'] = site_url('login/validate_credentials');
		$this->_initialize_fields();
	}	
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->load->view('login/save', $this->variables);
	}
	
	/**
	 * Funcion que valida usuario y contraseña
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
				        'idUser'        => $response['user']['idUser'],
						'token'			=> $response['token'],
						'idDiner'		=> $response['diners'][0]['idDiner'],
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
	 * Funcion que le envia una nueva contraseña al usuario a su mail
	 * @return		void
	 */
	public function forgot_password()
	{
		$this->variables['action'] = site_url('login/forgot_password');
		$this->_set_rules_forgot_password();
		$html_ok = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_error = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_close = '</div>';
		if($this->form_validation->run() == FALSE)
		{
			$this->variables['message'] = validation_errors();
			$this->variables['message'] = $this->variables['message'] != '' ? $html_error . $this->variables['message'] . $html_close : '';
		}
		else
		{
			$password = ($this->_get_post_forgot_password());
			if(($this->Login_model->reset_password($password))!=NULL)
			{
				if($this->_send_mail($password->userName, $password->newPassword))
					$this->variables['message'] = $html_ok . 'Se envió un mail con su contraseña!' . $html_close;
					else
						$this->variables['message'] = $html_error . 'Ocurrió un error al enviar el mail, por favor revise el campo mail!' . $html_close;
			}
			else
			{
				$this->variables['message'] = $html_error . '¡Ups! Ocurrió un error' . $html_close;
			}
		}
		$this->load->view('login/reset_password', $this->variables);
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @return		object		$user
	 */
	private function _get_post()
	{
		$user 			= new stdClass();
		$user->userName = $this->input->post('userName');
		$user->password	= $this->input->post('password');
		return $user;
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @return		object		$password
	 */
	private function _get_post_forgot_password()
	{
		$password 				= new stdClass();
		$password->userName 	= $this->input->post('userName');
		$password->newPassword	= $this->_generate_password();
		return $password;
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
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules_forgot_password()
	{
		$this->form_validation->set_rules('userName', 'Email', 'required|valid_email');
	}
	
	/**
	 * Función que genera una contraseña en forma aleatorio
	 * @param    $chars_min largo minimo (opcional, default 6)
	 * @param    $chars_max largo máximo (opcional, default 8)
	 * @param    $use_upper_case boolean para indicar si se usan mayúsuculas (opcional, default false)
	 * @param    $include_numbers boolean para indicar si se usan números (opcional, default false)
	 * @param    $include_special_chars boolean para indicar si se usan caracteres especiales (opcional, default false)
	 * @return    string containing a random password
	 */
	private function _generate_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=false, $include_special_chars=false)
	{
		$length = rand($chars_min, $chars_max);
		$selection = 'aeuoyibcdfghjklmnpqrstvwxz';
		if($include_numbers)
			$selection .= "1234567890";
			if($include_special_chars)
				$selection .= "!@\"#$%&[]{}?|";
				$password = "";
				for($i=0; $i<$length; $i++) {
					$current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
					$password .=  $current_letter;
				}
				return $password;
	}
	
	/**
	 * Función que envia un mail a un destinatario con su contraseña
	 * @param    $to 		string destinatario
	 * @param	 $user		string usuario
	 * @param    $password 	string password
	 * @return   bool 		indica si el mail se pudo enviar
	 */
	private function _send_mail($to, $password)
	{
		$this->email->from('suc@no-reply.com', 'Sistema Úšnico de Comedores');
		$this->email->to($to);
		$this->email->subject('Cambio de contraseña');
		$this->email->message('Su nueva contraseña fue generada exitosamente. <br/>
		Su contraseña es: ' . $password . ' .<br/>');
		$this->email->set_newline("\r\n");//Sin esta línea falla el envio
		return $this->email->send();
	}
}