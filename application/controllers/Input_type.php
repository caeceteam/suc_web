<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input_type extends CI_Controller {

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
		$this->load->model('Input_type_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'input_type';
		$this->_initialize_fields();
		$this->login->is_logged_in();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('input_type/render_table_response');
		$this->load->view('input_type/search', $this->variables);
	}
	
	/**
	 * Funcion para retornar la información a cargar en las grillas con la estructura JSON requerida por bootgrid
	 */
	public function render_table_response()
	{
		$service_data = $this->Input_type_model->get_inputtypes_by_page($this->input->post('current') - 1);
		$pagination_data = $service_data['pagination'];
		$input_types_data = $service_data['inputTypes'];
		
		$render_data['current'] = (int)$this->input->post('current');
		$render_data['total'] = $pagination_data['total_elements'];
		
		$render_data['rows'] = [];
		foreach ($input_types_data as $input_type)
		{
			$row_data['id'] = $input_type['idInputType'];
			$row_data['code'] = $input_type['code'];
			$row_data['name'] = $input_type['name'];
			$row_data['description'] = $input_type['description'];
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
		$this->variables['action'] = site_url('input_type/add');
		$this->variables['request-action'] = 'POST';
		$this->variables['redirect-url'] = site_url('input_type');
		$this->_set_rules();
		if ($this->input->method() == "get")
		{
			$this->load->view('input_type/save', $this->variables);
		}
		else
		{
			// Todo esto corresponde al POST
			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'code' => form_error('code'),
						'name' => form_error('name'));
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Input_type_model->add($this->_get_post());
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
		$this->variables['action'] = site_url('input_type/edit');
		$this->variables['request-action'] = 'PUT';
		$this->variables['redirect-url'] = site_url('input_type');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if($this->input->method() == "get")
		{
			$input_type = $this->Input_type_model->search_by_id($id);
			$this->form_data->id = $input_type['idInputType'];
			$this->form_data->code = $input_type['code'];
			$this->form_data->name = $input_type['name'];
			$this->form_data->description = $input_type['description'];
			$this->load->view('input_type/save', $this->variables);
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$input_type = new stdClass();
			// Todo esto corresponde al PUT
			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'code' => form_error('code'),
						'name' => form_error('name'));
				$this->variables['error-fields'] = $data;
			}
			else
			{
				$response = $this->Input_type_model->edit($this->_get_post());
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
		$this->Input_type_model->delete($id);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del input type para cuando se trata de una edición
	 * @return		object		$input_type
	 */
	private function _get_post($id=NULL)
	{
		$input_type = new stdClass();
		$input_type->id 			= $id != NULL ? $id : $this->input->post('id');
		$input_type->code 			= $this->input->post('code');
		$input_type->name 			= $this->input->post('name');
		$input_type->description 	= $this->input->post('description');
		return $input_type;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->id = '';
		$this->form_data->code = '';
		$this->form_data->name = '';
		$this->form_data->description = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('code', 'Codigo', 'trim|required');
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('description', 'Descripción', 'trim');
	}
}

