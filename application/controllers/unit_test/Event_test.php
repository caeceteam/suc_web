<?php
class Event_test extends CI_Controller {
	/**
	* Event_test se usa para probar el ABM de Eventos
	*
	*/
    //Id
    public $id_test;
	public $id_inc_test    = 0;
	
	//Test Creación
	public $idDiner		  		= '1';//Obligatorio
	public $name	  			= 'Evento Madre';//Obligatorio
	public $street	        	= 'Antonio Malaver';
	public $streetNumber		= '923';
	public $floor	    		= '1';//Obligatorio
	public $door	    		= 'A';//Obligatorio
	public $zipCode				= '1623';
	public $phone				= '112312312';
	public $date				= '2017-12-12';
	public $latitude			= '-34.6653';
	public $longitude			= '-58.7269';
	public $link				= 'www.evento.com.ar';
	public $description			= 'Evento dia de la madre';
	
	
	/**
	* Unit Test - Constructor Event
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
		$this->consulta_todos_test('T003 - Búsqueda exitosa - Buscar todos los eventos');
		$this->consulta_codigo_test('T004 - Búsqueda exitosa - Buscar un evento en particular ');
		$this->consulta_incorrecta_test('T005 - Búsqueda incorrecta - Buscar un evento inexistente');
		
		//Test - Edición
		$this->editar('T006 - Edición exitosa - Búsqueda y edición de un evento');
		$this->editar_inc('T007 - Edición incorrecta - Búsqueda y edición de un evento sin un campo obligatorio');
		
		//Test - Borrado
		$this->baja_test('T008 - Baja correcta - Baja de un evento');
		$this->baja_inc_test('T009 - Baja incorrecta - Baja de un evento inexistente');
				
		echo $this->unit->report();
	}
	
	/**
	* Alta - Caso satisfactorio
	* @return void
	*/
	public function alta_test($name)
	{
		$event = new stdClass();
		
		$event->idDiner			= $this->idDiner		;
		$event->name	  		= $this->name	  		;
		$event->street	    	= $this->street	    	;
		$event->streetNumber	= $this->streetNumber	;
		$event->floor	    	= $this->floor	    	;
		$event->door	    	= $this->door	    	;
		$event->zipCode			= $this->zipCode		;
		$event->phone			= $this->phone			;
		$event->date			= $this->date			;
		$event->latitude		= $this->latitude		;
		$event->longitude		= $this->longitude		;
		$event->link			= $this->link			;
		$event->description		= $this->description	;
		
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


		$event->idDiner			= $this->idDiner		;
		$event->name	  		= NULL	  		;
		
		$test             = $this->Event_model->add($event);
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, 'is_null' , $test_name, $notes);
	}
	
	/**
	* Consulta - Consulta satisfactoria del todos los elementos existentes
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
	* Consulta - Consulta satisfactoria por codigo
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
	    $event->id				= $this->id_test		;
		$event->idDiner			= $this->idDiner		;
		$event->name	  		= $this->name	  		;
		$event->street	    	= $this->street	    	;
		$event->streetNumber	= $this->streetNumber	;
		$event->floor	    	= $this->floor	    	;
		$event->door	    	= $this->door	    	;
		$event->zipCode			= $this->zipCode		;
		$event->phone			= $this->phone			;
		$event->date			= $this->date			;
		$event->latitude		= $this->latitude		;
		$event->longitude		= $this->longitude		;
		$event->link			= $this->link			;
		$event->description		= 'Evento editado';
		
		//Inicio del Test
	    $test      = $this->Event_model->edit($event);
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
		$event = new stdClass();
	
	    //Inicialización variables Test
		$event->id				= $this->id_inc_test	;
		$event->idDiner			= $this->idDiner		;
		$event->name	  		= $this->name	  		;
		$event->street	    	= $this->street	    	;
		$event->streetNumber	= $this->streetNumber	;
		$event->floor	    	= $this->floor	    	;
		$event->door	    	= $this->door	    	;
		$event->zipCode			= $this->zipCode		;
		$event->phone			= $this->phone			;
		$event->date			= $this->date			;
		$event->latitude		= $this->latitude		;
		$event->longitude		= $this->longitude		;
		$event->link			= $this->link			;
		$event->description		= 'Evento editado';
		
		//Inicio del Test
	    $test      = $this->Event_model->edit($event);
	    $test_name = $name;
	    $notes     = var_export($test, true);
	    $this->unit->run($test, 'is_null' , $test_name, $notes);
	}
	
	/**
	* Baja - Baja exitosa
	* @return void
	*/
	public function baja_test($name)
	{
		$test = $this->Event_model->delete($this->id_test);
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
	    $test = $this->Event_model->delete($this->id_inc_test);
		
		$expected_result  = 'is_null';
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
}