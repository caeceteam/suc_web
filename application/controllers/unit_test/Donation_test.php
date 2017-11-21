<?php
class Donation_test extends CI_Controller {
	/**
	* Diner_input_test se usa para probar el ABM de Stock de insumos
	*
	*/
    //Id
    public $id_test;
	public $id_inc_test    = 0;
	
	//Test Creaci�n
	public $idUserSender  		= '1';//Obligatorio
	public $idDinerReceiver  	= '2';//Obligatorio
	public $title        		= 'Fideos';
	public $description			= 'Donacion de fideos';
	public $creationDate    	= '2017-11-21';//Obligatorio
	public $status    			= '0';//Obligatorio
	
	/**
	* Unit Test - Constructor Diner Input
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array( 'login'));
		$this->load->model(array('Donation_model'));
		$this->load->library('unit_test');
	}
	
	/**
	* Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	* @return void
	*/
	public function index()
	{  
		//Test - Altas
		$this->alta_test('T001 - Alta exitosa - Crea una donaci�n');
		$this->alta_vacia_test('T002 - Alta incorrecta - Campos obligatorios vacios');
		
		//Test - Consultas
		$this->consulta_todos_test('T003 - B�squeda exitosa - Buscar todos los stocks de insumos');
		$this->consulta_codigo_test('T004 - B�squeda exitosa - Buscar un stock de insumo en particular ');
		$this->consulta_incorrecta_test('T005 - B�squeda incorrecta - Buscar un stock de insumo inexistente');
		
		//Test - Aprobaci�n
		$this->aprobar('T006 - Aprobaci�n exitosa - B�squeda y aprobaci�n de una donaci�n');
		$this->aprobar_inc('T007 - Aprobaci�n incorrecta - B�squeda y aprobaci�n de una donaci�n sin un campo obligatorio');
		
		//Test - Rechazo
		$this->rechazar('T008 - Rechazo exitosa - B�squeda y rechazo de una donaci�n');
		$this->rechazar_inc('T009 - Rechazo o - B�squeda y rechazo de una donaci�n sin un campo obligatorio');
				
		echo $this->unit->report();
	}
	
	/**
	* Alta - Caso satisfactorio
	* @return void
	*/
	public function alta_test($name)
	{
		$donation = new stdClass();

		$donation->idUserSender  	= $this->idUserSender  		;
		$donation->idDinerReceiver 	= $this->idDinerReceiver 	;
		$donation->title        	= $this->title        		;
		$donation->description		= $this->description		;
		$donation->creationDate    	= $this->creationDate   	;
		$donation->status    		= $this->status    			;
		
		$test             = $this->Donation_model->add($donation);
		$this->id_test    = $test['idDonation'];
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	/**
	 * Alta - Caso insatisfactorio con campos obligatorios vacios
	 * @return void
	 */
	public function alta_vacia_test($name)
	{
		$donation = new stdClass();


		$donation->idUserSender  	= $this->idUserSender  		;
		$donation->idDinerReceiver 	= null 	;
		
		$test             = $this->Donation_model->add($donation);
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	/**
	* Consulta - Cosntulta satisfactoria del todos los elementos existentes
	* @return void
	*/
	public function consulta_todos_test($name)
	{   
	    //Inicio del Test
	    $test             = $this->Donation_model->get_donations_by_page(0);
		$expected_result  = 'is_array';
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Consulta - Cosntulta satisfactoria por codigo
	* @return void
	*/
	public function consulta_codigo_test($name)
	{	
	    //Inicio del Test
	    $test             = $this->Donation_model->search_by_id($this->id_test);
	    $expected_result  = 'is_array';
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Consulta - Consulta insatisfactoria por un id incorrecto
	* @return void
	*/
	public function consulta_incorrecta_test($name)
	{
	    //Inicio del Test
		$test  = $this->Donation_model->search_by_id($this->id_inc_test);
	    
	    $expected_result  = 'is_null';
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	 * Edicion - Aprobaci�n satisfactoria
	 * @return void
	 */
	public function aprobar($name)
	{
		$donation = new stdClass();
	
	    //Inicializaci�n variables Test
	    $donation->id				= $this->id_test;
		$donation->idUserSender  	= $this->idUserSender  		;
		$donation->idDinerReceiver 	= $this->idDinerReceiver 	;
		$donation->title        	= $this->title        		;
		$donation->description		= $this->description		;
		$donation->creationDate    	= $this->creationDate   	;
		$donation->status    		= DONATION_APPROVED;
		
		//Inicio del Test
	    $test      = $this->Donation_model->edit($donation);
	    $test_name = $name;
	    $notes     = var_export($test, true);
	    $this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	
	/**
	 * Edicion - Aprobaci�n erronea con campos obligatorios vac�os
	 * @return void
	 */
	public function aprobar_inc($name)
	{
		$donation = new stdClass();
	
	    //Inicializaci�n variables Test
	    $donation->id				= $this->id_test;
		$donation->idUserSender  	= null  		;
		$donation->idDinerReceiver 	= null 	;
		$donation->title        	= $this->title        		;
		$donation->description		= $this->description		;
		$donation->creationDate    	= $this->creationDate   	;
		$donation->status    		= DONATION_APPROVED;
		
		//Inicio del Test
	    $test      = $this->Donation_model->edit($donation);
	    $test_name = $name;
	    $notes     = var_export($test, true);
	    $this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	/**
	 * Edicion - Rechazo satisfactoria
	 * @return void
	 */
	public function rechazar($name)
	{
		$donation = new stdClass();
	
		//Inicializaci�n variables Test
		$donation->id				= $this->id_test;
		$donation->idUserSender  	= $this->idUserSender  		;
		$donation->idDinerReceiver 	= $this->idDinerReceiver 	;
		$donation->title        	= $this->title        		;
		$donation->description		= $this->description		;
		$donation->creationDate    	= $this->creationDate   	;
		$donation->status    		= DONATION_REJECTED;
	
		//Inicio del Test
		$test      = $this->Donation_model->edit($donation);
		$test_name = $name;
		$notes     = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	
	/**
	 * Edicion - Rechazo erroneo con campos obligatorios vac�os
	 * @return void
	 */
	public function rechazar_inc($name)
	{
		$donation = new stdClass();
	
		//Inicializaci�n variables Test
		$donation->id				= $this->id_test;
		$donation->idUserSender  	= null  		;
		$donation->idDinerReceiver 	= null 	;
		$donation->title        	= $this->title        		;
		$donation->description		= $this->description		;
		$donation->creationDate    	= $this->creationDate   	;
		$donation->status    		= DONATION_REJECTED;
	
		//Inicio del Test
		$test      = $this->Donation_model->edit($donation);
		$test_name = $name;
		$notes     = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
}