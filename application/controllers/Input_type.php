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
		$this->load->library('form_validation');
		$this->load->helper(array('url', 'form'));
		$this->load->model('Input_type_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'input_type';
		$this->_initialize_fields();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		//$this->variables['action'] = site_url('input_type');
		$this->render_table(NULL, $this->Input_type_model->search());
		$this->load->view('input_type/search', $this->variables);
	}
	
	/**
	 * Funcion de consulta
	 * @param		string	$name
	 * @return void
	 */
	public function search($name=NULL)
	{
		//$this->_setear_variables(lang('html_persona_titulo_consulta'), '', site_url('persona/consulta'), '', '');
		//$cuil = $this->input->post('cuil');
		if ($name!=NULL){
			$input_type = $this->Input_type_model->search($name);
			$this->render_table(NULL, $input_type);
			/*$this->load->view('templates/header', $this->variables);
			$this->load->view('personas/buscar_persona', $this->variables);
			$this->load->view('templates/footer');*/
		}
		else
			$this->index();
	}
	
	/**
	 * Funcion que muestra el formulario de alta y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function add()
	{
		$this->variables['action'] = site_url('input_type/add');
		$this->_set_rules();
		if ($this->form_validation->run() == FALSE)
		{
			$this->variables['message']= validation_errors();
			$this->load->view('input_type/save', $this->variables);
		}
		else
		{
			$response = $this->Input_type_model->add($this->_get_post());
			if (!isset($response['errors']))
			{
				$this->variables['success-message'] = 'Datos grabados!';
				$this->variables['reset'] = TRUE;
				$this->index();
			}
			else
			{
				$this->variables['failed-message'] = 'Ya existe algún tipo de insumo con el mismo código o nombre';
				$this->load->view('input_type/save', $this->variables);
			}
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
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if(!$this->input->post('name'))
		{
			$input_type = $this->Input_type_model->search($id)['inputType'];
			$this->form_data->id = $input_type['idInputType'];
			$this->form_data->code = $input_type['code'];
			$this->form_data->name = $input_type['name'];
			$this->form_data->description = $input_type['description'];
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$input_type = new stdClass();
			if($this->form_validation->run() == FALSE)
			{
				$this->variables['message']= validation_errors();
			}
			else if($this->Input_type_model->edit($this->_get_post())!=NULL)
			{
				$this->variables['success-message'] = 'Datos editados!';
				$this->variables['reset'] = TRUE;
			}
			else
			{
				$this->variables['failed-message'] = 'Ya existe algún tipo de insumo con el mismo código o nombre';
			}
		}
		$this->load->view('input_type/save', $this->variables);
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
	 * Renderiza una tabla en base a un template HTML y un object|array
	 * @param		string		$template
	 * @param		mixed 		object|array Puede recibir un objeto de un input type o un array de varios
	 * @return		void
	 */
	public function render_table($template=NULL, $data)
	{
		$template = isset($template) ? $template : array(
				'table_open' => '<table id="data-table-command" class="table table-striped table-vmiddle">');
		$this->load->library('table');
		$this->table->set_template($template);
		$this->table->set_heading(
				array('data' => 'Id', 'data-column-id' => 'id', 'data-visible' => 'false'),
				array('data' => 'Código', 'data-column-id' => 'Codigo', 'data-order' => 'desc'), 
				array('data' => 'Nombre', 'data-column-id' => 'Nombre'), 
				array('data' => 'Descripción', 'data-column-id' => 'Descripcion'), 
				array('data' => 'Modificar/Borrar', 'data-column-id' => 'commands', 'data-formatter' => 'commands', 'data-sortable' => 'false') 
				);
		foreach ($data['inputTypes'] as $input_type)
		{
			$this->table->add_row($input_type['idInputType'], $input_type['code'], $input_type['name'], $input_type['description']);
		}
		$this->variables['table'] = $this->table->generate();
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
		$this->form_validation->set_rules('code', 'Código', 'trim|required');
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('description', 'Descripción', 'trim');
	}
}