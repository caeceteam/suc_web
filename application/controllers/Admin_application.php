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
		$this->load->library(array('form_validation', 'session', 'email'));
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
		$this->render_table(NULL, $this->Diner_application_model->search(NULL,DINER_PENDING)['diners']);
		$this->load->view('admin_application/search', $this->variables);
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
		if(!$this->input->post('aprobar') && !$this->input->post('rechazar'))
		{
			$this->session->diner_application = $this->Diner_application_model->search($id);
			$this->_fill_form($this->session->diner_application);
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			if($this->form_validation->run() == FALSE)
			{
				$this->variables['message']= validation_errors();
			}
			else if($this->Diner_application_model->edit($this->_get_post())!=NULL)
			{
				if($this->_send_mail($this->session->diner_application))
					$this->variables['message'] = 'Se envío un mail con el estado de la solicitud.';
				else
					$this->variables['message'] = 'Ocurrio un error al enviar el mail.';
				redirect('admin_application');//@TODO Pasarlo al refactor (input_type) que hizo Cris
			}
			else
			{
				$this->variables['message'] = 'Error al editar';
			}
		}
		$this->load->view('admin_application/save', $this->variables);
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
	 * @param 		integer 	$id id del diner para cuando se trata de una edición
	 * @return		object		$diner_application
	 */
	private function _get_post($id=NULL)
	{
		$diner_application = $this->session->diner_application;
		$diner_application['diner']['state'] = ($this->input->post('aprobar')) ? DINER_APPROVED : DINER_REJECTED;
		$diner_application['user']['state'] = ($this->input->post('aprobar')) ? USER_ACTIVE : USER_INACTIVE;
		$diner_application['diner']['description'] = 
		($this->input->post('reject_reason')) !== NULL ? $diner_application['diner']['description'] . ' Motivo de rechazo: ' . $this->input->post('reject_reason') : $diner_application['diner']['description'];
		$this->session->set_userdata('diner_application', $diner_application);
		return $this->session->diner_application['diner'];
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
		$this->form_data->reject_reason = '';
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('reject_reason', 'Motivo de rechazo', 'trim');
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
	
	/**
	 * Función que envia un mail a un destinatario indicando el estado de su solicitud
	 * @param    $diner_application 	array  array del diner application
	 * @return   bool 					indica si el mail se pudo enviar
	 */
	private function _send_mail($diner_application)
	{
		$this->email->from('suc@no-reply.com', 'Sistema Único de Comedores');
		$this->email->to($diner_application['user']['mail']);
		$this->email->subject('Estado de solicitud de alta de comedor');
		if($diner_application['diner']['state'] == DINER_APPROVED)
		{
			$this->email->message('Su solicitud ha sido aprobada. <br/>
			Ya puede comenzar a administrar su comedor. <br/>
			Ingrese desde ' . base_url('admin_application') . ' .<br/>');
		}
		else
		{
			$this->email->message('Su solicitud ha sido rechazada. <br/>
			Motivo de rechazo: ' . $this->input->post('reject_reason') . ' .<br/>
			Por favor vuelva a completar la solicitud. <br/>');
		}
		$this->email->set_newline("\r\n");//Sin esta línea falla el envio
		return $this->email->send();
	}
}