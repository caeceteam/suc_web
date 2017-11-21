<?php
class Assistant_test extends CI_Controller {
	/**
	* Assistant_test se usa para probar el ABM de Concurrentes
	*
	*/
    //Id
    public $id_test;
	public $id_inc_test    = 0;
	
	//Test Creación
	public $idDiner_test  		= '2';//Obligatorio
	public $name  				= 'Eze';//Obligatorio
	public $surname        		= 'Fridman';
	public $bornDate			= '1990-12-12';
	public $street    			= 'Av. Cramer';//Obligatorio
	public $streetNumber    	= '1222';//Obligatorio
	public $floor				= '10';
	public $door				= 'A';
	public $zipcode				= '1638';
	public $latitude			= '-34.603684';
	public $longitude			= '-58.381559';
	public $phone				= '123123123';
	public $contactName			= 'Marco Cupo';
	public $scholarship			= '4';
	public $eatAtOwnHouse		= '0';
	public $economicSituation	= 'Humilde';
	public $celiac				= '1';
	public $diabetic			= '1';
	public $document			= '35185983';
	
	/**
	* Unit Test - Constructor Diner Input
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array( 'login'));
		$this->load->model(array('Assistant_model'));
		$this->load->library('unit_test');
	}
	
	/**
	* Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	* @return void
	*/
	public function index()
	{  
		//Test - Altas
		$this->alta_test('T001 - Alta exitosa - Crea un concurrente');
		$this->alta_vacia_test('T002 - Alta incorrecta - Campos obligatorios vacios');
		
		//Test - Consultas
		$this->consulta_todos_test('T003 - Búsqueda exitosa - Buscar todos los concurrentes');
		$this->consulta_codigo_test('T004 - Búsqueda exitosa - Buscar un concurrentes en particular ');
		$this->consulta_incorrecta_test('T005 - Búsqueda incorrecta - Buscar un concurrente inexistente');
		
		//Test - Edición
		$this->editar('T006 - Edición exitosa - Búsqueda y edición de un concurrente');
		$this->editar_inc('T007 - Edición incorrecta - Búsqueda y edición de un concurrente sin un campo obligatorio');
		
		//Test - Borrado
		$this->baja_test('T008 - Baja correcta - Baja de un concurrente');
		$this->baja_inc_test('T009 - Baja incorrecta - Baja de un concurrente inexistente');
				
		echo $this->unit->report();
	}
	
	/**
	* Alta - Caso satisfactorio
	* @return void
	*/
	public function alta_test($name)
	{
		$assistant = new stdClass();
		
		$assistant->idDiner 			= $this->idDiner_test		;
		$assistant->name  				= $this->name  				;
		$assistant->surname        		= $this->surname        	;
		$assistant->bornDate			= $this->bornDate			;
		$assistant->street    			= $this->street    			;
		$assistant->streetNumber    	= $this->streetNumber    	;
		$assistant->floor				= $this->floor				;
		$assistant->door				= $this->door				;
		$assistant->floor				= $this->floor				;
		$assistant->zipcode				= $this->zipcode			;
		$assistant->latitude			= $this->latitude			;
		$assistant->longitude			= $this->longitude			;
		$assistant->phone				= $this->phone				;
		$assistant->contactName			= $this->contactName		;
		$assistant->scholarship			= $this->scholarship		;
		$assistant->eatAtOwnHouse		= $this->eatAtOwnHouse		;
		$assistant->economicSituation	= $this->economicSituation	;
		$assistant->celiac				= $this->celiac				;
		$assistant->diabetic			= $this->diabetic			;
		$assistant->document			= $this->document			;
		
		
		$test             = $this->Assistant_model->add($assistant);
		$this->id_test    = $test['idAssistant'];
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
		$assistant = new stdClass();
		
		$assistant->idDiner 			= $this->idDiner_test		;
		$assistant->name  				= $this->name  				;
		
		$test             = $this->Assistant_model->add($assistant);
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
	    $test             = $this->Assistant_model->get_assistants_by_page_and_idDiner(0, $this->idDiner_test);
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
	    $test             = $this->Assistant_model->search_by_id($this->id_test);
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
		$test  = $this->Assistant_model->get_assistants_by_idDiner($this->id_inc_test);
	    
	    $expected_result  = 'is_null';
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	 * Edicion - Edición satisfactoria
	 * @return void
	 */
	public function editar($name)
	{
		$assistant = new stdClass();
	
	    //Inicialización variables Test
	    $assistant->id					= $this->id_test;
		$assistant->idDiner 			= $this->idDiner_test		;
		$assistant->name  				= $this->name  				;
		$assistant->surname        		= $this->surname        	;
		$assistant->bornDate			= $this->bornDate			;
		$assistant->street    			= $this->street    			;
		$assistant->streetNumber    	= $this->streetNumber    	;
		$assistant->floor				= $this->floor				;
		$assistant->door				= $this->door				;
		$assistant->floor				= $this->floor				;
		$assistant->zipcode				= $this->zipcode			;
		$assistant->latitude			= $this->latitude			;
		$assistant->longitude			= $this->longitude			;
		$assistant->phone				= $this->phone				;
		$assistant->contactName			= $this->contactName		;
		$assistant->scholarship			= $this->scholarship		;
		$assistant->eatAtOwnHouse		= 1		;
		$assistant->economicSituation	= $this->economicSituation	;
		$assistant->celiac				= $this->celiac				;
		$assistant->diabetic			= $this->diabetic			;
		$assistant->document			= $this->document			;
		
		//Inicio del Test
	    $test      = $this->Assistant_model->edit($assistant);
	    $test_name = $name;
	    $notes     = var_export($test, true);
	    $this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	
	/**
	 * Edicion - Edición erronea con campos obligatorios vacíos
	 * @return void
	 */
	public function editar_inc($name)
	{
		$assistant = new stdClass();
	
	    //Inicialización variables Test
	    $assistant->id			= $this->id_test;
		$assistant->idDiner 	= $this->idDiner_test;
		$assistant->name 		= null;
		$assistant->surname 	= null;
		
		//Inicio del Test
	    $test      = $this->Assistant_model->edit($assistant);
	    $test_name = $name;
	    $notes     = var_export($test, true);
	    $this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	/**
	* Baja - Baja exitosa
	* @return void
	*/
	public function baja_test($name)
	{
		$test = $this->Assistant_model->delete($this->id_test);
		$expected_result  = true;
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Testo Baja - Baja incorrecta por un id inexistente
	* @return void
	*/
	public function baja_inc_test($name)
	{
	    $test = $this->Assistant_model->delete($this->id_inc_test);
		
		$expected_result  = 'is_null';
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
}