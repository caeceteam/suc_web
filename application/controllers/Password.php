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
		$this->variables['id'] 		= '';
		$this->variables['reset'] 	= FALSE;//Variable para indicar si hay que resetear los campos del formulario
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
		$html_ok    = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_error = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_close = '</div>';
				
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
				}else{
				/*	try {
						if ($this->_send_mail_changePass( $user_diner->mail )) {
							$this->variables ['message'] = $html_ok . 'Su clave fue modificada correctamente!' . $html_close;
						} else {
							$this->variables ['message'] = $html_ok . 'Su clave fue modificada correctamente, pero no se puedo enviar la notificacion!' . $html_close;
						}
					
					//Verifico en elvio del Mail - Los datos fueron guardados satisfactoriamente
					} catch ( Exception $exs ) {
						$msj_erro_400 = '<p>No pudo enviarse el mail de confirmacion, verifique si sus datos fueron modifciados </p>';
						$this->variables ['message'] 	= $msj_erro_400;
						$this->variables ['error-type'] = 'unique';
						$this->output->set_status_header ( '400' );
					}
					catch ( Error $err ) {
						$msj_erro_500 = '<p>No pudo enviarse el mail de confirmacion, verifique si sus datos fueron modifciados </p>';
						$this->variables ['message'] 	= $msj_erro_400;
						$this->variables ['error-type'] = 'unique';
						$this->output->set_status_header ( '500' );
					
					}
					*/
					
				}
			}
			echo json_encode($this->variables, TRUE);
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
		
	/**
	 * Funcion Para validar el Password
	 *
	 * @param $oldPass:  Viejo Pass
	 * @param $newPass:  Nuevo Pass
	 * @param $confPass: Confirmacion del Pass
	 * @return void
	 */
	public function valid_password($oldPass, $newPass, $confPass) {
		// Si no se cargan se mantiene la clave
		if (empty ( $oldPass ) && empty ( $oldPass ) && empty ( $oldPass )) {
			return TRUE;
		}
		// Si alguno esta vacio debe caragarse
		elseif (empty ( $oldPass ) || empty ( $oldPass ) || empty ( $oldPass )) {
			return FALSE;
		}
		// Es erronea la confirmación
		else {
			if ($newPass != $confPass) {
				return FALSE;
			}
			// Es erronea la confirmación
			if ($oldPass != $this->form_data->pass || $this->form_data->pass == $newPass) {
				return FALSE;
			}
			//Valido que la clave cumpla condiciones
			if (! $this->valid_single_password ( $newPass )) {
				return FALSE;
			}
			if (! $this->valid_single_password ( $confPass )) {
				return FALSE;
			}
		}
	}
	
	
	/**
	 * Funcion Para validar el valid_single_password
	 *
	 * @param $password:  Pass
	 * @return Bool
	 */
	public function valid_single_password($password) {
		// Caracteres de validación
		$lower_case = '/[a-z]/';
		$upper_case = '/[A-Z]/';
		$number 	= '/[0-9]/';
		$special 	= '/[!@#$%^&*()\-_=+{};:,<.>]/';
	
		// Contiene caracteres minuscula
		if (preg_match_all ( $lower_case, $password ) < 1) {
			$this->form_validation->set_message ( 'valid_password', 'Por lo menos debe contener una letra mayuscula.' );
			return FALSE;
		}
		// Contiene caracteres mayuscula
		if (preg_match_all ( $upper_case, $password ) < 1) {
			$this->form_validation->set_message ( 'valid_password', 'Contener al menos una letra.' );
			return FALSE;
		}
	
		// Almenos un numero
		if (preg_match_all ( $number, $password ) < 1) {
			$this->form_validation->set_message ( 'valid_password', 'Contener al menos un numero.' );
			return FALSE;
		}
	
		// Almenos un caracter especial
		if (preg_match_all ( $special, $password ) < 1) {
			$this->form_validation->set_message ( 'valid_password', 'Contener alguno de los siguieneste caracteres.' . ' ' . htmlentities ( '/[!@#$%^&*()\-_=+{};:,<.>]/' ) );
			return FALSE;
		}
	
		// Longitud minima
		if (strlen ( $password ) < 5) {
			$this->form_validation->set_message ( 'valid_password', 'La clave debe tener una longitud minima de 6 caracteres.' );
			return FALSE;
		}
	
		// Longitud maxima
		if (strlen ( $password ) > 32) {
			$this->form_validation->set_message ( 'valid_password', 'La clave no puede superar los 32 caracteres.' );
			return FALSE;
		}
		return TRUE;
	}
	

	/**
	 * Función que envia un mail a un destinatario con su contraseña
	 *
	 * @param $to string
	 *        	destinatario
	 */
	private function _send_mail_changePass($to) {
		$data = array (
				'mail_type' 		=> CHANGE_PERSON_PASS,
				'destination_email' => $to
		)
		;
		return $this->Emails_model->send_mail_api ( $data );
	}
}
