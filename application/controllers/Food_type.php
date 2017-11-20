<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Food_type extends CI_Controller {

	/**
	 * Array para guardar todas las variables de la pagina
	 * @var array
	 */
	private $variables;
	private $pass;
	
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
		$this->load->model('Food_type_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'food_type';
		$this->_initialize_fields();
		$this->login->is_logged_in();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('food_type/render_table_response');
		$this->load->view($this->strategy_context->get_url('food_type/search'), $this->variables);
	}
	
	/**
	 * Funcion para retornar la informaciÃ³n a cargar en las grillas con la estructura JSON requerida por bootgrid
	 */
	public function render_table_response()
	{

		$service_data = $this->Food_type_model->get_foodtypes_by_page_and_search($this->input->post('current') - 1, $this->input->post('searchPhrase'));
		$pagination_data = $service_data['pagination'];
		$food_types_data = $service_data['foodTypes'];
		
		$render_data['current'] = (int)$this->input->post('current');
		if ($pagination_data['number_of_elements'] < $pagination_data['size']) {
			$render_data['total'] = $pagination_data['number_of_elements'];
		}
		else {
			$render_data['total'] = $pagination_data['total_elements'];
		}
		
		$render_data['rows'] = [];
		foreach ($food_types_data as $food_type)
		{
			$row_data['id'] 			= $food_type['idFoodType'];
			$row_data['code'] 			= $food_type['code'];
			$row_data['name'] 			= $food_type['name'];
			$row_data['description'] 	= $food_type['description'];
			$row_data['perishable'] 	= $food_type['perishable'];
			$row_data['celiac'] 		= $food_type['celiac'];
			$row_data['diabetic'] 		= $food_type['diabetic'];
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
		$this->variables['action'] = site_url('food_type/add');
		$this->variables['request-action'] = 'POST';
		$this->variables['redirect-url'] = site_url('food_type');
		$this->_set_rules();
		if ($this->input->method() == "get")
		{
			$this->load->view($this->strategy_context->get_url('food_type/save'), $this->variables);
		}
		else
		{
			// Todo esto corresponde al POST
			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'code' => utf8_encode(form_error('code')),
						'name' => utf8_encode(form_error('name')));
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Food_type_model->add($this->_get_post());
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
	 * Funcion que muestra el formulario de ediciÃ³n y guarda la misma cuando la validacion del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */
	public function edit($id=NULL)
	{
		$this->variables['action'] = site_url('food_type/edit');
		$this->variables['request-action'] = 'PUT';
		$this->variables['redirect-url'] = site_url('food_type');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if($this->input->method() == "get")
		{
			$food_type = $this->Food_type_model->search_by_id($id);
			if ( $food_type == !NULL )
			{
				$this->form_data->id 			= $food_type['idFoodType'];
				$this->form_data->code 			= $food_type['code'];
				$this->form_data->name 			= $food_type['name'];
				$this->form_data->description 	= $food_type['description'];
				$this->form_data->perishable	= $food_type['perishable'];
				$this->form_data->celiac 		= $food_type['celiac'];
				$this->form_data->diabetic 		= $food_type['diabetic'];
			}
			$this->load->view($this->strategy_context->get_url('food_type/save'), $this->variables);
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$food_type = new stdClass();
			// Todo esto corresponde al PUT
			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'code' => utf8_encode(form_error('code')),
						'name' => utf8_encode(form_error('name')));
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Food_type_model->edit($this->_get_post());
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
		$this->Food_type_model->delete($id);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del foot type para cuando se trata de una ediciÃƒÂ³n
	 * @return		object		$food_type
	 */
	private function _get_post($id=NULL)
	{
		$food_type 					= new stdClass();
		$food_type->id 				= $id != NULL ? $id : $this->input->post('id');
		$food_type->code 			= $this->input->post('code');
		$food_type->name 			= $this->input->post('name');
		$food_type->description 	= $this->input->post('description');
		$food_type->perishable    	= $this->input->post('perishable')  == null ? 0 : 1;
		$food_type->celiac        	= $this->input->post('celiac')      == null ? 0 : 1;
		$food_type->diabetic      	= $this->input->post('diabetic')    == null ? 0 : 1;
		return $food_type;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la ediciÃƒÂ³n
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->id = '';
		$this->form_data->code = '';
		$this->form_data->name = '';
		$this->form_data->description = '';
		$this->form_data->perishable = '';
		$this->form_data->celiac = '';
		$this->form_data->diabetic = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('code', 'Código', 'trim|required');
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('description', 'Descripción', 'trim');
		$this->form_validation->set_rules('perishable', 'Con vencimiento', 'trim');
		$this->form_validation->set_rules('celiac', 'Apto celíaco', 'trim');
		$this->form_validation->set_rules('diabetic', 'Apto diabético', 'trim');
	}
}

