<?php
class Event_test extends CI_Controller {
	/**
	* Diner_input_test se usa para probar el ABM de Eventos
	*
	*/
    //Id
    public $id_test;
	public $id_inc_test    = 0;
	
	//Test Creación
	public $idDiner				= '2';
	public $name  				= 'Evento del comedor';//Obligatorio
	public $street			  	= 'Juramento';//Obligatorio
	public $streetNumber	  	= '1012';//Obligatorio
	public $zipCode			  	= '1012';//Obligatorio
	public $floor        		= '1';
	public $door        		= 'B';
	public $link        		= 'www.evento.com.ar';
	public $description			= 'Evento en el comedor';
	public $date    			= '2017-11-21';//Obligatorio
	public $phone    			= '123123123';
	public $latitude			= '-34.603684';
	public $longitude			= '-58.381559';
	
	/**
	* Unit Test - Constructor Diner Input
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array( 'login'));
		$this->load->model(array('Event_model'));
		$this->load->library('unit_test');
	}
	
	/**
	* Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	* @return void
	*/
	public function index()
	{  
		//Test - Altas
		$this->alta_test('T001 - Alta exitosa - Crea un Evento');
		$this->alta_vacia_test('T002 - Alta incorrecta - Campos obligatorios vacios');
		
		//Test - Consultas
		$this->consulta_todos_test('T003 - Búsqueda exitosa - Buscar todos los Eventos de un comedor');
		$this->consulta_codigo_test('T004 - Búsqueda exitosa - Buscar un Evento particular ');
		$this->consulta_incorrecta_test('T005 - Búsqueda incorrecta - Buscar un Evento inexistente');
		
		//Test - Edición
		$this->editar('T006 - Edición exitosa - Búsqueda y edición de un Evento');
		$this->editar_inc('T007 - Edición incorrecta - Búsqueda y edición de un Evento con un ID incorecto');
		
		//Test - Borrado
		$this->borrar('T008 - Borrado exitoso - Búsqueda y borrado de un Evento');
		$this->borrar_inc('T009 - Borrado incorrecto - Borrado de un Evento con un ID incorrecto ');
				
		echo $this->unit->report();
	}
	
	/**
	* Alta - Caso satisfactorio
	* @return void
	*/
	public function alta_test($name)
	{
		$event = new stdClass();
		
		$event->idDiner		  		= $this->idDiner		  	;
		$event->name		  		= $this->name		  		;
		$event->street			 	= $this->street 			;
		$event->streetNumber       	= $this->streetNumber		;
		$event->description			= $this->description		;
		$event->zipCode    			= $this->zipCode   			;
		$event->date    			= $this->date    			;
		$event->floor    			= $this->floor    			;
		$event->door    			= $this->door    			;
		$event->date    			= $this->date    			;
		$event->phone    			= $this->phone    			;
		$event->link    			= $this->link    			;
		$event->latitude    		= $this->latitude  			;
		$event->longitude    		= $this->longitude 			;
		
		$test             = $this->Event_model->add($event);
		$this->id_test    = $test['idEvent'];
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
		$event = new stdClass();


		$event->name  	= $this->name  		;
		$event->street 	= null 	;
		
		$test             = $this->Event_model->add($event);
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
	    $test             = $this->Event_model->get_events_by_page(0);
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
	    $test             = $this->Event_model->search_by_id($this->id_test);
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
		$test  = $this->Event_model->search_by_id($this->id_inc_test);
	    
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
		$event = new stdClass();
	
	    //Inicialización variables Test
	    $event->id					= $this->id_test;		
	    $event->idDiner		  		= $this->idDiner		  	;
		$event->name		  		= $this->name		  		;
		$event->street			 	= $this->street 			;
		$event->streetNumber       	= $this->streetNumber		;
		$event->description			= $this->description		;
		$event->zipCode    			= $this->zipCode   			;
		$event->date    			= $this->date    			;
		$event->floor    			= $this->floor    			;
		$event->door    			= $this->door    			;
		$event->date    			= $this->date    			;
		$event->phone    			= $this->phone    			;
		$event->link    			= 'www.eventomodificado.com.ar';
		$event->latitude    		= $this->latitude  			;
		$event->longitude    		= $this->longitude 			;
		
		//Inicio del Test
	    $test      = $this->Event_model->edit($event);
	    $test_name = $name;
	    $notes     = var_export($test, true);
	    $this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	
	/**
	 * Edicion - Edición erronea con ID vacío
	 * @return void
	 */
	public function editar_inc($name)
	{
		$event = new stdClass();
	
	    //Inicialización variables Test
	    $event->name				= $this->id_inc_test;
	    $event->idDiner		  		= $this->idDiner		  	;
		$event->name		  		= $this->name		  		;
		$event->street			 	= $this->street 			;
		$event->streetNumber       	= $this->streetNumber		;
		$event->description			= $this->description		;
		$event->zipCode    			= $this->zipCode   			;
		$event->date    			= $this->date    			;
		$event->floor    			= $this->floor    			;
		$event->door    			= $this->door    			;
		$event->date    			= $this->date    			;
		$event->phone    			= $this->phone    			;
		$event->link    			= 'www.eventomodificado.com.ar';
		$event->latitude    		= $this->latitude  			;
		$event->longitude    		= $this->longitude 			;
		
		//Inicio del Test
	    $test      = $this->Event_model->edit($event);
	    $test_name = $name;
	    $notes     = var_export($test, true);
	    $this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	/**
	 * Edicion - Edición satisfactoria
	 * @return void
	 */
	public function borrar($name)
	{
		//Inicio del Test
		$test      = $this->Event_model->edit($this->id_test);
		$test_name = $name;
		$notes     = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	
	/**
	 * Edicion - Edición erroneo con id incorrecto
	 * @return void
	 */
	public function borrar_inc($name)
	{	
		//Inicio del Test
		$test      = $this->Event_model->delete($this->id_inc_test);
		$test_name = $name;
		$notes     = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
}