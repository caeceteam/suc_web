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
		$this->load->view($this->strategy_context->get_url('donation/search'), $this->variables);
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
			
			$row_data['state'] 				= $donation['status'];
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
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la validacion del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */
	public function edit($id=NULL)
	{
		$this->variables['action'] 			= site_url('donation/edit');
		$this->variables['request-action'] 	= 'PUT';
		$this->variables['redirect-url'] 	= site_url('donation');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if($this->input->method() == "get")
		{
			$donation 							= $this->Donation_model->search_by_id($id); 
			if ( $donation == !NULL )
			{
				$this->form_data->id				= $donation['idDonation'];		
				$this->form_data->idUserSender		= $donation['idUserSender'];	
				$this->form_data->nameUserSender	= $donation['idUserSender'];
				$this->form_data->idDinerReceiver	= $donation['idDinerReceiver'];			
				$this->form_data->title				= $donation['title'];		
				$this->form_data->description		= $donation['description'];	
				$this->form_data->creationDate		= nice_date($donation['creationDate'], 'Y-m-d');
				$this->form_data->creationTime		= substr($donation['creationDate'], -13, 5);
				$this->form_data->status			= $donation['status'];
			}
			$this->load->view($this->strategy_context->get_url('donation/save'), $this->variables);
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$donation = new stdClass();
			// Todo esto corresponde al PUT
			if (!$this->form_validation->run())
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'title' 		=> form_error('title'),
						'creationDate' 	=> form_error('creationDate'),
						'description' 	=> form_error('description'),
						'status' 		=> form_error('status')
				);
				$this->variables['error-fields'] = array_map("utf8_encode", $data);
			}
			else
			{
				$response = $this->Donation_model->edit($this->_get_post());
				if (isset($response['errors']))
				{
					$this->output->set_status_header('500');
					$this->variables['error-type'] 		= 'unique';
					$this->variables['error-fields'] 	= $response['fields'];
				}
				else {
					$this->output->set_status_header('202');
				}
			}
			echo json_encode( $this->variables );
		}
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
	private function _get_post($id=NULL)
	{
 		$donation = new stdClass();
 		$donation->id 					= $id != NULL ? $id : $this->input->post('id');
 		$donation->idUserSender 		= $this->input->post('idUserSender');
 		$donation->idDinerReceiver 		= $this->input->post('idDinerReceiver');
 		$donation->title 				= $this->input->post('title');
 		$donation->creationDate 		= $this->input->post('creationDate') . "T" . $this->input->post('creationTime') . "Z";
 		$donation->description 			= $this->input->post('description');
 		$donation->status 				= $this->input->post('status');
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
		$this->form_validation->set_rules('title', 'Título', 'trim');
		$this->form_validation->set_rules('description', 'Descripción', 'trim');
		$this->form_validation->set_rules('creationDate', 'Fecha de creación', 'trim');
	}

}