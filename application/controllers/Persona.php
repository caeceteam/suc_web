<?php
class Persona extends CI_Controller {
	
	/**
	 * Array para guardar todas las variables de la pagina
	 * @var array
	 */
	public $variables;
	
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
		//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->datos_formulario = new stdClass();
		$this->load->model('Persona_model');
		$this->load->helper(array('url_helper', 'form'));
		$this->load->library('form_validation');
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->_setear_variables(lang('html_persona_titulo_default'), '', site_url('persona/consulta'), '', '');
		$this->_renderizar_tabla(NULL, $this->Persona_model->consulta());
		$this->load->view('templates/header', $this->variables);
		$this->load->view('personas/buscar_persona', $this->variables);
		$this->load->view('templates/footer');
	}

	/**
	 * Funcion de consulta por CUIL
	 * @return void
	 */
	public function consulta()
	{
		$this->_setear_variables(lang('html_persona_titulo_consulta'), '', site_url('persona/consulta'), '', '');
		$cuil = $this->input->post('cuil');
		if ($cuil!=NULL){
			$persona = $this->Persona_model->consulta($cuil);
			$this->_renderizar_tabla(NULL, $persona);
			$this->load->view('templates/header', $this->variables);
			$this->load->view('personas/buscar_persona', $this->variables);
			$this->load->view('templates/footer');
		}
		else
			$this->index();
	}
	
	/**
	 * Funcion que muestra el formulario de alta y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function alta()
	{
		$this->_setear_variables(lang('html_persona_titulo_alta'), '', site_url('persona/alta'), anchor('persona',lang('html_persona_button_cancelar'),array('class'=>'btn btn-danger', 'role'=> 'button')), '');
		$this->_setear_campos();
		$this->_setear_reglas();
		if($this->form_validation->run() == FALSE)
		{
			$this->variables['mensaje']= validation_errors();
		}
		else if($this->Persona_model->alta($this->_obtener_post())['resultado']='OK')
		{

			$this->variables['mensaje'] = '<div class="alert alert-success"><a href="#" class="close" variables-dismiss="alert" aria-label="close">&times;</a>'.lang('html_persona_mensaje_ok').'</div>';
		}
		else
		{
			$this->variables['mensaje'] = '<div class="alert alert-danger">'.lang('html_persona_mensaje_error').'</div>';
		}
		$this->load->view('templates/header', $this->variables);
		$this->load->view('personas/grabar_persona', $this->variables);
		$this->load->view('templates/footer');
	}
	
	/**
	 * Funcion que muestra los datos de un cuil
	 * @return void
	 */
	public function ver($cuil = NULL)
	{
		$this->variables['personas_item'] = $this->Persona_model->consulta($cuil);
		$this->_setear_variables(lang('html_persona_titulo_ver'), '', '', '', anchor('persona',lang('html_persona_button_volver'),array('class'=>'btn btn-primary', 'role'=> 'button')));
		if (empty($this->variables['personas_item']))
		{
			show_404();
		}
		$this->variables['nombre'] = $this->variables['personas_item']->nombre;
		$this->load->view('templates/header', $this->variables);
		$this->load->view('personas/ver_persona', $this->variables);
		$this->load->view('templates/footer');
	}
	
	/**
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function editar($cuil=NULL)
	{
		$this->_setear_variables(lang('html_persona_titulo_modificar'), '', site_url('persona/editar'), anchor('persona',lang('html_persona_button_cancelar'),array('class'=>'btn btn-danger', 'role'=> 'button')), '');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if(!$this->input->post('cuil'))
		{	
			$persona = $this->Persona_model->consulta($cuil);
			$this->datos_formulario->cuil = $persona->cuil;
			$this->datos_formulario->nombre = $persona->nombre;
			$this->datos_formulario->apellido = $persona->apellido;
			$this->datos_formulario->mail = $persona->mail;
		}
		else
		{
			$this->_setear_campos();
			$this->_setear_reglas();
			$persona = new stdClass();
			if($this->form_validation->run() == FALSE)
			{
				$this->variables['mensaje']= validation_errors();
			}
			else if($this->Persona_model->editar($this->_obtener_post())['resultado']='OK')
			{
			
				$this->variables['mensaje'] = '<div class="alert alert-success"><a href="#" class="close" variables-dismiss="alert" aria-label="close">&times;</a>'.lang('html_persona_mensaje_ok').'</div>';
			}
			else
			{
				$this->variables['mensaje'] = '<div class="alert alert-danger">'.lang('html_persona_mensaje_error').'</div>';
			}
		}
		$this->load->view('templates/header', $this->variables);
		$this->load->view('personas/grabar_persona', $this->variables);
		$this->load->view('templates/footer');
	}
	
	/**
	 * Funcion de baja
	 * @return void
	 */
	public function baja($cuil = NULL)
	{
		$this->Persona_model->baja($cuil);
		$this->index();
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
 	 * @return		object		$persona			
	 */
	private function _obtener_post()
	{
		$persona = new stdClass();
		$persona->cuil 		= $this->input->post('cuil');
		$persona->nombre 	= $this->input->post('nombre');
		$persona->apellido 	= $this->input->post('apellido');
		$persona->mail 		= $this->input->post('mail');
		return $persona;
	}
	
	/**
	 * Renderiza una tabla en base a un template HTML y un object|array
	 * @param		string		$template
	 * @param		mixed 		object|array Puede recibir un objeto de una persona o un array de varias
	 * @return		void
	 */
	private function _renderizar_tabla($template=NULL, $datos)
	{
		//Si los datos a renderizar son un objeto, es porque vino un único registro, se convierte a array para poder iterar el el foreach de mas abajo
		if(is_object($datos))
		{	
			$array[0] = get_object_vars($datos);
			$datos = $array;
		}
		$template = isset($template) ? $template : array('table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="table table-striped">');
		$this->load->library('table');
		$this->table->set_template($template);
		$this->table->set_heading(lang('html_persona_label_cuil'), lang('html_persona_label_nombre'), lang('html_persona_label_apellido'), lang('html_persona_label_mail'), lang('html_grilla_acciones'));
		foreach ($datos as $persona)
		{
			$this->table->add_row($persona['cuil'], $persona['nombre'], $persona['apellido'], $persona['mail'],
					anchor('persona/ver/'.$persona['cuil'],lang('html_persona_button_ver'),array('class'=>'view')).' '.
					anchor('persona/editar/'.$persona['cuil'],lang('html_persona_button_modificar'),array('class'=>'update')).' '.
					anchor('persona/baja/'.$persona['cuil'],lang('html_persona_button_eliminar'),array('class'=>'delete','onclick'=>"return confirm('".lang('html_persona_mensaje_confirmacion')."')"))
					);
		}
		$this->variables['tabla'] = $this->table->generate();
	}
	
	/**
	 * Funcion que setea las parametros basicos de las variables de la pagina
	 * @return void
	 */
	private function _setear_variables($titulo=NULL, $mensaje=NULL, $accion=NULL, $cancelar=NULL, $volver=NULL)
	{
		$this->variables['titulo'] = $titulo;
		$this->variables['mensaje'] = $mensaje;
		$this->variables['accion'] = $accion;
		$this->variables['cancelar'] = $cancelar;
		$this->variables['volver'] = $volver;
	}
	
	/**
	 * Funcion que limpia los campos del formulario
	 * @return void
	 */
	private function _setear_campos()
	{
		$this->datos_formulario->cuil = '';
		$this->datos_formulario->nombre = '';
		$this->datos_formulario->apellido = '';
		$this->datos_formulario->mail = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @todo traducir los mensajes de errores en los archivos de configuracion para no tener que usar set_messsage
	 * @return void
	 */
	private function _setear_reglas()
	{
		$this->form_validation->set_rules('cuil', 'Cuil', 'trim|required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('apellido', 'Apellido', 'trim|required');
		$this->form_validation->set_rules('mail', 'Mail', 'trim|required|valid_email');
	
		$this->form_validation->set_message('required', 'El {field} es obligatorio');
		$this->form_validation->set_message('isset', 'El {field} es obligatorio');
		$this->form_validation->set_message('valid_email', 'El {field} debe ser valido');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a href="#" class="close" variables-dismiss="alert" aria-label="close">&times;</a>', '</div>');
	}
	
	/**
	 * Funcion que realiza un alta y la devuelve encodeada en JSON para ser consumida desde una llamada por AJAX
	 * @return string En formato JSON
	 */
	public function ax_alta()
	{
		echo json_encode($this->Persona_model->alta($this->_obtener_post()));
	}
}