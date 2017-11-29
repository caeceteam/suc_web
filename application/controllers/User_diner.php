<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * ****************************************************************************************************
 * CLASE USER_DINER
 * ******************************************************************************************************
 * HISTORIA: HU021
 * TITULO: Usuario comedor
 * *******************************************************************************************************
 */
class User_diner extends CI_Controller {
	/**
	 * Atributos Publicas
	 */
	public $form_data;
	
	/**
	 * Atributos Pribados
	 */
	private $variables;
	private $dinerUser;
	private $html_ok;   
	private $html_error; 
	private $html_close; 
	
	
	/**
	 * Constructor de clase
	 * Se encarga de hacer el load de los modulos necesarios
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct ();
		
		// Se carga las librerias
		$this->load->library ( array (
				'form_validation',
				'session',
				'upload',
				'email',
				'login' 
		) );
		
		// Se carga las librerias colaboración
		$this->load->helper ( array (
				'url',
				'form' 
		) );
		
		// Se carga las librerias modelos
		$this->load->model ( 'User_diner_model' );
		$this->load->model(  'Emails_model' );
		
		// Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->form_data = new stdClass ();
		$this->variables ['idUser'] = '';

		
		// Variable para indicar si hay que resetear los campos del formulario
		$this->variables ['reset'] = FALSE;
		$this->variables ['controller-name'] = 'user_diner';
		$this->_initialize_fields ();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin
	 * especificar la URL completa
	 *
	 * @return void
	 */
	public function index() {
		$this->variables ['data-request-url'] = site_url ( 'user_diner/render_table_response' );
		$this->load->view ( 'user_diner/search', $this->variables );
	}
	
	/**
	 * Funcion que retorna la tabla con la informacion de usuarios
	 *
	 * @return void
	 */
	public function render_table_response() {
		$data = array ();
		
		// Segun ROL se muestran todos los usuarios o solo los de un comedor
		if ($this->session->userdata ['role'] == SYS_ADMIN) {
			
			$service_data = $this->User_diner_model->get_user_diner_by_page_and_searchTxt ( $this->input->post ( 'current' ) - 1, $this->input->post ( 'searchPhrase' ) );
			
			$pagination_data = $service_data ['pagination'];
			$user_diner_data = $service_data ['users'];
			
		} else {
			
			$service_data 		 = $this->User_diner_model->get_userdiner_by_diner ( $this->input->post ( 'current' ) - 1, $this->session->userdata ['idDiner'] );
			$pagination_data 	 = $service_data ['pagination'];
			$user_diner_data_aux = $service_data ['usersDiners'];
			
			foreach ( $user_diner_data_aux as $user_diner ) {
				array_push ( $data, $user_diner ['user'] );
			}
			$user_diner_data = $data;
		}
		
		// Se crea la tabla con los datos Recuperados
		$render_data ['current'] = ( int ) $this->input->post ( 'current' );
		$render_data ['total']   = $pagination_data ['total_elements'];
		
		$render_data ['rows'] = [ ];
		foreach ( $user_diner_data as $user_diner ) {
			$row_data ['id']   		= $user_diner ['idUser'];
			$row_data ['name'] 		= $user_diner ['name'];
			$row_data ['surname'] 	= $user_diner ['surname'];
			$row_data ['phone'] 	= $user_diner ['phone'];
			array_push ( $render_data ['rows'], $row_data );
		}
		echo json_encode ( $render_data, TRUE );
	}
	
	/**
	 * Funcion de baja
	 *
	 * @param string $id        	
	 * @return void
	 */
	public function delete($id = NULL) {
		$this->User_diner_model->delete ( $id );
		$this->index ();
	}
	
