<?php
class Food_type_test extends CI_Controller {

	/**
	* Food_type_test se usa para probar el ABPM de Tipos de insumos
	*
	*/
    //Id
    public $id_test;
	public $id_inc_test    = 192;
	public $id_edit_test   = 1;
	
	//Test Creación
	public $name_test        = 'Polenta';
	public $code_test        = 'POL';
	public $description_test = 'Polenta envase por KG' ;
	public $perishable_test  = 'X';
	public $celiac_test      = 'X';
	public $diabetic_test    = 'X';
	
	//Test Duplicado
	public $name_test_dup        = 'Polenta';
	public $code_test_dup        = 'POL';
	public $description_test_dup = 'Polenta envase por KG' ;
	public $perishable_test_dup  = 'X';
	public $celiac_test_dup      = 'X';
	public $diabetic_test_dup    = 'X';

	//Test Edición
	public $name_test_edi        = 'Polenta';
	public $code_test_edi        = 'POL';
	public $description_test_edi = 'Polenta envase por 1/2 KG' ;
	public $perishable_test_edi  = '';
	public $celiac_test_edi      = '';
	public $diabetic_test_edi    = '';
	public $code_test_inc_edi;

	
	/**
	* Unit Test - Constructor Food Type
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array( 'login'));
		$this->load->model('Food_type_model');
		$this->load->library('unit_test');
	}
	
	/**
	* Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	* @return void
	*/
	public function index()
	{  
	    
		
		//Test - Altas
		$this->alta_test('T001 - Crear Correcto - Crea un tipos de Alimentos');
		$this->alta_dupl_test('T002 - Crear Incorrecto - Crea un tipos de Alimentos');

		//Test - Consultas API
		$this->consulta_todos_test('T003 - Buscar Correcto - Buscar todos los tipos de Alimentos');
		$this->consulta_codigo_test('T004 - Buscar Correcto - Buscar un tipo de Alimento particular ');
		$this->consulta_incorrecta_test('T005 - Buscar Incorrecta - Buscar un tipos de Alimentos no existente');
		
		
		//Test - Editar
		$this->editar('T006 - Editar Correcto - Buscar y edita un tipo de alimento');
		$this->editar_inc('T007 - Editar Incorrecto - Buscar y edita sin campo obligatorio');
		
		//Test - Borrado
		$this->baja_test('T008 - Editar Incorrecto - Buscar y edita sin campo obligatorio');
		//$this->baja_inc_test('T009 - Editar Incorrecto - Buscar y edita sin campo obligatorio');
				
		echo $this->unit->report();
	}
	
	/**
	* Alta nuevo tipo - Caso satisfactorio
	* @return void
	*/
	public function alta_test($tit_test)
	{
		$food_type = new stdClass();
		//Test Duplicado
		$food_type->code         = $this->code_test;
		$food_type->name         = $this->name_test;
		$food_type->description  = $this->description_test;
		$food_type->perishable   = $this->perishable_test;
		$food_type->celiac       = $this->celiac_test;
		$food_type->diabetic     = $this->diabetic_test;
		
		$test             = $this->Food_type_model->add($food_type);
		$this->id_test    = $test['idFoodType'];
		$test_name        = $tit_test;
		$notes            = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	/**
	* Alta duplicado tipo - Caso satisfactorio
	* @return void
	*/
	public function alta_dupl_test($tit_test)
	{
		$food_type = new stdClass();
        //Inicializacion de capos Test
		$food_type->code         = $this->code_test_dup;
		$food_type->name         = $this->name_test_dup;
		$food_type->description  = $this->description_test_dup;
		$food_type->perishable   = $this->perishable_test_dup;
		$food_type->celiac       = $this->celiac_test_dup;
		$food_type->diabetic     = $this->diabetic_test_dup;
		
		//Inicio de la Prueba
		$test         = $this->Food_type_model->add($food_type);
		$test_name    = $tit_test;
		$notes        = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	/**
	* Consulta Todos los Tipos alimento - Cosntulta satisfactoria de todos los Food Type
	* @return void
	*/
	public function consulta_todos_test($tit_test)
	{   
	    //Inicio del Test
	    $test             = $this->Food_type_model->get_foodtypes_by_page(0);
		$expected_result  = 'is_array';
		$test_name        = $tit_test;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Consulta un Tipos alimento - Cosntulta satisfactoria de todos los Food Type
	* @return void
	*/
	public function consulta_codigo_test($tit_test)
	{	
	    //Inicio del Test
	    $test             = $this->Food_type_model->search_by_id($this->id_test);
	    $expected_result  = 'is_array';
		$test_name        = $tit_test;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Consulta un Tipos alimento - Incorrecta Food Type
	* @return void
	*/
	public function consulta_incorrecta_test($tit_test)
	{
	    //Inicio del Test
	    try{
	       $test  = $this->Food_type_model->search_by_id($this->id_inc_test);
		}catch(Exception $e){}
	    
	    $expected_result  = 'is_null';
		$test_name        = $tit_test;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	 * Testeo Edicion - Testeo para la edición de documentos
	 * @return void
	 */
	public function editar($tit_test)
	{
	    $food_type = new stdClass();
	
	    //Inicialización variables Test
	    $food_type->id           = $this->id_test;
		$food_type->code         = $this->code_test_edi;
		$food_type->name         = $this->name_test_edi;
		$food_type->description  = $this->description_test_edi;
		$food_type->perishable   = $this->perishable_test_edi;
		$food_type->celiac       = $this->celiac_test_edi;
		$food_type->diabetic     = $this->diabetic_test_edi;
		
		//Inicio del Test
	    $test      = $this->Food_type_model->edit($food_type);
	    $test_name = $tit_test;
	    $notes     = var_export($test, true);
	    $this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	
	/**
	 * Testeo Edicion - Edición erronea
	 * @return void
	 */
	public function editar_inc($tit_test)
	{
	    $food_type = new stdClass();
	    //Inicialización variables Test   
	    $food_type->id           = $this->id_test;
		$food_type->code         = $this->code_test_inc_edi;
		$food_type->name         = $this->name_test_edi;
		$food_type->description  = $this->description_test_edi;
		$food_type->perishable   = $this->perishable_test_edi;
		$food_type->celiac       = $this->celiac_test_edi;
		$food_type->diabetic     = $this->diabetic_test_edi;
	    
		//Inicio del Test
	    $test       = $this->Food_type_model->edit($food_type);
        $test_name  = $tit_test;
	    $notes      = var_export($test, true);
	    $this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	/**
	* Testo Baja - La baja erronea.
	* @return void
	*/
	public function baja_test($tit_test)
	{
		
		$test = $this->Food_type_model->delete($this->id_test);
		$expected_result  = 'is_bool';
		$test_name        = $tit_test;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Testo Baja - La baja satisfactoria.
	* @return void
	*/
	public function baja_inc_test($tit_test)
	{
	    
	    try{
	       $test = $this->Food_type_model->delete($this->id_inc_test);
	    }catch(Exception $e){}
		
		$expected_result  = 'is_bool';
		$test_name        = $tit_test;
		$notes            = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
}