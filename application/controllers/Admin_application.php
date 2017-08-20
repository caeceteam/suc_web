<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_application extends CI_Controller {

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
		$this->load->model('Diner_application_model');
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
		$this->render_table(NULL, $this->Diner_application_model->search()['diners']);
		$this->load->view('admin_application/search', $this->variables);
	}
	
	/**
	 * Funcion de consulta
	 * @param		string	$name
	 * @return void
	 */
	public function search($name=NULL)
	{
		if ($name!=NULL){
			$input_type = $this->Diner_application_model->search($name);
			$this->render_table(NULL, $diner_application);
		}
		else
			$this->index();
	}
	
	/**
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la validacion del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */
	public function edit($id=NULL)
	{
		$this->variables['action'] = site_url('admin_application/edit');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if(!$this->input->post('reject_reason'))
		{
			$diner_application = $this->Diner_application_model->search($id);
			$this->_fill_form($diner_application);
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
			else if($this->Diner_application_model->edit($this->_get_post())!=NULL)
			{
				$this->variables['message'] = 'Datos editados!';
			}
			else
			{
				$this->variables['message'] = 'Error al editar';
			}
		}
		$this->load->view('admin_application/save', $this->variables);
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
				array('data' => 'Nombre', 'data-column-id' => 'Usuario', 'data-order' => 'desc'),
				array('data' => 'Dirección', 'data-column-id' => 'Dirección'),
				array('data' => 'Email', 'data-column-id' => 'Email'),
				array('data' => 'Ir a solicitud', 'data-column-id' => 'commands', 'data-formatter' => 'commands', 'data-sortable' => 'false')
				);
		foreach ($data as $diner_application)
		{
			$this->table->add_row($diner_application['idDiner'], $diner_application['name'], 
					$diner_application['street'] . ' ' . $diner_application['streetNumber'] . ' ' . (empty($diner_application['floor']) ? '' : $diner_application['floor']) . ' ' . (empty($diner_application['door']) ? '' : $diner_application['door']), 
					$diner_application['mail']);
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
		$diner_aplication = new stdClass();
		$diner_aplication->id 			= $id != NULL ? $id : $this->input->post('id');
		$diner_aplication->description 	= $this->input->post('reject_reason');
		return $diner_aplication;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->user_name = '';
		$this->form_data->surname = '';
		$this->form_data->user_mail = '';
		$this->form_data->diner_name = '';
		$this->form_data->street = '';
		$this->form_data->streetNumber = '';
		$this->form_data->floor = '';
		$this->form_data->door = '';
		$this->form_data->diner_phone = '';
		$this->form_data->photo = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('code', 'Código', 'trim|required');
	}
	
	/**
	 * Funcion que llena los campos del formulario en base a un objeto
	 * @param  array 	$diner_application
	 * @return void
	 */
	private function _fill_form($diner_application)
	{
		$this->form_data->user_name = $diner_application['user']['name'];
		$this->form_data->surname = $diner_application['user']['surname'];
		$this->form_data->user_mail = $diner_application['user']['mail'];
		$this->form_data->diner_name = $diner_application['diner']['name'];
		$this->form_data->street = $diner_application['diner']['street'];
		$this->form_data->streetNumber = $diner_application['diner']['streetNumber'];
		$this->form_data->floor = $diner_application['diner']['floor'];
		$this->form_data->door = $diner_application['diner']['door'];
		$this->form_data->diner_phone = $diner_application['diner']['phone'];
		$this->form_data->photo = isset($diner_application['photos'][0]['url']) ? $diner_application['photos'][0]['url'] : base_url('img/sin_imagen.png');
	}
}