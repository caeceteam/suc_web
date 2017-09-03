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
		$this->load->model('Diner_input_model');
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
	 * Funcion para retornar la informaciÛn a cargar en las grillas con la estructura JSON requerida por bootgrid
	 * @return		array		$diner_input
	 */
	public function render_table_response()
	{
		$service_data = $this->Diner_input_model->get_dinerinputs_by_page($this->input->post('current') - 1);
		$pagination_data = $service_data['pagination'];
		$diner_inputs_data = $service_data['inputTypes'];
		
		$render_data['current'] = (int)$this->input->post('current');
		$render_data['total'] = $pagination_data['total_elements'];
		
		$render_data['rows'] = [];
		foreach ($diner_inputs_data as $diner_input)
		{
			$row_data['idDinerInput'] 	= $diner_input['idDinerInput'];
			$row_data['idDiner'] 		= $diner_input['idDiner'];
			$row_data['idInputType'] 	= $diner_input['idInputType'];
			$row_data['name'] 			= $diner_input['name'];
			$row_data['size'] 			= $diner_input['size'];
			$row_data['genderType'] 	= $diner_input['genderType'];
			$row_data['quantity'] 		= $diner_input['quantity'];
			$row_data['description'] 	= $diner_input['description'];
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
	 * Funcion que muestra el formulario de ediciÛn y guarda la misma cuando la validacion del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */
	public function edit($id=NULL)
	{
		$this->variables['action'] = site_url('diner_input/edit');
		$this->variables['request-action'] = 'PUT';
		$this->variables['redirect-url'] = site_url('input_type');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if($this->input->method() == "get")
		{
			$diner_input = $this->Diner_input_model->search_by_id($id);
			$this->form_data->id = $diner_input['idInputType'];
			$this->form_data->code = $diner_input['code'];
			$this->form_data->name = $diner_input['name'];
			$this->form_data->description = $diner_input['description'];
			$this->load->view('diner_input/save', $this->variables);
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
		$this->Diner_input_model->delete($id);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del input type para cuando se trata de una edici√≥n
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
	 * Funcion que inicializa las variables de los campos del formulario para la edici√≥n
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
		$this->form_validation->set_rules('code', 'Codigo', 'trim|required');
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('description', 'Descripci√≥n', 'trim');
	}
}
