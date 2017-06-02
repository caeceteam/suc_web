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
	public $datos_formulario;
	
	/**
	 * Constructor de clase
	 *
	 * Se encarga de hacer el load de los modulos necesarios
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('url', 'form'));
		$this->load->model('Input_type_model');
		/*
		$this->datos_formulario = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['accion'] = site_url('persona/alta');
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->_setear_campos();*/
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->render_table(NULL, $this->Input_type_model->search());
		$this->load->view('input_type/search', $this->variables);
	}
	
	/**
	 * Funcion de consulta
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
	 * Renderiza una tabla en base a un template HTML y un object|array
	 * @param		string		$template
	 * @param		mixed 		object|array Puede recibir un objeto de un input type o un array de varios
	 * @return		void
	 */
	public function render_table($template=NULL, $data)
	{
		//Si los datos a renderizar son un objeto, es porque vino un único registro, se convierte a array para poder iterar el el foreach de mas abajo
		/*if(is_object($data))
		{
			$array[0] = get_object_vars($data);
			$data = $array;
		}*/
		$template = isset($template) ? $template : array(
				'table_open' => '<table id="data-table-command" class="table table-striped table-vmiddle">');
		$this->load->library('table');
		$this->table->set_template($template);
		$this->table->set_heading(
				array('data' => 'Código', 'data-column-id' => 'Codigo', 'data-order' => 'desc'), 
				array('data' => 'Nombre', 'data-column-id' => 'Nombre'), 
				array('data' => 'Descripción', 'data-column-id' => 'Descripcion'), 
				array('data' => 'Modificar/Borrar', 'data-column-id' => 'commands', 'data-formatter' => 'commands', 'data-sortable' => 'false') 
				);
		foreach ($data as $input_type)
		{
			$this->table->add_row($input_type['code'], $input_type['name'], $input_type['description']);
		}
		$this->variables['table'] = $this->table->generate();
	}
}