<?php
class Diner_food_test extends CI_Controller {
	/**
	* Diner_food_test se usa para probar el ABM de Stock de comidas
	*
	*/
    //Id
    public $id_test;
	public $id_inc_test    = 0;
	
	//Test Creación
	public $creationDate_test  	= '2017-11-20';//Obligatorio
	public $idDiner_test        = '1';//Obligatorio
	public $idFoodType_test		= '1';//Obligatorio
	public $name_test  			= 'Fideos';//Obligatorio
	public $description_test    = 'Fideos Don Vicente';
	public $quantity_test    	= '10';
	public $unity_test			= 'Paquetes';
	public $endingDate_test		= '2020-01-01';
	public $expirationDate_test	= '2020-01-01';
	
	/**
	* Unit Test - Constructor Diner Food
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array( 'login'));
		$this->load->model(array('Diner_food_model', 'Food_type_model'));
		$this->load->library('unit_test');
	}
	
	/**
	* Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	* @return void
	*/
	public function index()
	{  
		//Test - Altas
		$this->alta_test('T001 - Alta exitosa - Crea una comida');
		$this->alta_vacia_test('T002 - Alta incorrecta - Campos obligatorios vacios');

		//Test - Consultas
		$this->consulta_todos_test('T003 - Búsqueda exitosa - Buscar todos los stocks de comida');
		$this->consulta_codigo_test('T004 - Búsqueda exitosa - Buscar un stock de comida en particular ');
		$this->consulta_incorrecta_test('T005 - Búsqueda incorrecta - Buscar un stock de comida inexistente');
		
		//Test - Edición
		$this->editar('T006 - Edición exitosa - Búsqueda y edición de un stock de comida');
		$this->editar_inc('T007 - Edición incorrecta - Búsqueda y edición de un stock sin un campo obligatorio');

		//Test - Borrado
		$this->baja_test('T008 - Baja correcta - Baja de un stock de comida');
		$this->baja_inc_test('T009 - Baja incorrecta - Baja de un stock de comida inexistente');
				
		echo $this->unit->report();
	}
	
	/**
	* Alta - Caso satisfactorio
	* @return void
	*/
	public function alta_test($name)
	{
		$diner_food = new stdClass();
		
		$diner_food->creationDate	= $this->creationDate_test;
		$diner_food->idDiner 		= $this->idDiner_test;
		$diner_food->idFoodType 	= $this->idFoodType_test;
		$diner_food->name 			= $this->name_test;
		$diner_food->description 	= $this->description_test;
		$diner_food->quantity 		= $this->quantity_test;
		$diner_food->unity 			= $this->unity_test;
		$diner_food->endingDate		= $this->endingDate_test;
		$diner_food->expirationDate	= $this->expirationDate_test;
		
		$test             = $this->Diner_food_model->add($diner_food);
		$this->id_test    = $test['idDinerFood'];
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
		$diner_food = new stdClass();
	
		$diner_food->description 	= $this->description_test;
		$diner_food->quantity 		= $this->quantity_test;
		$diner_food->unity 			= $this->unity_test;
		$diner_food->endingDate		= $this->endingDate_test;
		$diner_food->expirationDate	= $this->expirationDate_test;
	
		$test             = $this->Diner_food_model->add($diner_food);
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
	    $test             = $this->Diner_food_model->get_dinerfoods_by_page(0);
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
	    $test             = $this->Diner_food_model->search_by_id($this->id_test);
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
	    $test = null;
	    //Inicio del Test
	    try{
	       $test  = $this->Diner_food_model->search_by_id($this->id_inc_test);
		}catch(Exception $e){}
	    
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
	    $diner_food = new stdClass();
	
	    //Inicialización variables Test
	    $diner_food->id				= $this->id_test;
		$diner_food->creationDate	= $this->creationDate_test;
		$diner_food->idDiner 		= $this->idDiner_test;
		$diner_food->idFoodType 	= '1';
		$diner_food->name 			= 'Tomates';
		$diner_food->description 	= 'Tomates cherry';
		$diner_food->quantity 		= '12';
		$diner_food->unity 			= 'cantidad';
		$diner_food->endingDate		= '2017-11-23';
		$diner_food->expirationDate	= null;
		
		//Inicio del Test
	    $test      = $this->Diner_food_model->edit($diner_food);
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
	    $diner_food = new stdClass();
	
	    //Inicialización variables Test
	    $diner_food->id				= $this->id_test;
		$diner_food->creationDate	= $this->creationDate_test;
		$diner_food->idDiner 		= null;
		$diner_food->idFoodType 	= null;
		$diner_food->name 			= null;
		$diner_food->description 	= 'Tomates cherry';
		$diner_food->quantity 		= '12';
		$diner_food->unity 			= 'cantidad';
		$diner_food->endingDate		= '2017-11-23';
		$diner_food->expirationDate	= null;
		
		//Inicio del Test
	    $test      = $this->Diner_food_model->edit($diner_food);
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
		$test = $this->Diner_food_model->delete($this->id_test);
		$expected_result  = 'is_bool';
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
		try{
	       $test = $this->Diner_food_model->delete($this->id_inc_test);
	    }catch(Exception $e){}
		
		$expected_result  = 'is_null';
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
}