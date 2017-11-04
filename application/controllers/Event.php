<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

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
		$this->load->library(array('form_validation', 'login', 'email', 'upload'));
		$this->load->helper(array('url', 'form', 'file'));
		$this->load->helper('date');
		$this->load->model('Event_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'event';
		$this->_initialize_fields();
		$this->login->is_logged_in();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('event/render_table_response');
		$this->load->view('event/search', $this->variables);
	}
	
	/**
	 * Funcion para retornar la información a cargar en las grillas con la estructura JSON requerida por bootgrid
	 */
	public function render_table_response()
	{
		$service_data = $this->Event_model->get_events_by_page($this->input->post('current') - 1);
		//$service_data 		= $this->Event_model->get_events_by_page_and_search($this->input->post('current') - 1, $this->input->post('searchPhrase'));
		$pagination_data 	= $service_data['pagination'];
		$events_data 		= $service_data['events'];
	
		$render_data['current'] = (int)$this->input->post('current');
		if ($pagination_data['number_of_elements'] < $pagination_data['size']) {
			$render_data['total'] = $pagination_data['number_of_elements'];
		}
		else {
			$render_data['total'] = $pagination_data['total_elements'];
		}
	
		$render_data['rows'] = [];
		foreach ($events_data as $event)
		{
			$row_data['id'] 			= $event['idEvent'];
			$row_data['idDiner'] 		= $event['idDiner'];
			$row_data['name'] 			= $event['name'];
			$row_data['date']			= nice_date($event['date'], 'Y-m-d') . ', ' . substr($event['date'], -13, 5) . 'hs' ;
			$row_data['street'] 		= $event['street'] . ' ' . $event['streetNumber'];
			$row_data['phone'] 			= $event['phone'];
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
			$event = $this->Event_model->search($name);
			$this->render_table(NULL, $event);
		}
		else
			$this->index();
	}
	
	/**
	 * Funcion que muestra el formulario de alta y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return 	array 	$variables
	 */
	public function add()
	{
		$this->variables['action'] = site_url('event/add');
		$this->variables['request-action'] = 'POST';
		$this->variables['redirect-url'] = site_url('event');
		$this->_set_rules();
		if ($this->input->method() == "get")
		{
			$this->load->view('event/save', $this->variables);
		}
		else
		{// Todo esto corresponde al POST

			$isImageSaved = $this->_save_image($_FILES['photo']['tmp_name']);
			if ($this->form_validation->run() == FALSE  || !$isImageSaved)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'name'			=> form_error('name'),
						'street' 		=> form_error('street'),
						'date' 			=> form_error('date'));
				if (!$isImageSaved) {
					$data['photo'] = 'Error al guardar la foto del comedor.';
				}
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Event_model->add($this->_get_post());
				if (isset($response['errors']))
				{
					$this->output->set_status_header('500');
					$this->variables['error-type'] = 'unique';
					$this->variables['error-fields'] = $response['fields'];
				}else{
					$this->output->set_status_header('202');
				}
			}
			echo json_encode($this->variables);
		}
	}
	
	/**
	 * Funcion que muestra el formulario de ediciÃ³n y guarda la misma cuando la validacion del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */
	public function edit($id=NULL)
	{
		$this->variables['action'] 			= site_url('event/edit');
		$this->variables['request-action'] 	= 'PUT';
		$this->variables['redirect-url'] 	= site_url('event');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if($this->input->method() == "get")
		{
			$event                       		= $this->Event_model->search_by_id($id);
			$this->form_data->id             	= $event['idEvent'];
			$this->form_data->name 			 	= $event['name'];
			$this->form_data->street 		 	= $event['street'];
			$this->form_data->streetNumber 		= $event['streetNumber'];
			$this->form_data->floor 			= $event['floor'];
			$this->form_data->door 				= $event['door'];
			$this->form_data->phone 			= $event['phone'];
			$this->form_data->latitude 			= $event['latitude'];
			$this->form_data->longitude			= $event['longitude'];
			$this->form_data->zipCode 			= $event['zipCode'];
			$this->form_data->description 		= $event['description'];
			$this->form_data->link 				= $event['link'];
			$this->form_data->date 				= nice_date($event['date'], 'Y-m-d');
			$this->form_data->time				= substr($event['date'], -13, 5);
			$this->load->view('event/save', $this->variables);
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$event = new stdClass();
			$isImageSaved = $this->_save_image($_FILES['photo']['tmp_name']);
			// Todo esto corresponde al PUT
			if (!$this->form_validation->run() || !$isImageSaved)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'name'			=> form_error('name'),
						'street' 		=> form_error('street'),
						'date' 			=> form_error('date'));
				if (!$isImageSaved) {
					$data['photo'] = 'Error al guardar la foto del evento.';
				}
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Event_model->edit($this->_get_post());
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
		$this->Event_model->delete($id);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del event para cuando se trata de una ediciÃ³n
	 * @return		object		$event
	 */
	private function _get_post($id=NULL)
	{
 		$event 					= new stdClass();
		$event->id 				= $id != NULL ? $id : $this->input->post('id');
		$event->name			= $this->input->post('name');
		$event->street			= $this->input->post('street');
		$event->streetNumber	= $this->input->post('streetNumber');
		$event->floor			= $this->input->post('floor');
		$event->door			= $this->input->post('door');
		$event->phone			= $this->input->post('phone');
		$event->latitude		= $this->input->post('latitude');
		$event->longitude		= $this->input->post('longitude');
		$event->zipCode			= $this->input->post('zipCode');
		$event->link			= $this->input->post('link');		
		$event->description		= $this->input->post('description');
		$event->idDiner 		= 1;//$this->input->post('idDiner');
 		$event->photos[0] 		= $this->form_data->photo;//URL que devuelve la API de cloudinary, no se obtiene por post
 		$event->date			= $this->input->post('date') . "T" . $this->input->post('time') . "Z";
 		return $event;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la ediciÃ³n
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->name = '';
		$this->form_data->street = '';
		$this->form_data->streetNumber = '';
		$this->form_data->floor = '';
		$this->form_data->door = '';
		$this->form_data->phone = '';
		$this->form_data->latitude = '';
		$this->form_data->longitude = '';
		$this->form_data->zipCode = '';
		$this->form_data->description = '';
		$this->form_data->link = '';
		$this->form_data->idCity = '';
		$this->form_data->photo = '';
		$this->form_data->date = '';
		$this->form_data->time = '';
		$this->form_data->id = '';
		$this->form_data->idDiner = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('date', 'Fecha', 'trim|required');
		$this->form_validation->set_rules('time', 'Fecha', 'trim');
		$this->form_validation->set_rules('street', 'Dirección', 'trim|required');
	}

	/**
	 * Función que guarda una imagen en la nube usando la API de cloudinary
	 * @param    $photo 	string ruta de la imagen a guardar
	 * @return   bool 		indica si la imagen se guardo correctamente
	 */
	private function _save_image($photo)
	{
		if (!$this->upload->do_upload('photo'))
		{
			//$this->variables['message'] = $this->upload->display_errors();
			return false;
		}
		else
		{
			$response = \Cloudinary\Uploader::upload($photo);//La subo a cloudinary
			$this->form_data->photo = $response['url'];
			delete_files('uploads', FALSE, TRUE);
			return true;
		}
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