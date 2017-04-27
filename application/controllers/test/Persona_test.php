<?php
class Persona_test extends CI_Controller {
	
	/**
	 * Cuil que se creara en la primer prueba, si falla el alta, fallaran las pruebas asociadas a este CUIL
	 * @var string
	 */
	public $cuil_prueba = '99999999999';
	
	public $cuil;
	public $nombre;
	public $apellido;
	public $mail;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Persona_model');
		$this->load->library('unit_test');
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		$this->alta_test();
		$this->consulta_test();
		mysqli_next_result($this->db->conn_id);
		$this->consulta_test_por_cuil();
		mysqli_next_result($this->db->conn_id);
		$this->consulta_test_por_cuil_inexistente();
		mysqli_next_result($this->db->conn_id);
		$this->baja_test();
		echo $this->unit->report();
	}
	
	/**
	 * Funcion para testear el alta satisfactoria de una persona
	 * @return void
	 */
	public function alta_test()
	{
		$persona = new stdClass();
		$persona->cuil 		= $this->cuil_prueba;
		$persona->nombre 	= 'Nombre Test';
		$persona->apellido 	= 'Apellido Test';
		$persona->mail 		= 'mail@test.com';
		$resultado['resultado']='OK';
		$test = $this->Persona_model->alta($persona);
		$expected_result = $resultado;
		$test_name = 'Alta persona';
		$this->unit->run($test, $expected_result, $test_name);
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
	 * Funcion para testear la consulta satisfactoria de todas las personas
	 * @return void
	 */
	public function consulta_test()
	{
		$test = $this->Persona_model->consulta();
		$expected_result = 'is_array';
		$test_name = 'Consulta persona';
		$notes = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	 * Funcion para testear la consulta satisfactoria de una persona
	 * @return void
	 */
	public function consulta_test_por_cuil()
	{
		$test = $this->Persona_model->consulta($this->cuil_prueba);
		$expected_result = 'is_object';
		$test_name = 'Consulta persona por cuil';
		$notes = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	 * Funcion para testear la consulta satisfactoria de una persona
	 * @return void
	 */
	public function consulta_test_por_cuil_inexistente()
	{
		$test = $this->Persona_model->consulta('');
		$expected_result = array();//Espera un array vacio
		$test_name = 'Consulta persona por cuil inexistente';
		$notes = var_export($test, true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	/**
	 * Funcion para testear la baja satisfactoria de una persona
	 * @return void
	 */
	public function baja_test()
	{
		$test = $this->Persona_model->baja($this->cuil_prueba);
		$resultado['resultado']='OK';
		$expected_result = $resultado;
		$test_name = 'Baja persona por cuil';
		$this->unit->run($test, $expected_result, $test_name);
	}
}