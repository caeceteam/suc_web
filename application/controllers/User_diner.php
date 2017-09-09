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
		$this->load->library('form_validation');
		$this->load->helper(array('url', 'form'));        
		$this->load->model('User_diner_model');
        
        // Instancio una clase vacia para evitar el warning "Creating default object from empty value"         
        $this->form_data = new stdClass(); 
        $this->variables['idUser'] = '';
        
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
        $this->render_table(NULL, $this->User_diner_model->search()['users']);
        $this->load->view('user_diner/search', $this->variables);
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
     * Funcion que muestra el formulario de alta y guarda la misma cuando la
     * validacion del formulario no arroja errores
     * 
     * @return void
     */
    public function add ()
    {
        $this->variables['action'] = site_url('user_diner/add');
        $this->variables['request-action'] = 'POST';
        $this->variables['redirect-url'] = site_url('user_diner');
        $this->_set_rules();
        
        if ($this->input->method() == "get") {
            $this->load->view('user_diner/save', $this->variables);
        } 
        else {
            // Todo esto corresponde al POST
            if ($this->form_validation->run() == FALSE) {
                $this->output->set_status_header('500');
                $this->variables['error-type'] = 'empty-field';
                $data = array(
                        'code' => form_error('name'),
                        'name' => form_error('surname')
                );
                $this->variables['error-fields'] = $data;
            } else {
                $response = $this->User_diner_model->add($this->_get_post());
                if (isset($response['errors'])) {
                    $this->output->set_status_header('500');
                    $this->variables['error-type'] = 'unique';
                    $this->variables['error-fields'] = $response['fields'];
                }
            }
            echo json_encode($this->variables);
        }
    }

    /**
     * Funcion que muestra el formulario de ediciÃ³n y guarda la misma cuando la
     * validacion del formulario no arroja errores
     * 
     * @param string $id            
     * @return void
     */
    public function edit ($id = NULL)
    {
        $this->variables['action'] = site_url('user_diner/edit');
        $this->variables['request-action'] = 'PUT';
        $this->variables['redirect-url'] = site_url('user_diner');
        // Si no es un post, no se llama al editar y solo se muestran los campos
        // para editar
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
                        'code' => form_error('code'),
                        'name' => form_error('name')
                );
                $this->variables['error-fields'] = $data;
            } else {
                $response = $this->User_diner_model->edit($this->_get_post());
                if (isset($response['errors'])) {
                    $this->output->set_status_header('500');
                    $this->variables['error-type'] = 'unique';
                    $this->variables['error-fields'] = $response['fields'];
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
     * Renderiza una tabla en base a un template HTML y un object|array
     * 
     * @param string $template            
     * @param
     *            mixed object|array Puede recibir un objeto de un input type o
     *            un array de varios
     * @return void
     */
    public function render_table ($template = NULL, $data)
    {

        $template = isset($template) ? $template : array(
                'table_open' => '<table id="data-table-command" class="table table-striped table-vmiddle">');
        
        $this->load->library('table');
        $this->table->set_template($template);
        $this->table->set_heading(
                array(  'data'           => 'IdUser',
                        'data-column-id' => 'idUser',
                        'data-visible'   => 'false'),

                array(  'data'           => 'Nombre',
                        'data-column-id' => 'name',
                        'data-order'     => 'desc' ),
                
                array(  'data'           => 'Apellido',
                        'data-column-id' => 'surname',
                        'data-order'     => 'desc' ),
                
                array(  'data'           => 'Ver/Modificar/Baja',
                        'data-column-id' => 'commands',
                        'data-formatter' => 'commands',
                        'data-sortable'  => 'false' )
                 );
        
        //foreach ($data['users'] as $user_diner)
        foreach ($data as $user_diner)
        {
            $this->table->add_row($user_diner['idUser'],
                                  $user_diner['name']  ,
                                  $user_diner['surname']);
        }
        $this->variables['table'] = $this->table->generate();
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
        
        $user_diner->idUser         = $idUser != NULL ? $idUser : $this->input->post('idUser');
        $user_diner->name           = $this->input->post('name');
        $user_diner->surname        = $this->input->post('surname');
        $user_diner->mail           = $this->input->post('mail');
        $user_diner->phone          = $this->input->post('phone');
        $user_diner->bornDate       = $this->input->post('bornDate');
        $user_diner->role           = $this->input->post('role');
        $user_diner->pass           = $this->input->post('pass');
        $user_diner->passCheck      = $this->input->post('passCheck');
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
        $this->form_data->diner         = '';
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
        // $this->form_validation->set_rules('phone',   'Telefono',    'trim|required');
        $this->form_validation->set_rules('bornDate', 'Fecha Nacimiento', 'trim|required');
        //$this->form_validation->set_rules('role', 'Puesto', 'trim|required');
        $this->form_validation->set_rules('pass',       'Clave',         'trim|required');
        $this->form_validation->set_rules('passCheck',  'Confirmación',  'trim|required');
        $this->form_validation->set_rules('passCheck',  'Confirmación',  'trim|required');
        $this->form_validation->set_rules('alias',      'Alias',         'trim|required');
        $this->form_validation->set_rules('docNum',     'Documento',     'trim|required');
      //$this->form_validation->set_rules('street',       'Calle',         'trim|required');
      //$this->form_validation->set_rules('streetNumber', 'Numero',      'trim|required');
      //$this->form_validation->set_rules('foort',        'Piso',         'trim|required');
      //$this->form_validation->set_rules('door',         'Puerta',      'trim|required');
        $this->form_validation->set_rules('diner',     'Comedor',     'trim|required');
          
    }
}