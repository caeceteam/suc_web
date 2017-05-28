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
		$this->load->model('Torneo_model');
		$this->datos_formulario = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['accion'] = site_url('persona/alta');
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->_setear_campos();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->_renderizar_torneos();
		$this->load->view('torneos/principal_torneo', $this->variables);
	}
	
	/**
	 * Funcion que realiza una búsqueda por nombre de torneo
	 * @return void
	 */
	public function obtener_autocomplete($nombre=NULL)
	{
		echo json_encode($this->Torneo_model->consulta(NULL, NULL, $nombre));
	}
	
	/**
	 * Funcion que muestra el formulario de alta y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function alta()
	{
		$this->load->view('templates/header', $this->variables);
		$this->_setear_variables('', '', site_url('torneo/alta'), site_url('torneo'), '', '');
		$this->_obtener_combo_modalidad();
		$this->_setear_reglas();
		if($this->form_validation->run() == FALSE)
		{
			$this->variables['mensaje']= validation_errors();
		}
		else
		{
			if($this->Torneo_model->alta($this->_obtener_post())['resultado']='OK')
			{	
				$this->variables['mensaje'] = lang('message_guardar_ok');
				$this->variables['reset'] = TRUE;
			}
			else
			{
				$this->variables['mensaje'] = lang('message_guardar_error');
			}
		}
		$this->_renderizar_torneos();
		$this->load->view('torneos/principal_torneo', $this->variables);
		$this->load->view('torneos/datos_torneo', $this->variables);
		$this->load->view('templates/footer');
	}
	
	/**
	 * Funcion que muestra el formulario de edición y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function editar($id_torneo=NULL)
	{
		$this->load->view('templates/header', $this->variables);
		$this->_setear_variables('', '', site_url('torneo/editar'), site_url('torneo'), '', site_url('torneo/baja') . '/' . ($id_torneo==NULL ? $this->input->post('id_torneo') : $id_torneo));
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if(!$this->input->post('nombre'))
		{
			$this->datos_formulario->id_torneo=$id_torneo;
			$torneo = $this->Torneo_model->consulta($id_torneo);
			$this->datos_formulario->nombre = $torneo->nombre;
			$this->datos_formulario->cantidad_equipos = $torneo->cantidad_equipos;
			$this->datos_formulario->id_tipo_modalidad = $torneo->id_tipo_modalidad;
			$this->_obtener_combo_modalidad($this->datos_formulario->id_tipo_modalidad);
		}
		else
		{
			$this->_setear_reglas();
			$torneo = new stdClass();
			if($this->form_validation->run() == FALSE)
			{
				$this->variables['mensaje']= validation_errors();
			}
			else if($this->Torneo_model->editar($this->_obtener_post($this->datos_formulario->id_torneo))['resultado']='OK')
			{
					
				$this->variables['mensaje'] = lang('message_guardar_cambios_ok');
			}
			else
			{
				$this->variables['mensaje'] = lang('message_guardar_error');;
			}
			$this->_obtener_combo_modalidad($this->input->post('id_tipo_modalidad'));
		}
		$this->_renderizar_torneos();
		$this->load->view('torneos/principal_torneo', $this->variables);
		$this->load->view('torneos/datos_torneo', $this->variables);
		$this->load->view('templates/footer');
	}
	
	/**
	 * Funcion de baja
	 * @return void
	 */
	public function baja($id_torneo=NULL)
	{
		$torneo = new stdClass();
		$torneo->id_torneo = $id_torneo;
		$this->Torneo_model->baja($torneo);
		//$this->index();
		redirect(site_url('torneo'));
	}
	
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @param 		integer 	$id_torneo id del torneo para cuando se trata de una edición
	 * @return		object		$persona
	 */
	private function _obtener_post($id=NULL)
	{
		$fecha = getdate();
		$torneo = new stdClass();
		$torneo->id_torneo 			= $id_torneo = '' ? $id_torneo : $this->input->post('id_torneo');
		$torneo->nombre 			= $this->input->post('nombre');
		$torneo->cantidad_equipos 	= $this->input->post('cantidad_equipos');
		$torneo->id_tipo_modalidad 	= $this->input->post('id_tipo_modalidad');
		$torneo->id_liga			= '1';// @todo Por el momento hay una única liga
		$torneo->id_usuario			= '1';// @todo Pasar el usuario logueado
		$torneo->anio				= $fecha['year'];
		return $torneo;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _setear_campos()
	{
		$this->datos_formulario->id_torneo = '';
		$this->datos_formulario->nombre = '';
		$this->datos_formulario->cantidad_equipos = '';
		$this->datos_formulario->id_tipo_modalidad = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @todo traducir los mensajes de errores en los archivos de configuracion para no tener que usar set_messsage
	 * @return void
	 */
	private function _setear_reglas()
	{
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('cantidad_equipos', 'Cantidad de equipos', 'trim|required');
		$this->form_validation->set_rules('id_tipo_modalidad', 'Modalidad de juego', 'required');
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
	private function _setear_variables($titulo=NULL, $mensaje=NULL, $accion=NULL, $cancelar=NULL, $volver=NULL, $eliminar=NULL)
	{
		$this->variables['titulo'] 		= $titulo;
		$this->variables['mensaje'] 	= $mensaje;
		$this->variables['accion'] 		= $accion;
		$this->variables['cancelar'] 	= $cancelar;
		$this->variables['volver'] 		= $volver;
		$this->variables['eliminar']	= $eliminar;
		$this->variables['modalidades']	= '';
		$this->variables['modalidad']	= '';
	}
}