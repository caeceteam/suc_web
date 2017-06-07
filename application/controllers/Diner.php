<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diner extends CI_Controller {

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
		$this->load->model('Diner_model');
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
		$this->render_table(NULL, $this->Diner_model->search());
		$this->load->view('diner/search', $this->variables);
	}
	
	/**
	 * Funcion de consulta
	 * @param		string	$name
	 * @return void
	 */
	public function search($name=NULL)
	{
		if ($name!=NULL){
			$diner = $this->Diner_model->search($name);
			$this->render_table(NULL, $diner);
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
		$this->variables['action'] = site_url('diner/edit');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if(!$this->input->post('name'))
		{
			$diner = $this->Diner_model->search($id)['diner'];
			$this->form_data->id = $diner["idDiner"];
			$this->form_data->name = $diner["name"];
			$this->form_data->street = $diner["street"];
			$this->form_data->streetNumber = $diner["streetNumber"];
			$this->form_data->floor = $diner["floor"];
			$this->form_data->door = $diner["door"];
			$this->form_data->latitude = $diner["latitude"];
			$this->form_data->longitude = $diner["longitude"];
			$this->form_data->zipCode = $diner["zipCode"];
			$this->form_data->phone = $diner["phone"];
			$this->form_data->description = $diner["description"];
			$this->form_data->link = $diner["link"];
			$this->form_data->mail = $diner["mail"];
			$this->form_data->idCity = $diner["idCity"];
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$diner = new stdClass();
			if($this->form_validation->run() == FALSE)
			{
				$this->variables['message']= validation_errors();
			}
			else if($this->Diner_model->edit($this->_get_post())!= NULL)
			{
				$this->variables['message'] = 'Datos editados!';
			}
			else
			{
				$this->variables['message'] = 'Error al editar';
			}
		}
		$this->load->view('diner/save', $this->variables);
	}
	
	/**
	 * Funcion de baja
	 * @param		string	$id
	 * @return void
	 */
	public function delete($id = NULL)
	{
		$this->Diner_model->delete($id);
		$this->index();
	}
	
	/**
	 * Renderiza una tabla en base a un template HTML y un object|array
	 * @param		string		$template
	 * @param		mixed 		object|array Puede recibir un objeto de un diner o un array de varios
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
				array('data' => 'Nombre', 'data-column-id' => 'Nombre'), 
				array('data' => 'Email', 'data-column-id' => 'Email'),
				array('data' => 'Dirección', 'data-column-id' => 'Dirección'),
				array('data' => 'Modificar', 'data-column-id' => 'commands', 'data-formatter' => 'commands', 'data-sortable' => 'false') 
				);
		foreach ($data as $diner)
		{
			$this->table->add_row($diner['idDiner'], $diner['name'], $diner['mail'], $diner['street'] . " " . $diner['streetNumber']);
		}
		$this->variables['table'] = $this->table->generate();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del diner para cuando se trata de una edición
	 * @return		object		$diner
	 */
	private function _get_post($id=NULL)
	{
 		$diner = new stdClass();
 		$diner->id = $id != NULL ? $id : $this->input->post('id');
 		$diner->name = $this->input->post('name');
 		$diner->street = $this->input->post('street');
 		$diner->streetNumber = $this->input->post('streetNumber');
 		$diner->floor = $this->input->post('floor');
 		$diner->door = $this->input->post('door');
 		$diner->latitude = $this->input->post('latitude');
 		$diner->longitude = $this->input->post('longitude');
 		$diner->zipCode = $this->input->post('zipCode');
 		$diner->phone = $this->input->post('phone');
 		$diner->description = $this->input->post('description'); 		
 		$diner->link = $this->input->post('link');
 		$diner->mail = $this->input->post('mail');
 		$diner->idCity = $this->input->post('idCity'); 		
 		return $diner;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->id = '';
		$this->form_data->name = '';
		$this->form_data->street = '';
		$this->form_data->streetNumber = '';
		$this->form_data->floor = '';
		$this->form_data->door = '';
		$this->form_data->latitude = '';
		$this->form_data->longitude = '';
		$this->form_data->zipCode = '';
		$this->form_data->phone = '';
		$this->form_data->description = '';
		$this->form_data->link = '';
		$this->form_data->mail = '';
		$this->form_data->idCity = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('mail', 'Mail', 'trim|required');
		$this->form_validation->set_rules('street', 'Calle', 'trim|required');
		$this->form_validation->set_rules('phone', 'Telefono', 'trim|required');
	}
}