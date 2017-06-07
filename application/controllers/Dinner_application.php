<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dinner_application extends CI_Controller {

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
		$this->load->model('Dinner_application_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->_initialize_fields();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		//$this->render_table(NULL, $this->Input_type_model->search());
		$this->load->view('dinner_application/save', $this->variables);
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{

	}
}