	/**
	 * Funcion que muestra el formulario de alta y guarda la misma cuando la
	 * validacion del formulario no arroja errores
	 *
	 * @return void
	 */
	public function add() {
		$html_ok    = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_error = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_close = '</div>';
		
		$msj_erro_500 = '';
		$this->variables ['action'] 		= site_url ( 'user_diner/add' );
		$this->variables ['request-action'] = 'POST';
		$this->variables ['redirect-url'] 	= site_url ( 'user_diner' );
		$this->form_data->redirect 			= 'user_diner';
		$seccion;
		
		// Redirijo la url para que no se vea la de origen
		$this->_set_rules ();
		
		if ($this->input->method () == "get") {
			$this->load->view ( 'user_diner/save', $this->variables );
		} else {
			// Todo esto corresponde al POST
			if ($this->form_validation->run () == FALSE) {
				$this->output->set_status_header ( '500' );
				$this->variables ['error-type'] = 'empty-field';
				
				$data = array (
						'name' 			=> form_error ( 'name' ),
						'surname' 		=> form_error ( 'surname' ),
						'alias' 		=> form_error ( 'alias' ),
						'docNum'		=> form_error ( 'docNum' ),
						'bornDate' 		=> form_error ( 'bornDate' ),
						'role' 			=> form_error ( 'role' ),
						'mail' 			=> form_error ( 'mail' ),
						'phone'			=> form_error ( 'phone' ),
						'street' 		=> form_error ( 'street' ),
						'streetNumber' 	=> form_error ( 'streetNumber')
				);
				$this->variables ['error-fields'] = array_map ( "utf8_encode", $data );
			}else {
				$new_user = $this->_get_post ();
				$response = $this->User_diner_model->add ( $new_user );
				
				if ((isset ( $response ['errors'] )) && ($response ['errors'] != null)) {
					$this->output->set_status_header ( '500' );
					$this->variables ['error-type'] = 'unique';
					
					// Concateno mensaje en formato HTML para que pueda mostrarse desde la Vista
					$msj_erro_500 = '<p>' . $response ['result'] . '</p>';
					$this->variables ['message'] = form_error ( $msj_erro_500 );
				} else {
					$mail_user = array (
							'mail' 		=> $response ['mail'],
							'name' 		=> $response ['name'],
							'alias' 	=> $response ['alias'],
							'password' 	=> $new_user->pass 
					);
					try {
						
						if ($this->_send_mail_newUser ( $mail_user ['mail'], $mail_user ['alias'], $mail_user ['password'] )) {
							$this->variables ['message'] = $html_ok . 'Se envio un mail de alta!' . $html_close;
						} else {
							$this->variables ['message'] = $html_ok . 'No pudo enviarse el mail de alta, pero fue registrado el usuario!' . $html_close;
						}
					} catch ( Exception $exs ) {
						$this->variables ['message'] = $html_ok . 'No pudo enviarse el mail de alta, pero fue registrado el usuario!' . $html_close;
						
						/*$msj_erro_500 = '<p>' . $exs->getmessage () . '</p>';
						$this->variables ['message'] = $msj_erro_500;
						$this->variables ['error-type'] = 'unique';
						$this->output->set_status_header ( '500' );
					*/
					}
				}
			}
			
			echo json_encode ( $this->variables, TRUE );
		}
	}
	
