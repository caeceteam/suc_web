<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*******************************************************************************************************
 * CLASE USER_DINER
 ********************************************************************************************************
 * HISTORIA: HU021
 * TITULO: Usuario comedor    
 * @return void
 ******************************************************************************************************/
class User_diner extends CI_Controller {


	// Array para guardar todas las variables de la pagina
	private $variables;
	
	// Array para guardar exclusivamente los values del formulario
	public $form_data; 
	 
	/**
	 * Constructor de clase
	 * Se encarga de hacer el load de los modulos necesarios
	 * @return void
	 */	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('url', 'form'));
		$this->load->model('User_diner_model');
//...Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->form_data = new stdClass();
		$this->variables['id'] = '';

//...Variable para indicar si hay que resetear los campos del formulario
		$this->variables['reset'] = FALSE;
		$this->_initialize_fields();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */	public function index()
	{
		$this->render_table(NULL, $this->User_diner_model->search());
		$this->load->view('user_diner/search', $this->variables);
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
			$food_type = $this->User_diner_model->search($name);
			$this->render_table(NULL, $user_diner);
			/*$this->load->view('templates/header', $this->variables);
			$this->load->view('personas/buscar_persona', $this->variables);
			$this->load->view('templates/footer');*/
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
		$this->variables['action'] = site_url('user_diner/add');
		$this->_set_rules();
		if($this->form_validation->run() == FALSE)
		{
			$this->variables['message']= validation_errors();
		}
		else
		{
			if(($this->User_diner_model->add($this->_get_post()))!=NULL)
			{
				$this->variables['message'] = 'Datos grabados!';
				$this->variables['reset'] = TRUE;
			}
			else
			{
				$this->variables['message'] = 'Error al guardar';
			}
		}
		$this->load->view('user_diner/save', $this->variables);
	}
		
	/**
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la validacion 
	 * del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */	
	public function edit($id=NULL)
	{
		$this->variables['action'] = site_url('user_diner/save');
//...Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if(!$this->input->post('name'))
		{
			$user_diner = $this->User_diner_model->search($id)['userDiner'];
			$this->form_data->id          = $user_diner['idUser'];
			$this->form_data->name        = $user_diner['name'];
			$this->form_data->surname     = $user_diner['sername'];
			$this->form_data->alias       = $user_diner['alias'];
			$this->form_data->pass        = $user_diner['pass'];
			$this->form_data->mail        = $user_diner['mail'];
			$this->form_data->idDiner     = $user_diner['idDiner'];
			$this->form_data->phone       = $user_diner['phone'];
			$this->form_data->sate        = $user_diner['state'];
			$this->form_data->role        = $user_diner['role'];
			$this->form_data->docNumber   = $user_diner['docNumber'];
			$this->form_data->bornDate    = $user_diner['bornDate'];
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
			else if($this->User_diner_model->edit($this->_get_post())!=NULL)
			{
				$this->variables['message'] = 'Datos editados!';
			}
			else
			{
				$this->variables['message'] = 'Error al editar';
			}
		}
		$this->load->view('user_diner/save', $this->variables);
	}
	
	/**
	 * Funcion de baja
	 * @param		string	$id
	 * @return void
	 */
	public function delete($id = NULL)
	{
		$this->User_diner_model->delete($id);
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
		
//...Cabecera de la tabla
		$this->table->set_heading(
				array('data' => 'IdUser'     , 'data-column-id' => 'idUser' , 'data-visible' => 'false'),
		        array('data' => 'Comedor'    , 'data-column-id' => 'idDiner', 'data-order'   => 'desc' ),
		        array('data' => 'Nombre'     , 'data-column-id' => 'name'   , 'data-order'   => 'desc' ),
		        array('data' => 'Apellido'   , 'data-column-id' => 'surname'   ),
		        array('data' => 'Apodo'      , 'data-column-id' => 'alias'     ),
		        array('data' => 'Correo'     , 'data-column-id' => 'mail'      ), 
		        array('data' => 'Telefono'   , 'data-column-id' => 'phone'     ),
		        array('data' => 'Rol'        , 'data-column-id' => 'role'      ),
		        array('data' => 'Telefono'   , 'data-column-id' => 'docNumber' ),
		        array('data' => 'Fecha Nac.' , 'data-column-id' => 'bornDate'  ),
		        array('data' => 'Modificar/Borrar', 'data-column-id' => 'commands', 'data-formatter' => 'commands', 'data-sortable' => 'false') 
				);
		
//...Recupero datos en base al set_heading		
		foreach ($data as $user_diner)
		{
			$this->table->add_row(   $user_diner['idUser'], 
			                         $user_diner['idDiner'], 
			                         $user_diner['name'], 
			                         $user_diner['surname'],
			        			     $user_diner['alias'], 
			                         $user_diner['mail'], 
			                         $user_diner['phone'],
						             $user_diner['role'], 
			                         $user_diner['docNumber'], 
			                         $user_diner['bornDate']);
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
		$user_diner = new stdClass();
		$user_diner->idUser 		= $id != NULL ? $id : $this->input->post('idUser');
		$user_diner->idDiner		= $this->input->post('idDiner');
		$user_diner->name 			= $this->input->post('name');
		$user_diner->surname 	    = $this->input->post('surname');
		$user_diner->alias 			= $this->input->post('alias');
		$user_diner->mail 			= $this->input->post('mail');
		$user_diner->phone 	        = $this->input->post('phone');
		$user_diner->role 			= $this->input->post('role');
		$user_diner->docNumber 		= $this->input->post('docNumber');
		$user_diner->bornDate 	    = $this->input->post('bornDate');
		return $user_diner;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->idUser    = '';
		$this->form_data->idDiner   = '';
		$this->form_data->name      = '';
		$this->form_data->surname   = '';
		$this->form_data->alias     = '';
		$this->form_data->mail      = '';
		$this->form_data->phone     = '';
		$this->form_data->role      = '';
		$this->form_data->docNumber = '';
		$this->form_data->bornDate  = '';
	
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('idDiner', 'id Comedor', 'trim|required');
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('surname', 'Apellido', 'trim');
		$this->form_validation->set_rules('mail', 'Mail', 'trim');
	}
}