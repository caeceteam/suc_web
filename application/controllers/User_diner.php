<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ****************************************************************************************************

 * CLASE USER_DINER
 * *****************************************************************************************************
 * HISTORIA: HU021
 * TITULO: Usuario comedor
 * ****************************************************************************************************
 */
class User_diner extends CI_Controller
{

    /**
     * Array para guardar todas las variables de la pagina
     *
     * @var array
     */
    private $variables;
    private $dinerUser;

    /**
     * Array para guardar exclusivamente los values del formulario
     *
     * @var array
     */
    public $form_data;
    /**
     * Constructor de clase
     * Se encarga de hacer el load de los modulos necesarios
     * 
     * @return void
     */
    public function __construct ()
    {
        parent::__construct();
        // $this->load->library('form_validation');
        
        $this->load->library(
                array(
                        'form_validation',
                        'session',
                        'upload',
                        'email'
                        //'notification'
                ));
        $this->load->helper(
                array(
                        'url',
                        'form'
                ));
        
        $this->load->model('User_diner_model');
           
        // Instancio una clase vacia para evitar el warning "Creating default
        // object from empty value"
        $this->form_data            = new stdClass();
        $this->variables['idUser']  = '';
        $this->pass_view            = 'display:block;';
        $this->pass_no_view         = 'display:none;';
        
        // Variable para indicar si hay que resetear los campos del formulario
        $this->variables['reset']           =  FALSE;
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
        $this->variables['data-request-url'] = site_url( 'user_diner/render_table_response');
        $this->load->view('user_diner/search', $this->variables);
    }

