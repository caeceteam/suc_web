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
		$this->_cloudinary_init();
		$this->load->library(array('form_validation', 'email', 'upload', 'login'));
		$this->load->helper(array('url', 'form', 'file'));
		$this->load->model('Diner_application_model');
		$this->load->model('Emails_model');
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
		$this->variables['request-action'] = 'POST';
		$this->variables['redirect-url'] = site_url('home');
		$this->_set_rules();
		
		if ($this->input->method() == "get")
		{
			$this->load->view('diner_application/save', $this->variables);
		}
		else
		{
			$isImageSaved = $this->upload->do_upload('photo');
			if(!$this->form_validation->run() || !$isImageSaved)
			{
				$this->variables['reset'] = TRUE;
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'name' => form_error('name'),
						'mail' => form_error('mail'),
						'street' => form_error('streetNumber') == '' ? '' : '<p>Verifique haber ingresado una dirección válida</p>',
						'phone' => form_error('phone'),
						'user_name' => form_error('user_name'),
						'surname' => form_error('surname'),
						'user_mail' => form_error('user_mail'),
						'alias' => form_error('alias'));
				$data['photo'] = $_FILES['photo']['tmp_name'] == "" ? '<p>Debe elegir una imagen</p>' : (!$isImageSaved ? '<p>Hubo un error al guardar la imagen</p>' : '');
				$this->variables['error-fields'] =  array_map("utf8_encode", $data);
				echo json_encode($this->variables, TRUE);
			}
			else
			{
				$this->_save_image($_FILES['photo']['tmp_name']);
				$diner_application = ($this->_get_post());
				$response = $this->Diner_application_model->add($diner_application);
				if(isset($response['errors']))
				{
					$this->output->set_status_header('500');
					$this->variables['error-type'] = 'unique';
					$this->variables['error-fields'] = 	array(
						'alias' => isset($response['fields']['alias']) ? 'Ya existe un usuario con el mismo alias' : '',
						'user_mail'  => isset($response['fields']['mail']) ? 'Ya existe un usuario con el mismo mail' : ''
					);
				}
				else {
					if($this->_send_mail($diner_application->user->mail, $diner_application->user->alias, $this->variables['password']))
					{
						$this->variables['message'] = $html_ok . 'Se envió un mail con su contraseña!' . $html_close;
					}
					else
					{
						$this->variables['error-fields'] = array('send_mail' => 'Hubo un error al enviar el mail con su contraseña');
					}					
				}
				echo json_encode($this->variables, TRUE);
			}
		}
		
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
		$diner_application->diner->photos[0] 	= $this->form_data->photo;//URL que devuelve la API de cloudinary, no se obtiene por post
		$diner_application->user->name			= $this->input->post('user_name');
		$diner_application->user->surname		= $this->input->post('surname');
		$diner_application->user->pass			= $this->variables['password'];
		$diner_application->user->alias 		= $this->input->post('alias');
		$diner_application->user->mail			= $this->input->post('user_mail');
		$diner_application->user->state 		= USER_INACTIVE;
		$diner_application->user->role 			= DINER_ADMIN;
		return $diner_application;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
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
		$this->form_data->photo = '';
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
		$this->form_validation->set_rules('streetNumber', 'Número', 'trim|required');
		$this->form_validation->set_rules('floor', 'Piso', 'trim');
		$this->form_validation->set_rules('door', 'Departamento', 'trim');
		$this->form_validation->set_rules('latitude', 'Latitud', 'trim');
		$this->form_validation->set_rules('longitude', 'Longuitud', 'trim');
		$this->form_validation->set_rules('phone', 'Teléfono', 'trim|required');
		$this->form_validation->set_rules('link', 'Página', 'trim');
		$this->form_validation->set_rules('description', 'Descripción', 'trim');
		$this->form_validation->set_rules('user_name', 'Nombre del solicitante', 'trim|required');
		$this->form_validation->set_rules('surname', 'Apellido del solicitante', 'trim|required');
		$this->form_validation->set_rules('user_mail', 'Mail del solicitante', 'trim|required');
		$this->form_validation->set_rules('alias', 'Nombre de usuario del solicitante', 'trim|required');
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
	private function _send_mail($to, $user, $password)
	{
		$data = array(
				'mail_type' 		=> REGISTRATION_MAIL,
				'destination_email' => $to,
				'user_name'			=> $user, 
				'password'			=> $password,
				'url'				=> site_url('')
		);
		return $this->Emails_model->send_mail_api($data);
	}
	
	/**
	 * Función que guarda una imagen en la nube usando la API de cloudinary
	 * @param    $photo 	string ruta de la imagen a guardar
	 * @return   bool 		indica si la imagen se guardo correctamente
	 */
	private function _save_image($photo)
	{
		$response = \Cloudinary\Uploader::upload($photo);//La subo a cloudinary
		$this->form_data->photo = $response['url'];
		delete_files('uploads', FALSE, TRUE);
	}
	
	/**
	 * Función que configura la API de cloudinary
	 * @return   void
	 */
	private function _cloudinary_init()
	{
		\Cloudinary::config(array(
				"cloud_name" 	=> "caeceteam",
				"api_key" 		=> "779344883826737",
				"api_secret" 	=> "A2e2eESuMFPc-fXK9Xz3plHSB2U"
		));
	}
}