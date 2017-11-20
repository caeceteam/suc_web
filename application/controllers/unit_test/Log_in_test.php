<?php
class Log_in_test extends CI_Controller {

    /**
     * Log_in_test 
     *
     */
    
    public $id_test;
    
    //Test Creación
    public $user_name_test          = 'tony' ;
    public $user_mail_test          = 'carb.jose@gmail.com';
    public $user_pass_test          = '123456' ;
    public $user_pass_error_test    = 'RRRRRR' ;
    public $user_new_pass           = '654321';
    public $user_new_rep_pass       = '654321';
    
    /**
     * Unit Test - Constructor Food Type
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array( 'login'));
        $this->load->model('Login_model');
        $this->load->library('unit_test');
    }
    
    /**
     * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
     * @return void
     */
    public function index()
    {
         
    
        //Test - Altas
        $this->log_in_test('T001 - Login Correcto -  Usuario y clave correcta');
        $this->log_out_test('T002 - Logout Correcto -  Usuario y clave correcta');
        
        echo $this->unit->report();
    }
    
    
    /**
     * Alta nuevo tipo - Caso satisfactorio
     * @return void
     */
    public function log_in_test($tit_test)
    {
        $user 			= new stdClass();
        $user->userName = $this->user_name_test;
        $user->password	= $this->user_pass_test;
        
        $test             = $this->Login_model->validate($user);
        $this->id_test    = $test['idFoodType'];
        $test_name        = $tit_test;
        $notes            = var_export($test, true);
        $this->unit->run($test, 'is_array' , $test_name, $notes);
    }

}