<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*******************************************************************************************************
 * CLASE FOOD_TYPE
 ********************************************************************************************************
 * HISTORIA: HU011
 * TITULO: Tipo de Alimento      
 * @return void
 ******************************************************************************************************/
class Food_type extends CI_Controller {


	// Array para guardar todas las variables de la pagina
	private $variables;
	private $pass;
	
	// Array para guardar exclusivamente los values del formulario
	public  $form_data; 

	 
	/**
	 * Constructor de clase
	 * Se encarga de hacer el load de los modulos necesarios
	 * @return void
	 */	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation', 'login'));
		$this->load->helper(array('url', 'form'));
		$this->load->model('Food_type_model');
		//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->form_data = new stdClass();
		$this->variables['id'] = '';
		//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['reset'] = FALSE;
		$this->_initialize_fields();
		$this->login->is_logged_in();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */	public function index()
	{
		$this->render_table(NULL, $this->Food_type_model->search()['foodTypes']);
		$this->load->view('food_type/search', $this->variables);
	}
	
	/**
	 * Funcion de consulta
	 * @param		string	$name
	 * @return void
	 */
	 public function search($name=NULL)
	{
		if ($name!=NULL){
			$food_type = $this->Food_type_model->search($name);
			$this->render_table(NULL, $food_type);
		}
		else
			$this->index();
	}
	
	/**
	 * Funcion que muestra el formulario de alta y guarda 
	 * la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function add()
	{
		$this->variables['action'] = site_url('food_type/add');
		$this->_set_rules();
		if($this->form_validation->run() == FALSE)
		{
			$this->variables['message']= validation_errors();
		}
		else
		{
			if(($this->Food_type_model->add($this->_get_post()))!=NULL)
			{
				$this->variables['message'] = 'Datos grabados!';
				$this->variables['reset'] = TRUE;
			}
			else
			{
				$this->variables['message'] = 'Error al guardar';
			}
		}
		$this->load->view('food_type/save', $this->variables);
		$this->pass = '';
		
	}
	
	/**
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la validacion 
	 * del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */	
	public function edit($id=NULL)
	{
		$this->variables['action'] = site_url('food_type/edit');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if(!$this->input->post('name'))
		{
			$food_type                       = $this->Food_type_model->search($id);
			$this->form_data->id             = $food_type['idFoodType'];
			$this->form_data->code           = $food_type['code'];
			$this->form_data->name           = $food_type['name'];
			$this->form_data->description    = $food_type['description'];
			$this->form_data->perishable     = $food_type['perishable'];
			$this->form_data->celiac         = $food_type['celiac'];
			$this->form_data->diabetic       = $food_type['diabetic'];
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$food_type = new stdClass();
			if($this->form_validation->run() == FALSE)
			{
				$this->variables['message']= validation_errors();
			}
			else if($this->Food_type_model->edit($this->_get_post())!=NULL)
			{
				$this->variables['message'] = 'Datos editados!';
			}
			else
			{
				$this->variables['message'] = 'Error al editar';
			}
		}
		$this->load->view('food_type/save', $this->variables);
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
	 * Renderiza una tabla en base a un template HTML y un object|array
	 * @param		string		$template
	 * @param		mixed 		object|array Puede recibir un objeto de un food type o un array de varios
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
		
		foreach ($data as $food_type)
		{
			$this->table->add_row($food_type['idFoodType'], $food_type['code'], $food_type['name'], $food_type['description']);
		}
		$this->variables['table'] = $this->table->generate();
	}
	
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id id del food type para cuando se trata de una edición
	 * @return		object		$foodtype
	 */
	private function _get_post($id=NULL)
	{
		$food_type = new stdClass();
		$food_type->id 			  = $id != NULL ? $id : $this->input->post('id');
		$food_type->code 		  = $this->input->post('code');
		$food_type->name 		  = $this->input->post('name');
		$food_type->description   = $this->input->post('description');
		$food_type->perishable    = $this->input->post('perishable')  == null ? 0 : $this->input->post('perishable');
		$food_type->celiac        = $this->input->post('celiac')      == null ? 0 : $this->input->post('celiac');
		$food_type->diabetic      = $this->input->post('diabetic')    == null ? 0 : $this->input->post('diabetic');
		return $food_type;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->id          = '';
		$this->form_data->code        = '';
		$this->form_data->name        = '';
		$this->form_data->description = '';
		$this->form_data->perishable  = '';
		$this->form_data->celiac      = '';
		$this->form_data->diabetic    = '';
		//$this->variables['si_no']     = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('code', 'Código', 'trim|required');
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('description',  'Descripción',      'trim');
		$this->form_validation->set_rules('perishable',   'Predecedero',    'trim');
		$this->form_validation->set_rules('celiac',       'Apto celiaco',   'trim');
		$this->form_validation->set_rules('diabetic',     'Apto Diabetico', 'trim');
	}
	
	/**
	 * Funcion que completa el combo de modalidades si no recibe ningún parametro, sino muestra el combo con el id que recibe
	 * @param         integer     $id_tipo_modalidad
	 * @return void
	 */
	private function _obtener_combo_si_no($id_si_no=NULL)
	{
	    //$modalidades = $this->Torneo_model->consulta_tipo_modalidad();
	    //$descripcion[''] = "[SELECCIONE]";
	    /*foreach ($modalidades as $i)
	    {
	        $descripcion[$i['id_tipo_modalidad']] = $i['descripcion'];
	    }
	    */
	    $descripcion['1'] = 'Si';
	    $descripcion['0'] = 'No';
	        
	    $this->variables['si_no']          = $descripcion;
	    $this->variables['selected_si_no'] = isset($id_si_no) ? $id_si_no : '';
	}
}