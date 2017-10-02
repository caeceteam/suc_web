<?php
defined('BASEPATH') or exit('No direct script access allowed');

/** ****************************************************************************************************
 * CLASE USER_DINER
 * *****************************************************************************************************
 * HISTORIA: HU021
 * TITULO: Usuario comedor
 ***************************************************************************************************** */
class User_diner extends CI_Controller
{

    /**
     * Array para guardar todas las variables de la pagina
     * 
     * @var array
     */
    private $variables;
    private $pass_view;
    private $pass_no_view;

    /**
     * Array para guardar exclusivamente los values del formulario
     * 
     * @var array
     */
    public $form_data;
    public $new_pass;

    /**
     * Constructor de clase
     * Se encarga de hacer el load de los modulos necesarios
     * 
     * @return void
     */
    public function __construct ()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->library(array('form_validation', 'email', 'upload'));
		$this->load->helper(array('url', 'form'));    
		$this->load->model('User_diner_model');
        
        // Instancio una clase vacia para evitar el warning "Creating default object from empty value"         
        $this->form_data = new stdClass(); 
        $this->variables['idUser'] = '';
        $this->pass_view    = 'display:block;';
        $this->pass_no_view = 'display:none;';
        
        // Variable para indicar si hay que resetear los campos del formulario
        $this->variables['reset'] = FALSE; 
        $this->variables['controller-name'] = 'user_diner';
        $this->_initialize_fields();
    }

    /**
     * Funcion que se carga por default al invocar al controlador sin
     * especificar la URL completa
     * 
     * @return void
     */
    public function index ()
    {
        $this->variables['data-request-url'] = site_url('user_diner/render_table_response');
        $this->load->view('user_diner/search', $this->variables);
    }

    /**
     * Funcion que retorna la tabla con la informacion de usuarios
     *
     * @return void
     */
    public function render_table_response()
    {
        $service_data       = $this->User_diner_model->get_userdiner_by_page($this->input->post('current') - 1);
        $pagination_data    = $service_data['pagination'];
        $user_diner_data    = $service_data['users'];
            
        $render_data['current'] = (int)$this->input->post('current');
        $render_data['total'] = $pagination_data['total_elements'];
    
        $render_data['rows'] = [];
        foreach ($user_diner_data as $user_diner)
        {
            $row_data['id']         = $user_diner['idUser'];
            $row_data['name']       = $user_diner['name'];
            $row_data['surname']    = $user_diner['surname'];
            $row_data['phone']      = $user_diner['phone'];
            array_push($render_data['rows'], $row_data);
        }
        echo json_encode($render_data, TRUE);
    }
    
    
    
    /**
     * Funcion de consulta
     * 
     * @param string $name            
     * @return void
     */
    public function search ($name = NULL)
    {
        if ($name != NULL) {
            $user_diner = $this->User_diner_model->search($name);
            $this->render_table(NULL, $user_diner);
        } else
            $this->index();
    }

    /**
     * Funcion de baja
     *
     * @param string $id
     * @return void
     */
    public function delete ($id = NULL)
    {
        $this->User_diner_model->delete($id);
        $this->index();
    }
    
    /**
     * Funcion que muestra el formulario de alta y guarda la misma cuando la
     * validacion del formulario no arroja errores
     * 
     * @return void
     */
    public function add ()
    {
        $msj_erro_500 = '';
        $this->new_pass = $this->pass_no_view;
        $this->variables['action']         = site_url('user_diner/add');
        $this->variables['request-action'] = 'POST';
        $seccion; 
        
        //Redirijo la url para que no se vea la de origen 
        $this->variables['redirect-url']   = site_url('user_diner');
        $this->_set_rules();
        
      if ($this->input->method() == "get") {
           $this->load->view('user_diner/save', $this->variables);
        } 
        else {
            // Todo esto corresponde al POST
            if ($this->form_validation->run() == FALSE) {
                $this->output->set_status_header('500');
                $this->variables['error-type'] = 'empty-field';
                $data = array(    'name'    => form_error('name'),
                                  'surname' => form_error('surname'),
                                  'role'    => form_error('role'),
                                  'alias'   => form_error('alias'),
                                  'docNum'  => form_error('ducNum'),
                                  'mail'    => form_error('mail'));

                $this->variables['error-fields'] = $data;

            } else {
                 $response = $this->User_diner_model->add($this->_get_post());
                 if ((isset($response['errors'])) && ($response['errors'] != null)){
                 $this->output->set_status_header('500');
                 $this->variables['error-type']  = 'unique';
                 // Concateno mensaje en formato HTML para que pueda mostrarse desde la Vista
                 $msj_erro_500 = '<p>'.$response['result'].'</p>';
                 $this->variables['message']     = form_error($msj_erro_500);
                    
                } else{ 
                    if($this->_send_mail($response)){
                        $this->variables['message'] = 'Se envío un mail con el estado de la solicitud.';
                    }else{
                        $this->variables['message'] = 'Ocurrio un error al enviar el mail.';
                    }
                } 
            }
            echo json_encode( $this->variables );
        }
    }

    /**
     * Funcion que muestra el formulario de edición y guarda la misma cuando la
     * validacion del formulario no arroja errores
     * 
     * @param string $id            
     * @return void
     */
    public function edit ($id = NULL)
    {
        $this->variables['action']          = site_url('user_diner/edit');
        $this->variables['request-action']  = 'PUT';
        $this->variables['redirect-url']    = site_url('user_diner');
        // Si no es un post, no se llama al editar y solo se muestran los campos
        // para editar
        if ($this->input->method() == "get") {
            $this->new_pass = $this->pass_view;
            $user_diner                     = $this->User_diner_model->search_by_id($id);
            $this->form_data->id            = $user_diner['idUser'];
            $this->form_data->name          = $user_diner['name'];
            $this->form_data->surname       = $user_diner['surname'];
            $this->form_data->mail          = $user_diner['mail'];
            $this->form_data->phone         = $user_diner['phone'];
            $this->form_data->role          = $user_diner['role'];
            $this->form_data->pass          = $user_diner['pass'];
            $this->form_data->alias         = $user_diner['alias'];
            $this->form_data->docNum        = $user_diner['docNum'];
            $this->form_data->street        = $user_diner['street'];
            $this->form_data->streetNumber  = $user_diner['streetNumber'];
            $this->load->view('user_diner/save', $this->variables);
            
        } else {
            $this->_initialize_fields();
            $this->_set_rules();
            $user_diner = new stdClass();
            // Todo esto corresponde al PUT
            if ($this->form_validation->run() == FALSE) {
                $this->output->set_status_header('500');
                $this->variables['error-type'] = 'empty-field';
                $data = array(
                        'name'      => form_error('name'),
                        'surname'   => form_error('surname')
                );
                $this->variables['error-fields'] = $data;
            } else {
                $response = $this->User_diner_model->edit($this->_get_post());
                if (isset($response['errors']) && $response['errors'] ) {
                    $this->output->set_status_header('500');
                    $this->variables['error-type'] = 'unique';
                    $this->variables['error-fields'] = $response['fields'];
                }
                else{
                    
/*                    if($this->_send_mail($user_diner)){
                        $this->variables['message'] = 'Se envío un mail con el estado de la solicitud.';
                    }else{
                            $this->variables['message'] = 'Ocurrio un error al enviar el mail.';
                    }
  */                  
                }
            }
            echo json_encode($this->variables);
        }
    }

    
    /**
     * Funcion que muestra el formulario de datos seleccionados
     *
     * @param string $id
     * @return void
     */
    public function view ($id = NULL)
    {
        $this->variables['action'] = site_url('user_diner/vew');
        if ($this->input->method() == "get") {
            $user_diner = $this->User_diner_model->search($id);
            $this->form_data->id            = $user_diner['idUser'];
            $this->form_data->name          = $user_diner['name'];
            $this->form_data->surname       = $user_diner['surname'];
            $this->form_data->mail          = $user_diner['mail'];
            $this->form_data->phone         = $user_diner['phone'];
            $this->form_data->role          = $user_diner['role'];
            $this->form_data->pass          = $user_diner['pass'];
            $this->form_data->alias         = $user_diner['alias'];
            $this->form_data->docNum        = $user_diner['docNum'];
            $this->form_data->street        = $user_diner['street'];
            $this->form_data->streetNumber  = $user_diner['streetNumber'];
            $this->load->view('user_diner/view', $this->variables);
        } 
           // echo json_encode($this->variables);
    }
    
       


    
