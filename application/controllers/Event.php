<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

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
		$this->_cloudinary_init();
		$this->load->library(array('form_validation', 'email', 'upload', 'login'));
		$this->load->helper(array('url', 'form', 'file'));
		$this->load->helper('date');
		$this->load->model('Event_model');
		$this->form_data = new stdClass();//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->variables['id'] = '';
		$this->variables['reset'] = FALSE;//Variable para indicar si hay que resetear los campos del formulario
		$this->variables['controller-name'] = 'event';
		$this->_initialize_fields();
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->variables['data-request-url'] = site_url('event/render_table_response');
		$this->load->view('event/search', $this->variables);
	}
	
	/**
	 * Funcion que muestra el formulario de alta y guarda la misma cuando la validacion del formulario no arroja errores
	 * @return void
	 */
	public function add()
	{
		$this->variables['action'] = site_url('event/add');
		$this->_set_rules();
		$html_ok = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_error = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$html_close = '</div>';
		if($this->form_validation->run() == FALSE || $this->_save_image($_FILES['photo']['tmp_name']) == FALSE)
		{
			$this->variables['message'] = isset($this->variables['message']) ? $this->variables['message'].validation_errors() : validation_errors();
			$this->variables['message'] = $this->variables['message'] != '' ? $html_error . $this->variables['message'] . $html_close : '';
		}
		else
		{
			$event = ($this->_get_post());
			if(($this->Event_model->add($event))!=NULL)
			{
				if($this->_send_mail($event->name, $event->description, $event->street . $event->streetNumber))
					$this->variables['message'] = $html_ok . 'Se confirm� el Evento y se envi� un correo con copia de los datos' . $html_close;
				else 
					$this->variables['message'] = $html_error . 'Ocurri� un error al enviar el mail de confirmaci�n' . $html_close;
				$this->variables['reset'] = TRUE;
			}
			else
			{
				$this->variables['message'] = $html_error . 'Error al guardar' . $html_close;
			}
		}
		$this->load->view('event/save', $this->variables);
	}

	/**
	 * Funcion que muestra el formulario de edici�n y guarda la misma cuando la validacion
	 * del formulario no arroja errores
	 * @param		string	$id
	 * @return void
	 */
	public function edit($id=NULL)
	{
		$this->variables['action'] = site_url('event/edit');
		//Si no es un post, no se llama al editar y solo se muestran los campos para editar
		if(!$this->input->post('name'))
		{
			$event                       		= $this->Event_model->search_by_id($id);
			$this->form_data->id             	= $event['idEvent'];
			$this->form_data->name 			 	= $event['name'];
			$this->form_data->street 		 	= $event['street'];
			$this->form_data->streetNumber 		= $event['streetNumber'];
			$this->form_data->floor 			= $event['floor'];
			$this->form_data->door 				= $event['door'];
			$this->form_data->phone 			= $event['phone'];
			$this->form_data->latitude 			= $event['latitude'];
			$this->form_data->longitude			= $event['longitude'];
			$this->form_data->zipCode 			= $event['zipCode'];
			$this->form_data->description 		= $event['description'];
			$this->form_data->link 				= $event['link'];
			$this->form_data->date 				= $event['date'];
			//$this->form_data->time				= now();
			//$this->form_data->idCity 			= $event['idCity'];
			//$this->form_data->photo 			= $event['photo'];
		}
		else
		{
			$this->_initialize_fields();
			$this->_set_rules();
			$event = new stdClass();
			if($this->form_validation->run() == FALSE)
			{
				$this->variables['message']= validation_errors();
			}
			else if($this->Event_model->edit($this->_get_post())!=NULL)
			{
				$this->variables['message'] = 'Datos editados!';
			}
			else
			{
				$this->variables['message'] = 'Error al editar';
			}
		}
		$this->load->view('event/save', $this->variables);
	}
	/**
	 * Obtiene los datos del post y los devuelve en forma de objeto
	 * @return		object		$event
	 */
	private function _get_post()
	{
		$event 	= new stdClass();
		$event->name			= $this->input->post('name');
		$event->street			= $this->input->post('street');
		$event->streetNumber	= $this->input->post('streetNumber');
		$event->floor			= $this->input->post('floor');
		$event->door			= $this->input->post('door');
		$event->phone			= $this->input->post('phone');
		$event->latitude		= $this->input->post('latitude');
		$event->longitude		= $this->input->post('longitude');
		$event->zipCode			= $this->input->post('zipCode');
		$event->link			= $this->input->post('link');
		$event->date			= nice_date($this->input->post('date'), 'Y-m-d');
		$event->description		= $this->input->post('description');
		$event->photos[0] 		= $this->form_data->photo;//URL que devuelve la API de cloudinary, no se obtiene por post

		return $event;
	}
	
	/**
	 * Funcion que inicializa las variables de los campos del formulario para la edición
	 * @return void
	 */
	private function _initialize_fields()
	{
		$this->form_data->name = '';
		$this->form_data->street = '';
		$this->form_data->streetNumber = '';
		$this->form_data->floor = '';
		$this->form_data->door = '';
		$this->form_data->phone = '';
		$this->form_data->latitude = '';
		$this->form_data->longitude = '';
		$this->form_data->zipCode = '';
		$this->form_data->description = '';
		$this->form_data->link = '';
		$this->form_data->idCity = '';
		$this->form_data->photo = '';
		$this->form_data->date = '';
		$this->form_data->time = '';
	}
	
	/**
	* Funcion para retornar la informaci�n a cargar en las grillas con la estructura JSON requerida por bootgrid
	* @return		array		$event
	*/
	public function render_table_response()
	{
		$service_data = $this->Event_model->get_events_by_page($this->input->post('current') - 1);
		$pagination_data = $service_data['pagination'];
		$events_data = $service_data['events'];
	
		$render_data['current'] = (int)$this->input->post('current');
		$render_data['total'] = $pagination_data['total_elements'];
	
		$render_data['rows'] = [];
		foreach ($events_data as $event)
		{
			$row_data['id'] 			= $event['idEvent'];
			$row_data['idDiner'] 		= $event['idDiner'];
			$row_data['name'] 			= $event['name'];
			$row_data['date']			= nice_date($event['date'], 'Y-m-d');
			$row_data['street'] 		= $event['street'] . $event['streetNumber'];
			$row_data['phone'] 			= $event['phone'];
			array_push($render_data['rows'], $row_data);
		}
		echo json_encode($render_data, TRUE);
	}
	
	/**
	 * Funcion que setea las reglas de validacion del formulario y sus mensajes de errores
	 * @return void
	 */
	private function _set_rules()
	{
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('street', 'Calle', 'trim|required');
		$this->form_validation->set_rules('streetNumber', 'N�mero', 'trim|required');
		$this->form_validation->set_rules('floor', 'Piso', 'trim');
		$this->form_validation->set_rules('door', 'Departamento', 'trim');
		$this->form_validation->set_rules('phone', 'Tel�fono de contacto', 'trim');
		$this->form_validation->set_rules('latitude', 'Latitud', 'trim');
		$this->form_validation->set_rules('longitude', 'Longuitud', 'trim');
		$this->form_validation->set_rules('zipCode', 'CP', 'trim');
		$this->form_validation->set_rules('date', 'Fecha', 'trim');
		$this->form_validation->set_rules('link', 'P�gina', 'trim');
		$this->form_validation->set_rules('description', 'Descripci�n', 'trim');
	}
	
	
	/**
	 * Funci�n que envia un mail al creador del evento con los datos
	 * @param    $to 			string destinatario
	 * @param	 $name			string nombre del evento
	 * @param    $description 	string descripci�n del evento
	 * @param	 $street		string calle
	 * @return   bool 			indica si el mail se pudo enviar
	 */
	private function _send_mail($to, $name, $description, $date, $street)
	{
		$this->email->from('suc@no-reply.com', 'Sistema ښnico de Comedores');
		$this->email->to($to);
		$this->email->subject('Confirmaci�n de Evento');
		
		//Genero el array con los datos
		$data = array(
				'name'			=> $name,
				'description'	=> $description,
				'date'			=> $date,
				'street'		=> $street
		);
		$body = $this->load->view('email/event_confirm.php',$data ,TRUE); //cargo el PHP
		$this->email->message($body); //adjunto el php al cuerpo del mail
		
		$this->email->set_newline("\r\n");//Sin esta l�nea falla el env�o
		return $this->email->send();
	}
	
	/**
	 * Función que guarda una imagen en la nube usando la API de cloudinary
	 * @param    $photo 	string ruta de la imagen a guardar
	 * @return   bool 		indica si la imagen se guardo correctamente
	 */
	private function _save_image($photo)
	{
		if (!$this->upload->do_upload('photo'))
		{
			$this->variables['message'] = $this->upload->display_errors();
			return false;
		}
		else
		{
			$response = \Cloudinary\Uploader::upload($photo);//La subo a cloudinary
			$this->form_data->photo = $response['url'];
			delete_files('uploads', FALSE, TRUE);
			return true;
		}
	}
	
	/**
	 * Funci�n que configura la API de cloudinary
	 * @return   void
	 */
	private function _cloudinary_init()
	{
		\Cloudinary::config(array(
				"cloud_name" 	=> "caeceteam",
				"api_key" 		=> "779344883826737",
				"api_secret" 	=> "A2e2eESuMFPc-fXK9Xz3plHSB2U"
		));
	}
}