<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donation extends CI_Controller {

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
		$this->load->helper(array('url', 'form', 'file'));
		$this->load->model('Donation_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->load->helper('date');
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'donation';
		$this->_initialize_fields();
		$this->login->is_logged_in();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('donation/render_table_response');
		$this->load->view('donation/search', $this->variables);
	}
	
	/**
	 * Funcion para retornar la información a cargar en las grillas con la estructura JSON requerida por bootgrid
	 */
	public function render_table_response()
	{
		$service_data 		= $this->Donation_model->get_donations_by_page_and_search($this->input->post('current') - 1, $this->input->post('searchPhrase'));
		$pagination_data 	= $service_data['pagination'];
		$donations_data 	= $service_data['donations'];
	
		$render_data['current'] = (int)$this->input->post('current');
		if ($pagination_data['number_of_elements'] < $pagination_data['size']) {
			$render_data['total'] = $pagination_data['number_of_elements'];
		}
		else {
			$render_data['total'] = $pagination_data['total_elements'];
		}
	
		$render_data['rows'] = [];
		foreach ($donations_data as $donation)
		{
			$row_data['id'] 				= $donation['idDonation'];
			$row_data['idUserSender'] 		= $donation['idUserSender'];
			$row_data['nameUserSender'] 	= $this->Donation_model->search_user_name($donation['idUserSender']);
			$row_data['idDinerReceiver'] 	= $donation['idDinerReceiver'];
			$row_data['title'] 				= $donation['title'];
			$row_data['description'] 		= $donation['description'];
			$row_data['creationDate'] 		= nice_date($donation['creationDate'], 'Y-m-d') . ', ' . substr($donation['creationDate'], -13, 5) . 'hs' ;
			$row_data['state'] 				= $donation['status'] == DONATION_PENDING ? 'Pendiente' : ($donation['status'] == DONATION_APPROVED ? 'Aprobado' : 'Rechazado');
			array_push($render_data['rows'], $row_data);
		}
		echo json_encode($render_data, TRUE);
	}
	
	/**
	 * Funcion de consulta
	 * @param		string	$name
	 * @return void
	 */
	public function search($name=NULL)
	{
		if ($name!=NULL){
			$donation = $this->Donation_model->search($name);
			$this->render_table(NULL, $donation);
		}
		else
			$this->index();
	}

	/**
	 * Funcion para acepta la solicitud
	 * @param		string	$id
	 * @return void
	 */
	public function accept($id=NULL)
	{
		$donation = $this->_get_post(true);
		$response = $this->Donation_model->edit($donation);
		if (isset($response['errors']))
		{
			$this->output->set_status_header('500');
			$this->variables['error-type'] = 'unique';
			$this->variables['error-fields'] = $response['fields'];
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
			$donation = $this->_get_post(false);
			$response = $this->Donation_model->edit($donation);
			if (isset($response['errors']))
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'unique';
				$this->variables['error-fields'] = $response['fields'];
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
		$this->variables['action'] 			= site_url('donation/accept');
		$this->variables['request-action'] 	= 'PUT';
		$this->variables['redirect-url'] 	= site_url('donation');
		$this->variables['reject-url'] 		= site_url('donation/reject');
		
		$donation 							= $this->Donation_model->search_by_id($id); 
		$this->form_data->id				= $donation['idDonation'];		
		$this->form_data->idUserSender		= $donation['idUserSender'];	
		$this->form_data->nameUserSender	= $this->Donation_model->search_user_name($donation['idUserSender']);
		$this->form_data->idDinerReceiver	= $donation['idDinerReceiver'];			
		$this->form_data->title				= $donation['title'];		
		$this->form_data->description		= $donation['description'];	
		$this->form_data->creationDate		= nice_date($donation['creationDate'], 'Y-m-d');
		$this->form_data->creationTime		= substr($donation['creationDate'], -13, 5);
		$this->form_data->status			= $donation['status'];
		$this->form_data->items				= $donation['items'];
		$this->load->view('donation/save', $this->variables);
	}
	
	/**
	 * Funcion de baja
	 * @param		string	$id
	 * @return void
	 */
	public function delete($id = NULL)
	{
		$this->Donation_model->delete($id);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del donation para cuando se trata de una edición
	 * @return		object		$donation
	 */
	private function _get_post($accept, $id=NULL)
	{
 		$donation = new stdClass();
 		$donation->id 		= $id != NULL ? $id : $this->input->post('id');
 		$donation->status	= $accept ? DONATION_APPROVED : DONATION_REJECTED;
 		return $donation;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->id 				= '';
		$this->form_data->idUserSender 		= '';
		$this->form_data->nameUserSender 	= '';
		$this->form_data->idDinerReceiver 	= '';
		$this->form_data->title 			= '';
		$this->form_data->description 		= '';
		$this->form_data->creationDate 		= '';
		$this->form_data->creationTime 		= '';
		$this->form_data->status 			= '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('description', 'Descripción', 'trim|required');
	}

}