//* ****************************************************************************************************    
    
    public function valid_password($oldPass, $newPass, $confPass )
    {
        //Si no se cargan se mantiene la clave
        if (empty($oldPass) && empty($oldPass) && empty($oldPass)){
            
            return TRUE;
        } 
        //Si alguno esta vacio debe caragarse
        elseif (empty($oldPass) || empty($oldPass) || empty($oldPass)){
            return FALSE;
        }
        else{
            //Es erronea la confirmación
            if($newPass != $confPass ){
                return FALSE;
            }
            
            //Es erronea la confirmación
            if($oldPass != $this->form_data->pass || $this->form_data->pass == $newPass ){
                return FALSE;
            }
            //Validación individual de claves
            if (! $this->valid_single_password($oldPass)){
                return FALSE;
            }
            
            if (! $this->valid_single_password($newPass)){
                return FALSE;
            }
            
            if (! $this->valid_single_password($confPass)){
                return FALSE;
            }
            
        }     
    }
    
    public function valid_single_password($password = '')
	{
		//$password = trim($password);
		//Caracteres de validación
	    $lower_case  = '/[a-z]/';
		$upper_case  = '/[A-Z]/';
		$number      = '/[0-9]/';
		$special     = '/[!@#$%^&*()\-_=+{};:,<.>]/';
		
		//Contiene caracteres mayuscula
		if (preg_match_all($lower_case, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'Por lo menos debe contener una letra mayuscula.');
			return FALSE;
		}
		
		if (preg_match_all($upper_case, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'Contener al menos una letra.');
			return FALSE;
		}
		
		if (preg_match_all($number, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'Contener al menos un numero.');
			return FALSE;
		}
		if (preg_match_all($special, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'Contener alguno de los siguieneste caracteres.' . ' ' . htmlentities('/[!@#$%^&*()\-_=+{};:,<.>]/'));
			return FALSE;
		}
		
		//Longitud minima 
		if (strlen($password) < 5)
		{
			$this->form_validation->set_message('valid_password', 'La clave debe tener una longitud minima de 6 caracteres.');
			return FALSE;
		}
		
		//Longitud minima
		if (strlen($password) > 32)
		{
			$this->form_validation->set_message('valid_password', 'La clave no puede superar los 32 caracteres.');
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Función que envia un mail de confirmacion de cuenta 
	 * @param    $user_diner 	array  array del user diner
	 * @return   bool 			indica si el mail se pudo enviar
	 */
	private function _send_mail( $user_info )
	{
	    $this->email->from('suc@no-reply.com', 'Sistema Único de Comedores');
	    $this->email->to($user_info[mail]);
	    //$this->email->to("");
	    
	    if ($this->variables['request-action'] == 'PUT'){
	        $this->email->subject('Modificación de datos usuario');
	        $this->email->message('Su datos de usuarios han sido actualizados correctamente. <br/>
			Ante cualquier inconveniente dirigirse al administrador del comedor. <br/>
			Att Sistema SUC,. <br/>');
	    }
	    elseif ($this->variables['request-action'] == 'POST')
	    {  
	        $this->email->subject('Alta usuario');                                         
	        $this->email->message('Se ha dado de alta el usuario ' . $user_info->alias .' <br/> 
			Su clave de acceso para ingresar es: ' . $user_info[pass] . ' .<br/>
			Acceda al sistema mediante la siguiente URL. <br/>');
	    }
	    $this->email->set_newline("\r\n");//Sin esta línea falla el envio
	    return $this->email->send();
	}	
	
	/**
	 * Función que genera una contraseña en forma aleatorio
	 * @param    $chars_min largo minimo (opcional, default 6)
	 * @param    $chars_max largo máximo (opcional, default 8)
	 * @param    $use_upper_case boolean para indicar si se usan mayúsuculas (opcional, default false)
	 * @param    $include_numbers boolean para indicar si se usan números (opcional, default false)
	 * @param    $include_special_chars boolean para indicar si se usan caracteres especiales (opcional, default false)
	 * @return    string containing a random password
	 */
	private function _generate_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=false, $include_special_chars=false)
	{
	    $length = rand($chars_min, $chars_max);
	    $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
	    if($include_numbers)
	        $selection .= "1234567890";
	        if($include_special_chars)
	            $selection .= "!@\"#$%&[]{}?|";
	            $password = "";
	            for($i=0; $i<$length; $i++) {
	                $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
	                $password .=  $current_letter;
	            }
	            return $password;
	}
	
//* *********************************************************************************************** */


    /**
     * Obtiene los datos del post y los devuelve en forma de objeto
     * 
     * @param integer $id
     *            id del input type para cuando se trata de una edición
     * @return object $user_diner
     */
    private function _get_post ($id = NULL)
    {
        $user_diner = new stdClass();     
        $user_diner->idUser         = $id != NULL ? $id : $this->input->post('id');
        $user_diner->name           = $this->input->post('name');
        $user_diner->surname        = $this->input->post('surname');
        $user_diner->mail           = $this->input->post('mail');
        $user_diner->phone          = $this->input->post('phone');
        $user_diner->bornDate       = $this->input->post('bornDate');
        $user_diner->role           = $this->input->post('role');
        $user_diner->pass           = $this->_generate_password();
        $user_diner->alias          = $this->input->post('alias');
        $user_diner->docNum         = $this->input->post('docNum');
        $user_diner->street         = $this->input->post('street');
        $user_diner->streetNumber   = $this->input->post('streetNumber');
        $user_diner->floor          = $this->input->post('floor');
        $user_diner->door           = $this->input->post('door');
        $user_diner->diner          = $this->input->post('diner');
        
        return $user_diner;
    }

    /**
     * Funcion que inicializa las variables de los campos del formulario para la
     * edicion
     * 
     * @return void
     */
    private function _initialize_fields ()
    {   
        $this->form_data->id            = '';
        $this->form_data->name          = '';
        $this->form_data->surname       = '';
        $this->form_data->mail	        = '';
        $this->form_data->phone	        = '';
        $this->form_data->bornDate      = '';
        $this->form_data->role	        = ''; 
        $this->form_data->pass	        = '';
        $this->form_data->passCheck     = '';
        $this->form_data->alias	        = '';
        $this->form_data->docNum        = '';
        $this->form_data->street        = '';
        $this->form_data->streetNumber  = '';
        $this->form_data->floor         = '';
        $this->form_data->door          = '';
        $this->form_data->latitude      = '';
        $this->form_data->longitude     = '';
        $this->form_data->zipCode       = '';
        $this->form_data->diner         = '';
        $this->form_data->newPassConf   = '';
        $this->form_data->newPass       = '';
        
         
    }

    /**
     * Funcion que setea las reglas de validacion del formulario y sus mensajes
     * de errores
     * 
     * @return void
     */
    private function _set_rules ()
    {
        $this->form_validation->set_rules('name',    'Nombre',      'trim|required');
        $this->form_validation->set_rules('surname', 'Apellido',    'trim|required');
        $this->form_validation->set_rules('mail',    'Mail',        'trim|required');
        //$this->form_validation->set_rules('phone',       'Telefono',    'trim|required');
        $this->form_validation->set_rules('bornDate',     'Fecha Nacimiento', 'trim|required');
        $this->form_validation->set_rules('role',         'Puesto', 'trim|required');
        //$this->form_validation->set_rules('pass',         'Clave',         'trim|required');
        //$this->form_validation->set_rules('passCheck',    'Confirmación',  'trim|required');
        //$this->form_validation->set_rules('passCheck',    'Confirmación',  'trim|required');
        $this->form_validation->set_rules('alias',        'Alias',         'trim|required');
        $this->form_validation->set_rules('docNum',       'Documento',     'trim|required');
        //$this->form_validation->set_rules('street',       'Calle',         'trim|required');
        //$this->form_validation->set_rules('streetNumber', 'Numero',      'trim|required');
        //$this->form_validation->set_rules('foort',        'Piso',         'trim|required');
        //$this->form_validation->set_rules('door',         'Puerta',      'trim|required');
        // $this->form_validation->set_rules('diner',       'Comedor',     'trim|required');
          
    }
	}