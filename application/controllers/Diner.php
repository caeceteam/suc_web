<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diner extends CI_Controller {

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
		$this->load->model('Diner_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'diner';
		$this->_initialize_fields();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('diner/render_table_response');
		$this->load->view('diner/search', $this->variables);
	}
	
	/**
	 * Funcion para retornar la información a cargar en las grillas con la estructura JSON requerida por bootgrid
	 */
	public function render_table_response()
	{
		$service_data = $this->Diner_model->get_diners_by_page_and_search($this->input->post('current') - 1, $this->input->post('searchPhrase'));
		$pagination_data = $service_data['pagination'];
		$diners_data = $service_data['diners'];
	
		$render_data['current'] = (int)$this->input->post('current');
			$render_data['current'] = (int)$this->input->post('current');
		if ($pagination_data['number_of_elements'] < $pagination_data['size']) {
			$render_data['total'] = $pagination_data['number_of_elements'];
		}
		else {
			$render_data['total'] = $pagination_data['total_elements'];
		}
	
		$render_data['rows'] = [];
		foreach ($diners_data as $diner)
		{
			$row_data['id'] = $diner['idDiner'];
			$row_data['name'] = $diner['name'];
			$row_data['street'] = $diner['street'];
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
			$diner = $this->Diner_model->search($name);
			$this->render_table(NULL, $diner);
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
		$this->variables['action'] = site_url('diner/edit');
		$this->variables['request-action'] = 'PUT';
		$this->variables['redirect-url'] = site_url('diner');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if($this->input->method() == "get")
		{
			$diner = $this->Diner_model->search_by_id($id)['diner'];
			$this->form_data->idDiner		= $diner['idDiner'];		
			$this->form_data->name			= $diner['name'];			
			$this->form_data->state			= $diner['state'];			
			$this->form_data->street		= $diner['street'];		
			$this->form_data->streetNumber	= $diner['streetNumber'];	
			$this->form_data->floor			= $diner['floor'];			
			$this->form_data->door			= $diner['door'];			
			$this->form_data->latitude		= $diner['latitude'];		
			$this->form_data->longitude		= $diner['longitude'];		
			$this->form_data->zipCode		= $diner['zipCode'];		
			$this->form_data->phone			= $diner['phone'];			
			$this->form_data->description	= $diner['description'];	
			$this->form_data->link			= $diner['link'];			
			$this->form_data->mail			= $diner['mail'];			
			$this->load->view('diner/save', $this->variables);
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$diner = new stdClass();
			// Todo esto corresponde al PUT
			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'name' => form_error('name'),
						'mail' => form_error('mail'),
						'street' => form_error('street'),
						'phone' => form_error('phone')
				);
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Diner_model->edit($this->_get_post());
				if (isset($response['errors']))
				{
					$this->output->set_status_header('500');
					$this->variables['error-type'] = 'unique';
					$this->variables['error-fields'] = $response['fields'];
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
		$this->Diner_model->delete($id);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del diner para cuando se trata de una edición
	 * @return		object		$diner
	 */
	private function _get_post($id=NULL)
	{
 		$diner = new stdClass();
 		$diner->id 				= $id != NULL ? $id : $this->input->post('id');
 		$diner->name 			= $this->input->post('name');
 		$diner->street 			= $this->input->post('street');
 		$diner->streetNumber 	= $this->input->post('streetNumber');
 		$diner->floor 			= $this->input->post('floor');
 		$diner->door 			= $this->input->post('door');
 		$diner->latitude 		= $this->input->post('latitude');
 		$diner->longitude 		= $this->input->post('longitude');
 		$diner->zipCode 		= $this->input->post('zipCode');
 		$diner->phone 			= $this->input->post('phone');
 		$diner->description 	= $this->input->post('description'); 		
 		$diner->link 			= $this->input->post('link');
 		$diner->mail 			= $this->input->post('mail');
 		$diner->idCity 			= $this->input->post('idCity'); 		
 		return $diner;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->id 			= '';
		$this->form_data->name 			= '';
		$this->form_data->street 		= '';
		$this->form_data->streetNumber 	= '';
		$this->form_data->floor 		= '';
		$this->form_data->door 			= '';
		$this->form_data->latitude 		= '';
		$this->form_data->longitude 	= '';
		$this->form_data->zipCode 		= '';
		$this->form_data->phone 		= '';
		$this->form_data->description 	= '';
		$this->form_data->link 			= '';
		$this->form_data->mail 			= '';
		$this->form_data->idCity 		= '';
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
		$this->form_validation->set_rules('phone', 'Telefono', 'trim|required');
	}
}