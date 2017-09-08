<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diner_input extends CI_Controller {

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
		$this->load->model(array('Diner_input_model', 'Input_type_model'));
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'diner_input';
		$this->_initialize_fields();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('diner_input/render_table_response');
		$this->load->view('diner_input/search', $this->variables);
	}
	
	/**
	 * Funcion para retornar la información a cargar en las grillas con la estructura JSON requerida por bootgrid
	 * @return		array		$diner_input
	 */
	public function render_table_response()
	{
		$service_data = $this->Diner_input_model->get_dinerinputs_by_page($this->input->post('current') - 1);
		$pagination_data = $service_data['pagination'];
		$diner_inputs_data = $service_data['dinerInputs'];
		
		$render_data['current'] = (int)$this->input->post('current');
		$render_data['total'] = $pagination_data['total_elements'];
		
		$render_data['rows'] = [];
		foreach ($diner_inputs_data as $diner_input)
		{
			$row_data['id'] 			= $diner_input['idDinerInput'];
			$row_data['idDiner'] 		= $diner_input['idDiner'];
			$row_data['inputTypeName'] 	= $diner_input['inputType']['name'];
			$row_data['name'] 			= $diner_input['name'];
			$row_data['quantity'] 		= $diner_input['quantity'];
			array_push($render_data['rows'], $row_data);
		}
		echo json_encode($render_data, TRUE);
	}
	
	/**
	 * Funcion que muestra el formulario de alta y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return 	array 	$variables
	 */
	public function add()
	{
		$this->variables['action'] = site_url('diner_input/add');
		$this->variables['request-action'] = 'POST';
		$this->variables['redirect-url'] = site_url('diner_input');
		$this->_render_dropdown();
		$this->_set_rules();
		if ($this->input->method() == "get")
		{
			$this->load->view('diner_input/save', $this->variables);
		}
		else
		{// Todo esto corresponde al POST
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
				$response = $this->Diner_input_model->add($this->_get_post());
				if (isset($response['errors']))
				{
					$this->output->set_status_header('500');
					$this->variables['error-type'] = 'unique';
					$this->variables['error-fields'] = $response['fields'];
				}
			}
			echo json_encode($this->variables);
		}
	}
	
	/**
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la validacion del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */
	public function edit($id=NULL)
	{
		$this->variables['action'] = site_url('diner_input/edit');
		$this->variables['request-action'] = 'PUT';
		$this->variables['redirect-url'] = site_url('diner_input');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if($this->input->method() == "get")
		{
			$diner_input = $this->Diner_input_model->search_by_id($id);
			$this->form_data->id 			= $diner_input['idDinerInput'];
			$this->form_data->idInputType 	= $diner_input['inputType']['idInputType'];
			$this->form_data->name 			= $diner_input['name'];
			$this->form_data->size 			= $diner_input['size'];
			$this->form_data->genderType 	= $diner_input['genderType'];
			$this->form_data->quantity 		= $diner_input['quantity'];
			$this->form_data->name 			= $diner_input['name'];
			$this->form_data->description 	= $diner_input['description'];
			$this->_render_dropdown($this->form_data->idInputType);
			$this->load->view('diner_input/save', $this->variables);
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$diner_input = new stdClass();
			if ($this->form_validation->run() == FALSE)// Todo esto corresponde al PUT
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
				$this->_render_dropdown($this->input->post('idInputType'));
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
		$this->Diner_input_model->delete($id);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del diner input para cuando se trata de una edición
	 * @return		object		$input_type
	 */
	private function _get_post($id=NULL)
	{
		$diner_input = new stdClass();
		$diner_input->id 			= $id != NULL ? $id : $this->input->post('id');
		$diner_input->idDiner 		= 1;//$this->input->post('idDiner');
		$diner_input->idInputType 	= $this->input->post('idInputType');
		$diner_input->name 			= $this->input->post('name');
		$diner_input->size 			= $this->input->post('size');
		$diner_input->genderType 	= $this->input->post('genderType');
		$diner_input->quantity 		= $this->input->post('quantity');
		$diner_input->description 	= $this->input->post('description');
		return $diner_input;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->id = '';
		$this->form_data->idDiner = '';
		$this->form_data->idInputType = '';
		$this->form_data->name = '';
		$this->form_data->size = '';
		$this->form_data->genderType = '';
		$this->form_data->quantity = '';
		$this->form_data->description = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		//$this->form_validation->set_rules('idDiner', 'Comedor', 'trim|required');
		$this->form_validation->set_rules('idInputType', 'Tipo de insumo', 'trim|required');
		$this->form_validation->set_rules('name', 'Nombre', 'trim');
		$this->form_validation->set_rules('size', 'Talle', 'trim');
		$this->form_validation->set_rules('genderType', 'Género', 'trim|required');
		$this->form_validation->set_rules('quantity', 'Cantidad', 'trim|required');
		$this->form_validation->set_rules('description', 'Descripción', 'trim');
	}
	
	/**
	 * Funcion que completa el combo de tipos de insume si no recibe ningún parametro, sino muestra el combo con el id que recibe
	 * @param 		integer 	$id_input_type
	 * @return void
	 */
	private function _render_dropdown($id_input_type=NULL)
	{
		$input_types = $this->Input_type_model->get_inputtypes_by_page(0)['inputTypes'];
		$descripcion[''] = "Tipo";
		foreach ($input_types as $i)
		{
			$descripcion[$i['idInputType']] = $i['name'];
		}
		$this->variables['input_types']=$descripcion;
		$this->variables['input_type']= isset($id_input_type) ? $id_input_type : '';
	}
}
