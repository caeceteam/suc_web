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
		$this->variables['includes']='<script src="'.base_url('js/bootstrapValidator.js').'"></script>';
		$this->variables['includes']= $this->variables['includes'].'<script src="'.base_url('js/jquery.easy-autocomplete.js').'"></script>';
		$this->variables['includes']= $this->variables['includes'].'<script src="'.base_url('js/valida_torneo.js').'"></script>';
		$this->variables['includes']= $this->variables['includes'].'<link rel="stylesheet" href="'.base_url('css/easy-autocomplete.min.css').'" />';
		$this->variables['includes']= $this->variables['includes'].'<link rel="stylesheet" href="'.base_url('css/easy-autocomplete.themes.min.css').'" />';
		$this->variables['accion'] = site_url('persona/alta');
		$this->variables['id_torneo'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->_setear_campos();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->load->view('templates/header', $this->variables);
		$this->_renderizar_torneos();
		$this->load->view('torneos/principal_torneo', $this->variables);
		$this->load->view('templates/footer');
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
	private function _obtener_post($id_torneo=NULL)
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
	 * Funcion que renderiza los ultimos torneos creados
	 * 
	 */
	private function _renderizar_torneos()
	{
		$fecha = getdate();
		$torneos = $this->Torneo_model->consulta(NULL, $fecha['year']);
		$link_torneo = site_url('torneo/editar');
		$html = '';
		foreach ($torneos as $i)
		{
			$link_torneo = $link_torneo . '/' . $i['id_torneo'];
			$html = $html . '<div class="form-group col-md-4"><a href="' . $link_torneo . '" class="btn btn-link">' . $i['nombre'] . '</a></div>';
			$link_torneo = site_url('torneo/editar');
		}
		$this->variables['torneos']=$html;
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
		
	/**
	 * Funcion que completa el combo de modalidades si no recibe ningún parametro, sino muestra el combo con el id que recibe
	 * @param 		integer 	$id_tipo_modalidad
	 * @return void
	 */
	private function _obtener_combo_modalidad($id_tipo_modalidad=NULL)
	{
		$modalidades = $this->Torneo_model->consulta_tipo_modalidad();
		$descripcion[''] = "[SELECCIONE]";
		foreach ($modalidades as $i)
		{
			$descripcion[$i['id_tipo_modalidad']] = $i['descripcion'];
		}
		$this->variables['modalidades']=$descripcion;
		$this->variables['modalidad']= isset($id_tipo_modalidad) ? $id_tipo_modalidad : '';
	}
}