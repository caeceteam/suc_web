<?php
class Input_type_test extends CI_Controller {

	/**
	* Input_type_test se usa para probar el ABPM de Tipos de insumos
	*
	*/
	public $id_test   = 1;
	public $id_inc_test = 192;
	public $id_edit_test = 1;
	
	public $code_inc_test = 'EAEAEAEA';
	public $code_dupl_test = 'UTIL';
	public $code_test = 'UTIL';
	public $code_edit_test = 'PAPEL';
	
	public $name_test = 'Utiles escolares' ;
	public $name_edit_test = 'Papel higiénico 3';
	public $description_test = 'Utiles escolares' ;
	public $description_edit_test = 'Papel higienico 2' ;
	
	public $id;
	public $code;
	public $code_inc;
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
		//$this->alta_test();
		//$this->alta_dupl_test(); //da error
		$this->consulta_todos_test();
		//$this->consulta_codigo_test();
		//$this->consulta_incorrecta_test();
		//$this->editar(); //da error
		//$this->editar_inc();
		//$this->baja_test();
		//$this->baja_inc_test();
		
		echo $this->unit->report();
	}
	
	/**
	* Funcion para testear el alta satisfactoria
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
	* Funcion para testear el alta con código duplicado
	* @return void
	*/
	public function alta_dupl_test()
	{
		$input_type = new stdClass();

		$input_type->code             = $this->code_dupl_test;
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
	* Funcion para testear la consulta satisfactoria de todos los InputType
	* @return void
	*/
	public function consulta_todos_test()
	{
		$test = $this->Input_type_model->search();
		$expected_result = 'is_array';
		$test_name = 'Consulta tipo de insumo';
		$notes = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	* Funcion para testear la consulta satisfactoria
	* @return void
	*/
	public function consulta_codigo_test()
	{	
		
		$test = $this->Input_type_model->search($this->id_test);
		$expected_result = 'is_array';
		$test_name = 'Consulta torneos por ID';
		$notes = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	 * Funcion para testear la consulta con código incorrecto
	 * @return void
	 */
	public function consulta_incorrecta_test()
	{

		$test = $this->Input_type_model->search($this->id_inc_test);
		$expected_result = '404';
		$test_name = 'Consulta torneos por ID incorrecto';
		$notes = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	/**
	 * Funcion para testear la edición 
	 * @return void
	 */
	public function editar()
	{
		$input_type = new stdClass();

		$input_type->id               = $this->id_edit_test;
		$input_type->code             = $this->code_edit_test;
		$input_type->name             = $this->name_edit_test;
		$input_type->description      = $this->description_edit_test;
	
	
		//$resultado['resultado']='OK';
	
		$test = $this->Input_type_model->edit($input_type);
		//$this->id_torneo_prueba = $test['id'];
	
		//$resultado['id']=$test['id'];
	
		//$expected_result = $resultado;
		$test_name = 'Edit Input Type';
		$notes = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	/**
	 * Funcion para testear la edición con código incorrecto
	 * @return void
	 */
	public function editar_inc()
	{
		$input_type = new stdClass();
	
		$input_type->id               = $this->id_inc_test;
		$input_type->code             = $this->code_edit_test;
		$input_type->name             = $this->name_edit_test;
		$input_type->description      = $this->description_edit_test;
	
	
		//$resultado['resultado']='OK';
	
		$test = $this->Input_type_model->edit($input_type);
		//$this->id_torneo_prueba = $test['id'];
	
		//$resultado['id']=$test['id'];
	
		//$expected_result = $resultado;
		$test_name = 'Edit Input Type';
		$notes = var_export($test, true);
		$this->unit->run($test, 'is_array' , $test_name, $notes);
	}
	/**
	* Funcion para testear la baja satisfactoria de un torneo.
	* @return void
	*/
	public function baja_test()
	{
		
		$test = $this->Input_type_model->delete($this->id_test);
		$resultado['resultado']='OK';
		$expected_result = $resultado;
		$test_name = 'Baja tipo de insumo';
		$notes = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	 * Funcion para testear la baja satisfactoria de un torneo.
	 * @return void
	 */
	public function baja_inc_test()
	{
	
		$test = $this->Input_type_model->delete($this->id_inc_test);
		$resultado['resultado']='OK';
		$expected_result = $resultado;
		$test_name = 'Baja tipo de insumo';
		$notes = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	
}