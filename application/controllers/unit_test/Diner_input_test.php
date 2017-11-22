<?php
class Diner_input_test extends CI_Controller {
	/**
	* Diner_input_test se usa para probar el ABM de Stock de insumos
	*
	*/
    //Id
    public $id_test;
	public $id_inc_test    = 0;
	
	//Test Creación
	public $idDiner_test  		= '1';//Obligatorio
	public $idInputType_test  	= '2';//Obligatorio
	public $name_test        	= 'Libros elige tu propia aventura';
	public $size_test			= '';
	public $genderType_test    	= 'U';//Obligatorio
	public $quantity_test    	= '10';//Obligatorio
	public $description_test	= '10 libros de tapa dura en muy buenas condiciones.';
	
	/**
	* Unit Test - Constructor Diner Input
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array( 'login'));
		$this->load->model(array('Diner_input_model'));
		$this->load->library('unit_test');
	}
	
	/**
	* Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	* @return void
	*/
	public function index()
	{  
		//Test - Altas
		$this->alta_test('T001 - Alta exitosa - Crea un stock de un insumo');
		$this->alta_vacia_test('T002 - Alta incorrecta - Campos obligatorios vacios');
		
		//Test - Consultas
		$this->consulta_todos_test('T003 - Búsqueda exitosa - Buscar todos los stocks de insumos');
		$this->consulta_codigo_test('T004 - Búsqueda exitosa - Buscar un stock de insumo en particular ');
		$this->consulta_incorrecta_test('T005 - Búsqueda incorrecta - Buscar un stock de insumo inexistente');
		
		//Test - Edición
		$this->editar('T006 - Edición exitosa - Búsqueda y edición de un stock de insumo');
		$this->editar_inc('T007 - Edición incorrecta - Búsqueda y edición de un stock sin un campo obligatorio');
		
		//Test - Borrado
		$this->baja_test('T008 - Baja correcta - Baja de un stock de insumo');
		$this->baja_inc_test('T009 - Baja incorrecta - Baja de un stock de insumo inexistente');
				
		echo $this->unit->report();
	}
	
	/**
	* Alta - Caso satisfactorio
	* @return void
	*/
	public function alta_test($name)
	{
		$diner_input = new stdClass();
		
		$diner_input->idDiner 		= $this->idDiner_test;
		$diner_input->idInputType 	= $this->idInputType_test;
		$diner_input->name 			= $this->name_test;
		$diner_input->size 			= $this->size_test;
		$diner_input->genderType 	= $this->genderType_test;
		$diner_input->quantity 		= $this->quantity_test;
		$diner_input->description 	= $this->description_test;
		
		$test             = $this->Diner_input_model->add($diner_input);
		$this->id_test    = $test['idDinerInput'];
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
		$diner_input = new stdClass();
		
		$diner_input->name 			= $this->name_test;
		$diner_input->size 			= $this->size_test;
		$diner_input->description 	= $this->description_test;
		
		$test             = $this->Diner_input_model->add($diner_input);
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	/**
	* Consulta - Consulta satisfactoria del todos los elementos existentes
	* @return void
	*/
	public function consulta_todos_test($name)
	{   
	    //Inicio del Test
	    $test             = $this->Diner_input_model->get_dinerinputs_by_page(0);
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
	    $test             = $this->Diner_input_model->search_by_id($this->id_test);
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
		$test  = $this->Diner_input_model->search_by_id($this->id_inc_test);
	    
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
		$diner_input = new stdClass();
	
	    //Inicialización variables Test
	    $diner_input->id			= $this->id_test;
		$diner_input->idDiner 		= $this->idDiner_test;
		$diner_input->idInputType 	= $this->idInputType_test;
		$diner_input->name 			= 'Libros de Agatha Christie';
		$diner_input->size 			= '';
		$diner_input->genderType 	= 'U';
		$diner_input->quantity 		= '12';
		$diner_input->description 	= '12 libros de tapa blanda de misterio';
		
		//Inicio del Test
	    $test      = $this->Diner_input_model->edit($diner_input);
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
		$diner_input = new stdClass();
	
	    //Inicialización variables Test
	    $diner_input->id			= $this->id_test;
		$diner_input->idDiner 		= null;
		$diner_input->idInputType 	= null;
		$diner_input->name 			= 'Libros de Agatha Christie';
		$diner_input->size 			= '';
		$diner_input->genderType 	= null;
		$diner_input->quantity 		= null;
		$diner_input->description 	= '12 libros de tapa blanda de misterio';
		
		//Inicio del Test
	    $test      = $this->Diner_input_model->edit($diner_input);
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
		$test = $this->Diner_input_model->delete($this->id_test);
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
	    $test = $this->Diner_input_model->delete($this->id_inc_test);
		
		$expected_result  = 'is_null';
		$test_name        = $name;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
}