    /**
     * Funcion que retorna la tabla con la informacion de usuarios
     *
     * @return void
     */
    public function render_table_response ()
    {
        $service_data = $this->User_diner_model->get_userdiner_by_page(
                $this->input->post('current') - 1);
        $pagination_data = $service_data['pagination'];
        $user_diner_data = $service_data['users'];
        
        $render_data['current'] = (int) $this->input->post('current');
        $render_data['total'] = $pagination_data['total_elements'];
        
        $render_data['rows'] = [];
        foreach ($user_diner_data as $user_diner) {
            $row_data['id']      = $user_diner['idUser'];
            $row_data['name']    = $user_diner['name'];
            $row_data['surname'] = $user_diner['surname'];
            $row_data['phone']   = $user_diner['phone'];
            array_push($render_data['rows'], $row_data);
        }
        echo json_encode($render_data, TRUE);
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
        $this->variables['action'] = site_url('user_diner/add');
        $this->variables['request-action'] = 'POST';
        $this->variables['redirect-url']   = site_url('user_diner');
        $this->form_data->redirect         = site_url('user_diner');
        $seccion;
        
        // Redirijo la url para que no se vea la de origen
        //$this->variables['redirect-url'] = $this->get_redirect();
        $this->_set_rules();
        
        if ($this->input->method() == "get") {
            $this->load->view('user_diner/save', $this->variables);
        } else {
            // Todo esto corresponde al POST
            if ($this->form_validation->run() == FALSE) {
                $this->output->set_status_header('500');
                $this->variables['error-type'] = 'empty-field';
                $data = array(
                        'name'      => form_error('name'),
                        'surname'   => form_error('surname'),
                        'role'      => form_error('role'),
                        'alias'     => form_error('alias'),
                        'docNum'    => form_error('docNum'),
                        'mail'      => form_error('mail')
                );
                
                $this->variables['error-fields'] = $data;
            //Campos correctos hago el Post    
            } else {
                $response = $this->User_diner_model->add($this->_get_post());
                
                if ((isset($response['errors'])) && ($response['errors'] != null)) {
                    $this->output->set_status_header('500');
                    $this->variables['error-type'] = 'unique';
                    
                    // Concateno mensaje en formato HTML para que pueda mostrarse desde la Vista
                    $msj_erro_500 = '<p>' . $response['result'] . '</p>';
                    $this->variables['message'] = form_error($msj_erro_500);
                    
                } else {
                    $user_diner = $this->_get_post();
                    $mail_user = array(
                            'mail'  => $user_diner['mail'],
                            'name'  => $user_diner['name'],
                            'alias' => $user_diner['alias'],
                            'pass'  => $user_diner['docNum']
                    );
                    try {
                        //$this->Notification->_send_mail($mail_user, 'html', $this->variables['request-action'], $this->load);
                    } catch (Exceptionn $exs) {
                        $msj_erro_500 = '<p>' . $exs->getmessage() . '</p>';
                        $this->variables['message']     = $msj_erro_500;
                        $this->variables['error-type']  = 'unique';
                        $this->output->set_status_header('500');
                    }
                }
            }
            
            echo json_encode($this->variables);
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
        $this->variables['action'] = site_url('user_diner/edit');
        $this->variables['request-action'] = 'PUT';
        $this->variables['redirect-url']   = $this->get_redirect();
        $this->form_data->redirect         = $this->variables['redirect-url'];
        //$this->variables['redirect-url']   = site_url('user_diner');
        $page = $this->session->get_userdata();
        
        //Si no es un post, no se llama al editar y solo se muestran los campos para editar
        if ($this->input->method() == "get") {
            $user_and_diner             = $this->User_diner_model->search_by_id($id);
            $user_dat                   = $user_and_diner['user'];
            $diner_dat                  = $user_and_diner['diners'];
            $this->form_data->id        = $user_dat['idUser'];
            $this->form_data->name      = $user_dat['name'];
            $this->form_data->surname   = $user_dat['surname'];
            $this->form_data->mail      = $user_dat['mail'];
            $this->form_data->phone     = $user_dat['phone'];
            $this->form_data->role      = $user_dat['role'];
            $this->form_data->pass      = $user_dat['pass'];
            $this->form_data->alias     = $user_dat['alias'];
            $this->form_data->docNum    = $user_dat['docNum'];
            
            $user_bornData = new DateTime($user_dat['bornDate']);
            $this->form_data->bornDate      = date_format($user_bornData, "d-m-Y");
            $this->form_data->street        = $user_dat['street'];
            $this->form_data->streetNumber  = $user_dat['streetNumber'];
            $this->form_data->floor         = $user_dat['floor'];
            $this->form_data->door          = $user_dat['door'];
            $idDiner = $this->session->userdata['idDiner'];
            $this->form_data->idDiner       = $idDiner['Diner']['idDiner'];
            
            $this->load->view('user_diner/save', $this->variables);
        //Se Validan los campos ingresados
        }else {
            $this->_initialize_fields();
            $this->_set_rules();
            //$this->variables[idUser] = $idDiner['Diner']['idDiner'];
            $user_diner = new stdClass();
            // Todo esto corresponde al PUT
            if ($this->form_validation->run() == FALSE) {
                $this->output->set_status_header('500');
                $this->variables['error-type'] = 'empty-field';
                $data = array(
                        'name'     => form_error('name'),
                        'surname'  => form_error('surname'),
                        'role'     => form_error('role'),
                        'alias'    => form_error('alias'),
                        'docNum'   => form_error('docNum'),
                        'mail'     => form_error('mail')
                );
                
                $this->variables['error-fields'] = $data;
           //Los campos son correctos
            } else {
                    $user_diner = $this->_get_post();
                    $response   = $this->User_diner_model->edit($user_diner);

                    if (isset($response['errors']) && $response['errors']) {
                        $this->output->set_status_header('500');
                        $this->variables['error-type']   = 'unique';
                        $this->variables['error-fields'] = $response['fields'];
                 // Sin errores de campo, ni API
                    } else{
                            $user_diner = $this->_get_post();
                            $mail_user = array(
                                    'mail'  => $user_diner->mail,
                                    'name'  => $user_diner->name,
                                    'alias' => $user_diner->alias,
                                    'pass'  => $user_diner->docNum
                            );
                            try {
                               // $this->Notification->_send_mail($mail_user, 'html', $this->variables['request-action'], $this->load);
                            }catch (Exceptionn $exs) {
                                    $msj_erro_500 = '<p>' . $exs->getmessage() . '</p>';
                                    $this->variables['message']     = $msj_erro_500;
                                    $this->variables['error-type']  = 'unique';
                                    $this->output->set_status_header('500');
                            }
                           }
                    }
            echo json_encode($this->variables);
            // $this->load->view('user_diner/save', $this->variables);
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
            $this->form_data->floor         = $user_diner['floor'];
            $this->form_data->door          = $user_diner['door'];
            
            $this->load->view('user_diner/view', $this->variables);
        }
        // echo json_encode($this->variables);
    }

    public function valid_password ($oldPass, $newPass, $confPass)
    {
        // Si no se cargan se mantiene la clave
        if (empty($oldPass) && empty($oldPass) && empty($oldPass)) {
            
            return TRUE;
        } // Si alguno esta vacio debe caragarse
        elseif (empty($oldPass) || empty($oldPass) || empty($oldPass)) {
            return FALSE;
        } else {
            // Es erronea la confirmaciÃ³n
            if ($newPass != $confPass) {
                return FALSE;
            }
            
            // Es erronea la confirmaciÃ³n
            if ($oldPass != $this->form_data->pass ||
                     $this->form_data->pass == $newPass) {
                return FALSE;
            }
            // ValidaciÃ³n individual de claves
            if (! $this->valid_single_password($oldPass)) {
                return FALSE;
            }
            
            if (! $this->valid_single_password($newPass)) {
                return FALSE;
            }
            
            if (! $this->valid_single_password($confPass)) {
                return FALSE;
            }
        }
    }

    public function valid_single_password ($password = '')
    {
        // Caracteres de validación
        $lower_case = '/[a-z]/';
        $upper_case = '/[A-Z]/';
        $number     = '/[0-9]/';
        $special    = '/[!@#$%^&*()\-_=+{};:,<.>]/';
        
        // Contiene caracteres mayuscula
        if (preg_match_all($lower_case, $password) < 1) {
            $this->form_validation->set_message('valid_password', 
                    'Por lo menos debe contener una letra mayuscula.');
            return FALSE;
        }
        
        if (preg_match_all($upper_case, $password) < 1) {
            $this->form_validation->set_message('valid_password', 
                    'Contener al menos una letra.');
            return FALSE;
        }
        
        if (preg_match_all($number, $password) < 1) {
            $this->form_validation->set_message('valid_password', 
                    'Contener al menos un numero.');
            return FALSE;
        }
        if (preg_match_all($special, $password) < 1) {
            $this->form_validation->set_message('valid_password', 
                    'Contener alguno de los siguieneste caracteres.' . ' ' .
                             htmlentities('/[!@#$%^&*()\-_=+{};:,<.>]/'));
            return FALSE;
        }
        
        // Longitud minima
        if (strlen($password) < 5) {
            $this->form_validation->set_message('valid_password', 
                    'La clave debe tener una longitud minima de 6 caracteres.');
            return FALSE;
        }
        
        // Longitud minima
        if (strlen($password) > 32) {
            $this->form_validation->set_message('valid_password', 
                    'La clave no puede superar los 32 caracteres.');
            return FALSE;
        }
        return TRUE;
    }

     /**
     * Función que genera una contraseña en forma aleatorio
     *
     * @param $chars_min largo
     *            minimo (opcional, default 6)
     * @param $chars_max largo
     *            máximo (opcional, default 8)
     * @param $use_upper_case boolean
     *            para indicar si se usan maásuculas (opcional, default false)
     * @param $include_numbers boolean
     *            para indicar si se usan nÃºmeros (opcional, default false)
     * @param $include_special_chars boolean
     *            para indicar si se usan caracteres especiales (opcional,
     *            default false)
     * @return string containing a random password
     */
    private function _generate_password ($chars_min = 6, $chars_max = 8, 
            $use_upper_case = false, $include_numbers = false, 
            $include_special_chars = false)
    {
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if ($include_numbers)
            $selection .= "1234567890";
        if ($include_special_chars)
            $selection .= "!@\"#$%&[]{}?|";
        $password = "";
        for ($i = 0; $i < $length; $i ++) {
            $current_letter = $use_upper_case ? (rand(0, 1) ? strtoupper(
                    $selection[(rand() % strlen($selection))]) : $selection[(rand() %
                     strlen($selection))]) : $selection[(rand() %
                     strlen($selection))];
            $password .= $current_letter;
        }
        return $password;
    }

    /**
     * Obtiene los datos del post y los devuelve en forma de objeto
     *
     * @param integer $id
     *            id del input type para cuando se trata de una ediciÃ³n
     * @return object $user_diner
     */
    private function _get_post ($id = NULL)
    {
        $user_diner               = new stdClass();
        $user_diner->idUser       = $id != NULL ? $id : $this->input->post('id');
        $user_diner->name         = $this->input->post('name');
        $user_diner->surname      = $this->input->post('surname');
        $user_diner->mail         = $this->input->post('mail');
        $user_diner->phone        = $this->input->post('phone');
        $user_bornData            = new DateTime($this->input->post('bornDate'));
        $user_bornData            = date_format($user_bornData, 'Y-m-d');
        $user_diner->bornDate     = $user_bornData;
        $user_diner->role         = $this->input->post('role');
        $user_diner->pass         = $this->_generate_password();
        $user_diner->alias        = $this->input->post('alias');
        $user_diner->docNum       = $this->input->post('docNum');
        $user_diner->street       = $this->input->post('street');
        $user_diner->streetNumber = $this->input->post('streetNumber');
        $user_diner->floor        = $this->input->post('floor');
        $user_diner->door         = $this->input->post('door');
        $user_diner->diner        = $this->input->post('diner');
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
        $this->form_data->mail          = '';
        $this->form_data->phone         = '';
        $this->form_data->bornDate      = '';
        $this->form_data->role          = '';
        $this->form_data->pass          = '';
        $this->form_data->passCheck     = '';
        $this->form_data->alias         = '';
        $this->form_data->docNum        = '';
        $this->form_data->street        = '';
        $this->form_data->streetNumber  = '';
        $this->form_data->floor         = '';
        $this->form_data->door          = '';
        $this->form_data->diner         = '';
        $this->form_data->newPassConf   = '';
        $this->form_data->newPass       = '';
        $this->form_data->idDiner       = '';
    }

    /**
     * Funcion que setea las reglas de validacion del formulario y sus mensajes
     * de errores
     *
     * @return void
     */
    private function _set_rules ()
    {
        $this->form_validation->set_rules('name', 'Nombre', 'trim|required');
        $this->form_validation->set_rules('surname', 'Apellido', 
                'trim|required');
        $this->form_validation->set_rules('mail', 'Mail', 'trim|required');
        $this->form_validation->set_rules('bornDate', 'Fecha Nacimiento', 
                'trim|required');
        $this->form_validation->set_rules('role', 'Puesto', 'trim|required');
        $this->form_validation->set_rules('alias', 'Alias', 'trim|required');
        $this->form_validation->set_rules('docNum', 'Documento', 
                'trim|required');
        $this->form_validation->set_rules('street', 'Calle', 'trim|required');
        $this->form_validation->set_rules('streetNumber', 'Numero', 'trim|required');
    }

    /**
     * Funcion que define donde redireccionar la pagina
     *
     * @return redirect
     */
   private function get_redirect() {
        //if ( $this->session->userdata['lastpage'] != 'user_diner'){
       /*if( $_SESSION['last_page'] != null && ! strpos($_SESSION['last_page'],'user_diner/edit')){
            if (strpos($_SESSION['last_page'],'user_diner')){
                return site_url('user_diner');
            }else{
                return site_url($_SESSION['last_page']);
            }
        }*/
       
       if( $_SERVER['PHP_SELF'] != null && ! strpos($_SERVER['PHP_SELF'],'user_diner/edit')){
           if (strpos($_SERVER['PHP_SELF'],'user_diner')){
               return site_url('user_diner');
           }else{
               return site_url($_SERVER['PHP_SELF']);
           }
       }elseif($_SERVER['PHP_SELF'] == null ){
           return site_url('home');          
       }
   } 
}