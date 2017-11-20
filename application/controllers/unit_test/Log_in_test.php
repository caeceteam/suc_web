<?php
class Log_in_test extends CI_Controller {

    /**
     * Log_in_test 
     *
     */
    
    public $id_test;
    
    //Test User Log In
    public $user_name_test          = 'tony' ;
    public $user_pass_test          = '6d4718a9';
    
    //Test Mail Log In
    public $user_mail_test          = 'carb.jose@gmail.com';
    public $user_mail_pass_test     = '6d4718a9';
    
    //Test Log in erroneo
    public $user_pass_error_test    = 'RRRRRR'  ;
    
    
    
    /**
     * Unit Test - Constructor Food Type
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array( 'login', 'session'));
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
        $this->log_in_mail_test('T002 - Login Correcto -  Correo del Usuario y clave correcta');
        
        //Test Log Out
        $this->log_out_test('T003 - Logout Correcto -  Usuario y clave correcta');
        $this->log_in_err_test('T004 - Login Incorrecto -  Usuario y clave incorrecta');
        
        //Test 
        $this->log_in_forgot_test('T005 - Login Correcto - Olvido de contraseña');
        echo $this->unit->report();
    }
        
    /**
     * Log In - Caso satisfactorio
     * @return void
     */
    public function log_in_test($tit_test)
    {
        $user 			= new stdClass();
        $user->userName = $this->user_name_test;
        $user->password	= $this->user_pass_test;
        
        $test             = $this->Login_model->validate($user);
        $test_name        = $tit_test;
        $notes            = var_export($test, true);
        $this->unit->run($test, 'is_array' , $test_name, $notes);
    }
       
    /**
     * Log Out - Caso satisfactorio
     * @return void
     */
    public function log_out_test($tit_test)
    {   
        $test = true;
        try{
           $this->session->sess_destroy();
        }catch (Exception $e){ $test = false; }
        
        $test_name        = $tit_test;
		$notes            = var_export($test, true);
		$this->unit->run($test, 'is_true' , $test_name, $notes);
    }

    /**
     * Log In - Caso satisfactorio con mail
     * @return void
     */
    public function log_in_mail_test($tit_test)
    {   
        //Crear datos
        $user 			  = new stdClass();
        $user->userName   = $this->user_mail_test;
        $user->password	  = $this->user_mail_pass_test;
        
        //Inicio del test
        $test             = $this->Login_model->validate($user);
        $test_name        = $tit_test;
        $notes            = var_export($test, true);
        $this->unit->run($test, 'is_array' , $test_name, $notes);
    }

    /**
     * Log In - Caso satisfactorio con mail
     * @return void
     */
    public function log_in_err_test($tit_test)
    {
        //Crear datos
        $user 			  = new stdClass();
        $user->userName   = $this->user_name_test;
        $user->password	  = $this->user_pass_error_test;
    
        //Inicio del test
        $test             = $this->Login_model->validate($user);
        $test_name        = $tit_test;
        $notes            = var_export($test, true);
        $this->unit->run($test, 'is_null' , $test_name, $notes);
    }

    
    /**
     * Log In lost usuario - Caso satisfactorio con mail
     * @return void
     */
    public function log_in_forgot_test($tit_test)
    {
        //Crear datos
		$password 				= new stdClass();
		$password->userName 	= $this->user_name_test;
		$password->newPassword	= $this->user_pass_test;
    
        //Inicio del test
        $test             = $this->Login_model->reset_password($password);
        $test_name        = $tit_test;
        $notes            = var_export($test, true);
        $this->unit->run($test, 'is_array' , $test_name, $notes);
         
    }
    
    
}