	/**
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la
	 * validacion del formulario no arroja errores
	 *
	 * @param string $id        	
	 * @return void
	 */
	public function edit($id = NULL) {
		$html_ok    = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_error = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_close = '</div>';
		
		//Inicializar mensaje
		$this->variables ['action'] 		= site_url ( 'user_diner/edit' );
		$this->variables ['request-action'] = 'PUT';
		
		$page = $this->session->get_userdata ();
		// Si el usuario ve sus datos puede cambiar su nombre no así si no lo es
		// De igual manere si es el usuario logueado el que ve los datos Calcelar vuelve el Home
		if ($id != $page ['idUser']) {
			$this->form_data->redirect 			= 'user_diner';
			$this->form_data->block    			= 'readonly';
			$this->variables['redirect-url'] 	= site_url('user_diner');
			
		} else {
			$this->form_data->redirect = 'home';
			$this->variables['redirect-url'] 	= site_url('home');
				
		}
		
		// Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if ($this->input->method () == "get") {
			$user_and_diner 	 	  = $this->User_diner_model->search_by_id ( $id );
			$user_dat 			 	  = $user_and_diner ['user'];
			$diner_dat 			 	  = $user_and_diner ['diners'];
			$this->form_data->id 	  = $user_dat ['idUser'];
			$this->form_data->name 	  = $user_dat ['name'];
			$this->form_data->surname = $user_dat ['surname'];
			$this->form_data->mail 	  = $user_dat ['mail'];
			$this->form_data->phone   = $user_dat ['phone'];
			$this->form_data->role    = $user_dat ['role'];
			$this->form_data->pass    = $user_dat ['pass'];
			$this->form_data->alias   = $user_dat ['alias'];
			$this->form_data->docNum  = $user_dat ['docNum'];
			
			$user_bornData = new DateTime ( $user_dat ['bornDate'] );
			$this->form_data->bornDate 		= date_format ( $user_bornData, "d-m-Y" );
			$this->form_data->street   		= $user_dat ['street'];
			$this->form_data->streetNumber  = $user_dat ['streetNumber'];
			$this->form_data->floor 		= $user_dat ['floor'];
			$this->form_data->door 			= $user_dat ['door'];
			$idDiner 						= $this->session->userdata ['idDiner'];
			$this->form_data->idDiner 		= $idDiner ['Diner'] ['idDiner'];
			
			if ($id != $page ['idUser'] && $this->session->userdata ['role'] != SYS_ADMIN){
				$this->form_data->template      = 'templates/userDinerRol';
			}elseif($id != $page ['idUser']){
				$this->form_data->template      = 'templates/userDinerRolSysAdm';
			}else{
				$this->form_data->template 	    = '';
			}
			
			$this->load->view ( 'user_diner/save', $this->variables );
			// Se Validan los campos ingresados
		} else {
			$this->_initialize_fields ();
			$this->_set_rules ();
			$user_diner = new stdClass ();
			
			// Todo esto corresponde al PUT
			if ($this->form_validation->run () == FALSE) {
				$this->output->set_status_header ( '500' );
				$this->variables ['error-type'] = 'empty-field';
				
				$data = array (
						'name' 			=> form_error ( 'name' ),
						'surname' 		=> form_error ( 'surname' ),
						'alias' 		=> form_error ( 'alias' ),
						'docNum'		=> form_error ( 'docNum' ),
						'bornDate' 		=> form_error ( 'bornDate' ),
						'role' 			=> form_error ( 'role' ),
						'mail' 			=> form_error ( 'mail' ),
						'phone'			=> form_error ( 'phone' ),
						'street' 		=> form_error ( 'street' ),
						'streetNumber' 	=> form_error ( 'streetNumber')
				);
				
				$this->variables ['error-fields'] = array_map ( "utf8_encode", $data );
			} else {
				$user_diner = $this->_get_post ();
				$response   = $this->User_diner_model->edit ( $user_diner );
				
				if (isset ( $response ['errors'] ) && $response ['errors']) {
					$this->output->set_status_header ( '500' );
					$this->variables ['error-type'] = 'unique';
					$this->variables ['error-fields'] = $response ['fields'];
				
				// Sin errores de campo, ni API
				} else {
					$user_diner = $this->_get_post ();
					try {
						if ($this->_send_mail_changeUser( $user_diner->mail )) {
							$this->variables ['message'] = $html_ok . 'Los datos fuero modificados correctamente!' . $html_close;
						} else {
							$this->variables ['message'] = $html_error . 'Los datos fuero modificados correctamente, pero no se puedo enviar la notificacion!' . $html_close;
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
				}
			}
			echo json_encode ( $this->variables, TRUE );
		}
	}
	
	/**
	 * Funcion que muestra el formulario de datos seleccionados
	 *
	 * @param string $id        	
	 * @return void
	 */
	public function view($id = NULL) {
		$this->variables ['action'] = site_url ( 'user_diner/vew' );
		if ($this->input->method () == "get") {
			$user_diner 			  = $this->User_diner_model->search ( $id );
			$this->form_data->id 	  = $user_diner ['idUser'];
			$this->form_data->name 	  = $user_diner ['name'];
			$this->form_data->surname = $user_diner ['surname'];
			$this->form_data->mail 	  = $user_diner ['mail'];
			$this->form_data->phone   = $user_diner ['phone'];
			$this->form_data->role    = $user_diner ['role'];
			$this->form_data->pass    = $user_diner ['pass'];
			$this->form_data->alias   = $user_diner ['alias'];
			$this->form_data->docNum  = $user_diner ['docNum'];
			$this->form_data->street  = $user_diner ['street'];
			$this->form_data->floor   = $user_diner ['floor'];
			$this->form_data->door    = $user_diner ['door'];
			$this->form_data->streetNumber = $user_diner ['streetNumber'];
			
			if ($this->session->userdata ['role'] != SYS_ADMIN){
				$this->form_data->template      = 'templates/userDinerRol';
			}else{
				$this->form_data->template      = 'templates/userDinerRolSysAdm';
			}			
			$this->load->view ( 'user_diner/view', $this->variables );
		}
		// echo json_encode($this->variables);
	}
	
	/**
	 * Función que genera una contraseña en forma aleatorio
	 *
	 * @param $chars_min largo
	 *        	minimo (opcional, default 6)
	 * @param $chars_max largo
	 *        	máximo (opcional, default 8)
	 * @param $use_upper_case boolean
	 *        	para indicar si se usan mayúsuculas (opcional, default false)
	 * @param $include_numbers boolean
	 *        	para indicar si se usan números (opcional, default false)
	 * @param $include_special_chars boolean
	 *        	para indicar si se usan caracteres especiales (opcional,
	 *        	default false)
	 * @return string containing a random password
	 */
	private function _generate_password($chars_min = 6, $chars_max = 8, $use_upper_case = false, $include_numbers = false, $include_special_chars = false) {
		$length 	= rand ( $chars_min, $chars_max );
		$selection 	= 'aeuoyibcdfghjklmnpqrstvwxz';
		
		if ($include_numbers)
			$selection .= "1234567890";
		
		if ($include_special_chars)
			$selection .= "!@\"#$%&[]{}?|";
		
		$password = "";
		for($i = 0; $i < $length; $i ++) {
			$current_letter = $use_upper_case ? (rand ( 0, 1 ) ? strtoupper ( $selection [(rand () % strlen ( $selection ))] ) : $selection [(rand () % strlen ( $selection ))]) : $selection [(rand () % strlen ( $selection ))];
			$password .= $current_letter;
		}
		return $password;
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 *
	 * @param integer $id
	 *        	id del input type para cuando se trata de una edición
	 * @return object $user_diner
	 */
	private function _get_post($id = NULL) {
		$user_diner 		  = new stdClass ();
		$user_diner->idUser   = $id != NULL ? $id : $this->input->post ( 'id' );
		$user_diner->name     = $this->input->post ( 'name' );
		$user_diner->surname  = $this->input->post ( 'surname' );
		$user_diner->mail     = $this->input->post ( 'mail' );
		$user_diner->phone    = $this->input->post ( 'phone' );
		$user_bornData 		  = new DateTime ( $this->input->post ( 'bornDate' ) );
		$user_bornData 		  = date_format ( $user_bornData, 'Y-m-d' );
		$user_diner->bornDate = $user_bornData;
		$user_diner->role 	  = $this->input->post ( 'role' );
		$user_diner->pass 	  = $this->_generate_password ();
		$user_diner->alias 	  = $this->input->post ( 'alias' );
		$user_diner->docNum   = $this->input->post ( 'docNum' );
		$user_diner->street   = $this->input->post ( 'street' );
		$user_diner->floor 	  = $this->input->post ( 'floor' );
		$user_diner->door 	  = $this->input->post ( 'door' );
		$user_diner->diner 	  = $this->input->post ( 'diner' );
		$user_diner->streetNumber = $this->input->post ( 'streetNumber' );
		return $user_diner;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la
	 * edicion
	 *
	 * @return void
	 */
	private function _initialize_fields() {
		$this->form_data->id 			= '';
		$this->form_data->name 			= '';
		$this->form_data->surname 		= '';
		$this->form_data->mail 			= '';
		$this->form_data->phone 		= '';
		$this->form_data->bornDate 		= '';
		$this->form_data->role 			= '';
		$this->form_data->pass 			= '';
		$this->form_data->passCheck 	= '';
		$this->form_data->alias 		= '';
		$this->form_data->docNum 		= '';
		$this->form_data->street 		= '';
		$this->form_data->streetNumber 	= '';
		$this->form_data->floor 		= '';
		$this->form_data->door 			= '';
		$this->form_data->diner 		= '';
		$this->form_data->newPassConf 	= '';
		$this->form_data->newPass 		= '';
		$this->form_data->idDiner 		= '';
		$this->form_data->block 		= '';
		$this->form_data->blockRol 		= '';
		
		if ($this->session->userdata ['role'] != SYS_ADMIN){
			$this->form_data->template      = 'templates/userDinerRol';
		}else{
			$this->form_data->template      = 'templates/userDinerRolSysAdm';
		}
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes
	 * de errores
	 *
	 * @return void
	 */
	private function _set_rules() {
		$this->form_validation->set_rules ( 'name', 		'Nombre', 			'trim|required' );
		$this->form_validation->set_rules ( 'surname', 		'Apellido', 		'trim|required' );
		$this->form_validation->set_rules ( 'alias', 		'Alias', 			'trim|required' );
		$this->form_validation->set_rules ( 'bornDate', 	'Fecha Nacimiento', 'trim|required' );
		$this->form_validation->set_rules ( 'mail',     	'Mail',       		'trim|required' );
		$this->form_validation->set_rules ( 'phone',     	'Telefono',     	'trim|required' );
		$this->form_validation->set_rules ( 'role',     	'Puesto',     		'trim|required' );
		$this->form_validation->set_rules ( 'docNum',   	'Documento',  		'trim|required' );
		$this->form_validation->set_rules ( 'street',     	'Calle',      		'trim|required' );
		$this->form_validation->set_rules ( 'streetNumber', 'Numero',	  		'trim|required' );
	}
	
	/**
	 * Función que envia un mail a un destinatario con su contraseña
	 * 
	 * @param $to string
	 *        	destinatario
	 * @param $user string
	 *        	usuario
	 * @param $password string
	 *        	password
	 * @return bool indica si el mail se pudo enviar
	 */
	private function _send_mail_newUser($to, $user, $password) {
		$data = array (
				'mail_type' 		=> NEW_DINER_USER,
				'destination_email' => $to,
				'user_name' 		=> $user,
				'password' 			=> $password 
		);
		return $this->Emails_model->send_mail_api ( $data );
	}
	
	/**
	 * Función que envia un mail a un destinatario con su contraseña
	 * 
	 * @param $to string
	 *        	destinatario
	 */
	private function _send_mail_changeUser($to) {
		$data = array (
				'mail_type' 		=> CHANGE_PERSON_INFORMATION,
				'destination_email' => $to 
		)
		;
		return $this->Emails_model->send_mail_api ( $data );
	}
}