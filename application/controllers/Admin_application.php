<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_application extends CI_Controller {

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
		$this->load->library(array('form_validation', 'session', 'email', 'login'));
		$this->load->helper(array('url', 'form'));
		$this->load->model('Diner_application_model');
		$this->load->model('Emails_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->_initialize_fields();
		$this->login->is_logged_in();		
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('admin_application/render_table_response');
		$this->load->view($this->strategy_context->get_url('admin_application/search'), $this->variables);
	}

	/**
	 * Funcion para retornar la informacin a cargar en las grillas con la estructura JSON requerida por bootgrid
	 * @return		array		$pending_diner
	 */
	public function render_table_response()
	{
		$service_data = $this->Diner_application_model->get_pending_diners_by_page_and_search_text($this->input->post('current') - 1, $this->input->post('searchPhrase'));
		$diners_data = $service_data['diners'];
		$pagination_data = $service_data['pagination'];
	
		$render_data['current'] = (int)$this->input->post('current');
		$render_data['total'] = $pagination_data['total_elements'];
	
		$render_data['rows'] = [];
		foreach ($diners_data as $diner)
		{
			$row_data['id'] 	= $diner['idDiner'];
			$row_data['name'] 	= $diner['name'];
			$row_data['address']= $diner['street'] . ' ' . $diner['streetNumber'];
			$row_data['mail'] 	= $diner['mail'];
			array_push($render_data['rows'], $row_data);
		}
		echo json_encode($render_data, TRUE);
	}	
	
	/**
	 * Funcion para acepta la solicitud
	 * @param		string	$id
	 * @return void
	 */
	public function accept($id=NULL)
	{
		$this->_initialize_fields();
		$admin_application = $this->_get_post(true);
		$response = $this->Diner_application_model->edit($admin_application);
		if (isset($response['errors']))
		{
			$this->output->set_status_header('500');
			$this->variables['error-type'] = 'unique';
			$this->variables['error-fields'] = $response['fields'];
		}
		else {
			if (!$this->_send_mail($admin_application)) {
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'mail';
				$this->variables['error-fields'] = $response['fields'];
			}
		}
			
		echo json_encode( $this->variables );
	}
	
	/**
	 * Funcion para rechazar la solicitud
	 * @param		string	$id
	 * @return void
	 */
	public function reject($id=NULL)
	{
		if (trim($this->input->post('reject_reason')) == "")
		{
			$this->output->set_status_header('500');
			$this->variables['error-type'] = 'empty-field';
			$data = array(
					'reject_reason' 	=> 'Debe ingresar algún motivo de rechazo'
			);
			$this->variables['error-fields'] = array_map("utf8_encode", $data);
		} else {
			$this->_initialize_fields();
			$admin_application = $this->_get_post(false);
			$response = $this->Diner_application_model->edit($admin_application);
			if (isset($response['errors']))
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'unique';
				$this->variables['error-fields'] = $response['fields'];
			}
			else {
				if (!$this->_send_mail($admin_application)) {
					$this->output->set_status_header('500');
					$this->variables['error-type'] = 'mail';
					$this->variables['error-fields'] = $response['fields'];
				}
			}			
		}
			
		echo json_encode( $this->variables );
	}	
	
	/**
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la validacion del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */
	public function edit($id=NULL)
	{
		$this->variables['action'] = site_url('admin_application/accept');
		$this->variables['request-action'] = 'PUT';
		$this->variables['redirect-url'] = site_url('admin_application');
		$this->variables['reject-url'] = site_url('admin_application/reject');
		
		$diner = $this->Diner_application_model->search_by_id($id);
		if ( $diner == !NULL )
		{
			$this->form_data->id 				= $diner['idDiner'];
			$this->form_data->photo				= isset($diner['photos'][0]) ? $diner['photos'][0]['url'] : '';
			$this->form_data->id_user			= $diner['user']['idUser'];
			$this->form_data->alias				= $diner['user']['alias'];
			$this->form_data->user_name			= $diner['user']['name'];
			$this->form_data->surname			= $diner['user']['surname'];
			$this->form_data->user_mail			= $diner['user']['mail'];
			$this->form_data->diner_name		= $diner['name'];
			$this->form_data->street			= $diner['street'];
			$this->form_data->streetNumber		= $diner['streetNumber'];
			$this->form_data->floor				= $diner['floor'];
			$this->form_data->door				= $diner['door'];
			$this->form_data->diner_phone		= $diner['phone'];
		}	
		$this->load->view($this->strategy_context->get_url('admin_application/save'), $this->variables);
	}
		
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del diner para cuando se trata de una edición
	 * @return		object		$diner_application
	 */
	private function _get_post($accept, $id=NULL)
	{
		$diner_application = new stdClass();
		$diner_application->id				= $id != NULL ? $id : $this->input->post('id');
		$diner_application->diner 				= new stdClass();
		$diner_application->diner->name		    = $this->input->post('diner_name');
		$diner_application->diner->state		= $accept ? DINER_APPROVED : DINER_REJECTED;
		$diner_application->diner->description 	= $accept ? '' : 'Motivo de rechazo:' . $this->input->post('reject_reason');
		$diner_application->photos = [];
		$diner_application->user 			= new stdClass();
		$diner_application->user->idUser    = $this->input->post('id_user');
		$diner_application->user->alias  	= $this->input->post('alias');
		$diner_application->user->mail		= $this->input->post('user_mail');
		$diner_application->user->active 	= $accept ? USER_ACTIVE : USER_INACTIVE;
		
		//$this->session->set_userdata('diner_application', $diner_application);
		return $diner_application;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->user_name = '';
		$this->form_data->surname = '';
		$this->form_data->user_mail = '';
		$this->form_data->diner_name = '';
		$this->form_data->street = '';
		$this->form_data->streetNumber = '';
		$this->form_data->floor = '';
		$this->form_data->door = '';
		$this->form_data->diner_phone = '';
		$this->form_data->photo = '';
		$this->form_data->reject_reason = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('reject_reason', 'Motivo de rechazo', 'trim|required');
	}
	
	/**
	 * Funcion que llena los campos del formulario en base a un objeto
	 * @param  array 	$diner_application
	 * @return void
	 */
	private function _fill_form($diner_application)
	{
		$this->form_data->user_name = $diner_application['user']['name'];
		$this->form_data->surname = $diner_application['user']['surname'];
		$this->form_data->user_mail = $diner_application['user']['mail'];
		$this->form_data->diner_name = $diner_application['diner']['name'];
		$this->form_data->street = $diner_application['diner']['street'];
		$this->form_data->streetNumber = $diner_application['diner']['streetNumber'];
		$this->form_data->floor = $diner_application['diner']['floor'];
		$this->form_data->door = $diner_application['diner']['door'];
		$this->form_data->diner_phone = $diner_application['diner']['phone'];
		$this->form_data->photo = isset($diner_application['photos'][0]['url']) ? $diner_application['photos'][0]['url'] : base_url('img/sin_imagen.png');
	}
	
	/**
	 * Función que envia un mail a un destinatario indicando el estado de su solicitud
	 * @param    $diner_application 	array  array del diner application
	 * @return   bool 					indica si el mail se pudo enviar
	 */
	private function _send_mail($diner_application)
	{	
		if ($diner_application->diner->state == DINER_APPROVED)
		{
			$data = array(
					'mail_type' 		=> APPROVAL_MAIL,
					'destination_email' => $diner_application->user->mail,
					'user_name'			=> $diner_application->user->alias,
					'diner_name'		=> $diner_application->diner->name,
					'url'				=> site_url('')
			);
		}else{
			$data = array(
					'mail_type' 		=> REJECTION_MAIL,
					'destination_email' => $diner_application->user->mail,
					'diner_name'		=> $diner_application->diner->name,
					'comment'			=> $this->input->post('reject_reason'),
					'url'				=> site_url('')
			);
		}
		
		return $this->Emails_model->send_mail_api($data);
		
	}
}