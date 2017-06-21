<?php
class Input_type_test extends CI_Controller {

	/**
	* Liga_prueba se usa para poder probar completo ABM de torneos. Este necesita una Liga.
	*
	*/
	public $code_test = 'PANTALLA';
	public $name_test = 'Display' ;
	public $description_test = 'Display' ;
	
	public $code;
	public $name;
	public $description;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Input_type_model');
		$this->load->library('unit_test');
	}
	
	/**
	* Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	* @return void
	*/
	public function index()
	{
		$this->alta_test();
		/*$this->consulta_test_por_anio();
		$this->consulta_test();
		$this->consulta_test_por_torneo_inexistente();
		$this->consulta_test_por_nombre();
		$this->baja_test();
		$this->consulta_tipo_modalidad();
		$this->consulta_equipos();
		*/
		echo $this->unit->report();
	}
	
	/**
	* Funcion para testear el alta satisfactoria de una persona
	* @return void
	*/
	public function alta_test()
	{
		$input_type = new stdClass();

		$input_type->code             = $this->code_test;
		$input_type->name             = $this->name_test;
		$input_type->description      = $this->description_test;
		
		
		//$resultado['resultado']='OK';
		
		$test = $this->Input_type_model->add($input_type);
		//$this->id_torneo_prueba = $test['id']; 
		
		//$resultado['id']=$test['id'];
		
		//$expected_result = $resultado;
		$test_name = 'Alta Input Type';
		$notes = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	
	/**
	* @todo
	* Funcion para testear el alta de una persona existente
	* @return void
	*/
	public function alta_duplicada_test()
	{
	}
	
	/**
	* Funcion para testear la consulta satisfactoria de todos los torneos
	* @return void
	*/
	public function consulta_test()
	{
	$test = $this->Torneo_model->consulta();
	$expected_result = 'is_array';
	$test_name = 'Consulta torneo';
	$notes = var_export($test, true);
	$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Funcion para testear la consulta satisfactoria del torneo de un anio
	* @return void
	*/
	public function consulta_test_por_anio()
	{
	$test = $this->Torneo_model->consulta('', $this->anio_prueba);
	$expected_result = 'is_array';
	$test_name = 'Consulta torneos por anio';
	$notes = var_export($test, true);
	$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Funcion para testear la consulta de un torneo inexistente
	* @return void
	*/
	public function consulta_test_por_torneo_inexistente()
	{
	$test = $this->Torneo_model->consulta('','2050');
	$expected_result = 'is_array'; //Espera un array vacio
	$test_name = 'Consulta de torneo por anio inexistente';
	$notes = var_export($test, true);
	$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Funcion para testear la consulta por nombre de torneo
	* @return void
	*/
	public function consulta_test_por_nombre()
	{
	$test = $this->Torneo_model->consulta(NULL, NULL,'Torneo');
	$expected_result = 'is_array';
	$test_name = 'Consulta de torneo por nombre. Solo deben aparecer los torneos que empiecen con la palabra Torneo.';
	$notes = var_export($test, true);
	$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Funcion para testear la baja satisfactoria de un torneo.
	* @return void
	*/
	public function baja_test()
	{
	
	$input_type = new stdClass();
	
	$input_type->code             = $this->code_test;
	$input_type->name             = $this->name_test;
	$input_type->description      = $this->description_test;
	
	$test = $this->Input_type_model->baja($input_type);
	$resultado['resultado']='OK';
	$expected_result = $resultado;
	$test_name = 'Baja torneo por cuil';
	$notes = var_export($test, true);
	$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Funcion para testear la consulta satisfactoria de un torneo
	* @return void
	*/
	public function consulta_tipo_modalidad()
	{
	$test = $this->Torneo_model->consulta_tipo_modalidad();
	$expected_result = 'is_array';
	$test_name = 'Consulta de tipos de modalidad de torneo';
	$notes = var_export($test, true);
	$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Funcion para testear la consulta satisfactoria de los equipos participantes en un torneo
	* @return void
	*/
	public function consulta_equipos()
	{
	$test = $this->Torneo_model->obtener_equipos(75);
	$expected_result = 'is_array';
	$test_name = 'Consulta de equipos participantes en un torneo';
	$notes = var_export($test, true);
	$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	
	/**
	* @todo
	* falta validacion de rega de negocio. .
	* @return void
	*/
}