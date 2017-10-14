<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assistant extends CI_Controller {

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
		$this->load->model('Assistant_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'assistant';
		$this->_initialize_fields();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('assistant/render_table_response');
		$this->load->view('assistant/search', $this->variables);
	}
	
	/**
	 * Funcion para retornar la información a cargar en las grillas con la estructura JSON requerida por bootgrid
	 */
	public function render_table_response()
	{
		$service_data = $this->Assistant_model->get_assistants_by_page($this->assistant->post('current') - 1);
		$pagination_data = $service_data['pagination'];
		$assistants_data = $service_data['assistants'];
		
		$render_data['current'] = (int)$this->assistant->post('current');
		$render_data['total'] = $pagination_data['total_elements'];
		
		$render_data['rows'] = [];
		foreach ($assistants_data as $assistant)
		{
			$row_data['idAssistant'] = $assistant['idAssistant'];
			$row_data['idDiner'] = $assistant['idDiner'];
			$row_data['name'] = $assistant['name'];
			$row_data['surname'] = $assistant['surname'];
			$row_data['address'] = $assistant['address'];
			$row_data['phone'] = $assistant['phone'];
			array_push($render_data['rows'], $row_data);
		}
		echo json_encode($render_data, TRUE);
	}
	
	/**
	 * Funcion que muestra el formulario de alta y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function add()
	{
		$this->variables['action'] = site_url('assistant/add');
		$this->variables['request-action'] = 'POST';
		$this->variables['redirect-url'] = site_url('assistant');
		$this->_set_rules();
		if ($this->input->method() == "get")
		{
			$this->load->view('assistant/save', $this->variables);
		}
		else
		{
			// Todo esto corresponde al POST
			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'surname' => form_error('surname'),
						'name' => form_error('name'));
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Assistant_model->add($this->_get_post());
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
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la validacion del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */
	public function edit($id=NULL)
	{
		$this->variables['action'] = site_url('assistant/edit');
		$this->variables['request-action'] = 'PUT';
		$this->variables['redirect-url'] = site_url('assistant');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if($this->assistant->method() == "get")
		{
			$assistant = $this->Assistant_model->search_by_id($id);
			$this->form_data->id					= $assistant['idAssistant'];
			$this->form_data->idDiner				= 1;
			$this->form_data->name 					= $assistant['name'];
			$this->form_data->surname 				= $assistant['surname'];
			$this->form_data->bornDate 				= $assistant['bornDate'];
			$this->form_data->street 				= $assistant['street'];
			$this->form_data->streetNumber 			= $assistant['streetNumber'];
			$this->form_data->floor 				= $assistant['floor'];
			$this->form_data->door 					= $assistant['door'];
			$this->form_data->zipcode 				= $assistant['zipcode'];
			$this->form_data->latitude 				= $assistant['latitude'];
			$this->form_data->longitude				= $assistant['longitude'];
			$this->form_data->phone 				= $assistant['phone'];
			$this->form_data->contactName 			= $assistant['contactName'];
			$this->form_data->scholarship 			= $assistant['scholarship'];
			$this->form_data->eatAtOwnHouse 		= $assistant['eatAtOwnHouse'];
			$this->form_data->economicSituation 	= $assistant['economicSituation'];
			$this->form_data->celiac 				= $assistant['celiac'];
			$this->form_data->diabetic 				= $assistant['diabetic'];
			$this->form_data->document 				= $assistant['document'];
			$this->load->view('assistant/save', $this->variables);
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$assistant = new stdClass();
			// Todo esto corresponde al PUT
			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'code' => form_error('code'),
						'name' => form_error('name'));// TODO: review
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Assistant_model->edit($this->_get_post());
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
		$this->Assistant_model->delete($id);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del assistant para cuando se trata de una edición
	 * @return		object		$assistant
	 */
	private function _get_post($id=NULL)
	{
		$assistant = new stdClass();
		$assistant->id					= $id != NULL ? $id : $this->input->post('id');
		$assistant->idDiner				= $this->input->post('idDiner');
		$assistant->name				= $this->input->post('name');
		$assistant->surname				= $this->input->post('surname');
		$assistant->bornDate			= $this->input->post('bornDate');
		$assistant->street				= $this->input->post('street');
		$assistant->streetNumber		= $this->input->post('streetNumber');
		$assistant->floor				= $this->input->post('floor');
		$assistant->door				= $this->input->post('door');
		$assistant->zipcode				= $this->input->post('zipcode');
		$assistant->phone				= $this->input->post('phone');
		$assistant->contactName			= $this->input->post('contactName');
		$assistant->scholarship			= $this->input->post('scholarship');
		$assistant->eatAtOwnHouse		= $this->input->post('eatAtOwnHouse');
		$assistant->economicSituation	= $this->input->post('economicSituation');
		$assistant->celiac				= $this->input->post('celiac');
		$assistant->diabetic			= $this->input->post('diabetic');
		$assistant->document			= $this->input->post('document');
		$assistant->latitude			= $this->input->post('latitude');
		$assistant->longitude			= $this->input->post('longitude');
		return $assistant;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->id 					= '';
		$this->form_data->idDiner				= '';
		$this->form_data->name 					= '';
		$this->form_data->surname 				= '';
		$this->form_data->bornDate 				= '';
		$this->form_data->street 				= '';
		$this->form_data->streetNumber 			= '';
		$this->form_data->floor 				= '';
		$this->form_data->door 					= '';
		$this->form_data->zipCode 				= '';
		$this->form_data->latitude				= '';
		$this->form_data->longitude				= '';		
		$this->form_data->phone 				= '';
		$this->form_data->contactName 			= '';
		$this->form_data->scholarship 			= '';
		$this->form_data->eatAtOwnHouse 		= '';
		$this->form_data->economicSituation 	= '';
		$this->form_data->celiac 				= '';
		$this->form_data->diabetic 				= '';
		$this->form_data->document 				= '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('surname', 'Apellido', 'trim|required');
		$this->form_validation->set_rules('bornDate', 'Fecha de nacimiento', 'trim|required');
	}
}
