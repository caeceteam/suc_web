<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diner_food extends CI_Controller {

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
		$this->load->model(array('Diner_food_model', 'Food_type_model'));
		$this->load->helper('date');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'diner_food';
		$this->_initialize_fields();
		$this->login->is_logged_in();
		//date_default_timezone_set('UTC-3');
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('diner_food/render_table_response');
		$this->load->view('diner_food/search', $this->variables);
	}
	
	/**
	 * Funcion para retornar la informacin a cargar en las grillas con la estructura JSON requerida por bootgrid
	 * @return		array		$diner_food
	 */
	public function render_table_response()
	{
		$service_data = $this->Diner_food_model->get_dinerfoods_by_page($this->input->post('current') - 1);
		$pagination_data = $service_data['pagination'];
		$diner_foods_data = $service_data['dinerFoods'];
		
		$render_data['current'] = (int)$this->input->post('current');
		$render_data['total'] = $pagination_data['total_elements'];
		
		$render_data['rows'] = [];
		foreach ($diner_foods_data as $diner_food)
		{
			$row_data['id'] 			= $diner_food['idDinerFood'];
			$row_data['foodTypeName'] 	= $diner_food['foodType']['name'];
			$row_data['name'] 			= $diner_food['name'];
			$row_data['quantity'] 		= $diner_food['quantity'];
			$row_data['unity'] 			= $diner_food['unity'];
			$row_data['expirationDate']	= nice_date($diner_food['expirationDate'], 'Y-m-d');
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
		$this->variables['action'] = site_url('diner_food/add');
		$this->variables['request-action'] = 'POST';
		$this->variables['redirect-url'] = site_url('diner_food');
		$this->_render_dropdown();
		$this->_set_rules();
		if ($this->input->method() == "get")
		{
			$this->load->view('diner_food/save', $this->variables);
		}
		else
		{// Todo esto corresponde al POST
			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'idFoodType' 		=> form_error('idFoodType'),
						'name' 				=> form_error('name'),
						'quantity'			=> form_error('quantity'),
						'unity' 			=> form_error('unity'),
						'expirationDate' 	=> form_error('expirationDate'));
				$this->variables['error-fields'] = array_map("utf8_encode", $data);
			}
			else
			{
				$response = $this->Diner_food_model->add($this->_get_post());
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
		$this->variables['action'] = site_url('diner_food/edit');
		$this->variables['request-action'] = 'PUT';
		$this->variables['redirect-url'] = site_url('diner_food');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if($this->input->method() == "get")
		{
			$diner_food = $this->Diner_food_model->search_by_id($id);
			$this->form_data->id 				= $diner_food['idDinerFood'];
			$this->form_data->idFoodType 		= $diner_food['foodType']['idFoodType'];
			$this->form_data->name 				= $diner_food['name'];
			$this->form_data->endingDate		= $diner_food['endingDate'];
			$this->form_data->expirationDate	= $diner_food['expirationDate'];
			$this->form_data->creationDate		= $diner_food['creationDate'];
			$this->form_data->unity 			= $diner_food['unity'];
			$this->form_data->quantity 			= $diner_food['quantity'];
			$this->form_data->name 				= $diner_food['name'];
			$this->form_data->description 		= $diner_food['description'];
			
			$this->_render_dropdown($this->form_data->idFoodType);
			$this->load->view('diner_food/save', $this->variables);
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$diner_food = new stdClass();
			if ($this->form_validation->run() == FALSE)// Todo esto corresponde al PUT
			{
				$this->output->set_status_header('500');
				$this->variables['error-type'] = 'empty-field';
				$data = array(
						'quantity'			=> form_error('quantity'),
						'unity' 			=> form_error('unity'),
						'expirationDate' 	=> form_error('expirationDate'));
				$this->variables['error-fields'] = array_map("utf8_encode", $data);
			}
			else
			{
				$response = $this->Diner_food_model->edit($this->_get_post());
				if (isset($response['errors']))
				{
					$this->output->set_status_header('500');
					$this->variables['error-type'] = 'unique';
					$this->variables['error-fields'] = $response['fields'];
				}
				$this->_render_dropdown($this->input->post('idFoodType'));
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
		$this->Diner_food_model->delete($id);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del diner food para cuando se trata de una edición
	 * @return		object		$diner_food
	 */
	private function _get_post($id=NULL)
	{
		$diner_food = new stdClass();
		$diner_food->id 			= $id != NULL ? $id : $this->input->post('id');
		$diner_food->idDiner 		= 1;//$this->input->post('idDiner');
		$diner_food->idFoodType 	= $this->input->post('idFoodType');
		$diner_food->name 			= $this->input->post('name');
		$diner_food->quantity 		= $this->input->post('quantity');
		$diner_food->unity 			= $this->input->post('unity');
		$diner_food->description 	= $this->input->post('description');
		$diner_food->expirationDate	= nice_date($this->input->post('expirationDate'), 'Y-m-d');
		$diner_food->creationDate	= nice_date($this->input->post('creationDate'), 'Y-m-d');
		return $diner_food;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		
		$this->form_data->id = '';
		$this->form_data->creationDate = date("Ymd");		
		$this->form_data->idDiner = '';
		$this->form_data->idFoodType = '';
		$this->form_data->name = '';
		$this->form_data->description = '';
		$this->form_data->quantity = '';
		$this->form_data->unity = '';
		$this->form_data->endingDate = '';
		$this->form_data->expirationDate = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		//$this->form_validation->set_rules('idDiner', 'Comedor', 'trim|required');
		$this->form_validation->set_rules('idFoodType', 'Tipo de alimento', 'trim|required');
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('quantity', 'Cantidad', 'trim|required');
		$this->form_validation->set_rules('unity', 'Unidad de Med.', 'trim|required');
		$this->form_validation->set_rules('expirationDate', 'Unidad de Med.', 'trim|required');
		$this->form_validation->set_rules('description', 'Descripción', 'trim');
	}
	
	/**
	 * Funcion que completa el combo de tipos de insume si no recibe ningún parametro, sino muestra el combo con el id que recibe
	 * @param 		integer 	$id_food_type
	 * @return void
	 */
	private function _render_dropdown($id_food_type=NULL)
	{
		$food_types = $this->Food_type_model->get_foodtypes_by_page(0)['foodTypes'];
		$descripcion[''] = "Tipo";
		foreach ($food_types as $i)
		{
			$descripcion[$i['idFoodType']] = $i['name'];
		}
		$this->variables['food_types']=$descripcion;
		$this->variables['food_type']= isset($id_food_type) ? $id_food_type : '';
	}
}
