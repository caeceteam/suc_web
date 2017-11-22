<?php
class Diner_application_test extends CI_Controller {
	/**
	* Diner_application_test se usa para probar la gestión de comedores
	*
	*/
    //Id
    public $id_test;
	public $id_inc_test    = 0;
	
	//Test Creación
	public $name_test;//Obligatorio
	public $street_test          = 'Directorio';
	public $streetNumber_test    = '500';
	public $floor_test           = 'PB';
	public $door_test            = '';
	public $latitude_test        = -34.627898;
	public $longitude_test       = -58.433552;
	public $zipCode_test         = '1424';
	public $phone_test           = '49254399';
	public $description_test     = 'Sede Los Alerces Caballito';
	public $link_test            = 'www.comedorlosalerces.com';
	public $mail_test            = 'losalerces@mailinator.com';
	public $user_name_test       = 'Juan';//Obligatorio
	public $surname_test         = 'Perez';//Obligatorio
	public $user_mail_test;//Obligatorio
	public $user_phone_test      = '1164178793';
	public $bornDate_test        = '1988-01-01';
	public $role_test            = DINER_ADMIN;//Obligatorio
	public $pass_test            = '12345678';//Obligatorio
	public $alias_test;//Obligatorio
	public $docNumber_test       = '33620870';
	public $photos_test          = 'http://res.cloudinary.com/caeceteam/image/upload/v1511296538/ujzeywllsc5ktfomz4p2.png';
	
	/**
	* Unit Test - Constructor Diner Application
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array( 'login', 'unit_test'));
		$this->load->helper('string');
		$this->load->model('Diner_application_model');;
		//Se generan datos random para evitar errores por duplicados
		$random_string = random_string('numeric', 5);
		$this->name_test 		= 'Test_' . $random_string;
		$this->user_mail_test 	= 'Test_' . $random_string . '@mailinator.com';
		$this->alias_test 		= 'Test_' . $random_string;
	}
	
	/**
	* Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	* @return void
	*/
	public function index()
	{  
		//Test - Altas
		$this->alta_test('T001 - Alta exitosa - Crea una solicitud de comedor');
		$this->alta_vacia_test('T002 - Alta incorrecta - Campos obligatorios vacios');
		
		//Test - Consultas
		$this->consulta_todos_test('T003 - Búsqueda exitosa - Buscar todas las solicitudes de comedores');
		$this->consulta_codigo_test('T004 - Búsqueda exitosa - Buscar una solicitud de comedor en particular');
		$this->consulta_incorrecta_test('T005 - Búsqueda incorrecta - Buscar una solicitud de comedor inexistente');
		
		//Test - Edición
		$this->editar('T006 - Edición exitosa - Búsqueda y aprobación de un comedor');
		$this->editar_inc('T007 - Edición incorrecta - Búsqueda y edición de un comedor sin un campo obligatorio');
				
		echo $this->unit->report();
	}
	
	/**
	* Alta - Caso satisfactorio
	* @return void
	*/
	public function alta_test($name)
	{
		$diner_application 			= new stdClass();
		$diner_application->diner 	= new stdClass();
		$diner_application->user 	= new stdClass();
		
		$diner_application->diner->name			= $this->name_test;
		$diner_application->diner->mail			= $this->mail_test;
		$diner_application->diner->street		= $this->street_test;
		$diner_application->diner->streetNumber	= $this->streetNumber_test;
		$diner_application->diner->floor		= $this->floor_test;
		$diner_application->diner->door			= $this->door_test;
		$diner_application->diner->latitude		= $this->latitude_test;
		$diner_application->diner->longitude	= $this->longitude_test;
		$diner_application->diner->zipCode		= $this->zipCode_test;
		$diner_application->diner->phone		= $this->phone_test;
		$diner_application->diner->link			= $this->link_test;
		$diner_application->diner->description	= $this->description_test;
		$diner_application->diner->photos[0] 	= $this->photos_test;
		
		$diner_application->user->name			= $this->user_name_test;
		$diner_application->user->surname		= $this->surname_test;
		$diner_application->user->pass			= $this->pass_test;
		$diner_application->user->alias 		= $this->alias_test;
		$diner_application->user->docNum		= $this->docNumber_test;
		$diner_application->user->mail			= $this->user_mail_test;
		$diner_application->user->phone			= $this->user_phone_test;
		$diner_application->user->bornDate		= $this->bornDate_test;
		$diner_application->user->state 		= USER_INACTIVE;
		$diner_application->user->role 			= $this->role_test;
		
		$test             = $this->Diner_application_model->add($diner_application);
		$this->id_test    = $test['diner']['idDiner'];
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
		$diner_application 			= new stdClass();
		$diner_application->diner 	= new stdClass();
		$diner_application->user 	= new stdClass();
		
		$diner_application->diner->street		= $this->street_test;
		$diner_application->diner->streetNumber	= $this->streetNumber_test;
		$diner_application->diner->floor		= $this->floor_test;
		$diner_application->diner->door			= $this->door_test;
		$diner_application->diner->latitude		= $this->latitude_test;
		$diner_application->diner->longitude	= $this->longitude_test;
		$diner_application->diner->zipCode		= $this->zipCode_test;
		$diner_application->diner->phone		= $this->phone_test;
		$diner_application->diner->link			= $this->link_test;
		$diner_application->diner->description	= $this->description_test;
		$diner_application->diner->photos[0] 	= $this->photos_test;
		
		$diner_application->user->docNum		= $this->docNumber_test;
		$diner_application->user->phone			= $this->user_phone_test;
		$diner_application->user->bornDate		= $this->bornDate_test;
		$diner_application->user->state 		= USER_INACTIVE;
		
		$test             = $this->Diner_application_model->add($diner_application);
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
	    $test             = $this->Diner_application_model->get_pending_diners_by_page(0);
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
	    $test             = $this->Diner_application_model->search_by_id($this->id_test);
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
		$test  = $this->Diner_application_model->search_by_id($this->id_inc_test);
	    
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
		$diner_application 			= new stdClass();
		$diner_application->diner 	= new stdClass();
		$diner_application->user 	= new stdClass();
		
		$diner_application->id					= $this->id_test;
		$diner_application->diner->name			= $this->name_test;
		$diner_application->diner->mail			= $this->mail_test;
		$diner_application->diner->street		= $this->street_test;
		$diner_application->diner->streetNumber	= $this->streetNumber_test;
		$diner_application->diner->floor		= $this->floor_test;
		$diner_application->diner->door			= $this->door_test;
		$diner_application->diner->latitude		= $this->latitude_test;
		$diner_application->diner->longitude	= $this->longitude_test;
		$diner_application->diner->zipCode		= $this->zipCode_test;
		$diner_application->diner->phone		= $this->phone_test;
		$diner_application->diner->link			= $this->link_test;
		$diner_application->diner->description	= $this->description_test;
		//$diner_application->diner->photos[0] 	= $this->photos_test;
		$diner_application->diner->state		= DINER_APPROVED;
		
		$diner_application->user->name			= $this->user_name_test;
		$diner_application->user->surname		= $this->surname_test;
		$diner_application->user->pass			= $this->pass_test;
		$diner_application->user->alias 		= $this->alias_test;
		$diner_application->user->docNum		= $this->docNumber_test;
		$diner_application->user->mail			= $this->user_mail_test;
		$diner_application->user->phone			= $this->user_phone_test;
		$diner_application->user->bornDate		= $this->bornDate_test;
		$diner_application->user->state 		= USER_ACTIVE;
		$diner_application->user->role 			= $this->role_test;
		
		//Inicio del Test
	    $test      = $this->Diner_application_model->edit($diner_application);
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
		$diner_application 			= new stdClass();
		$diner_application->diner 	= new stdClass();
		$diner_application->user 	= new stdClass();
		
		$diner_application->id					= $this->id_inc_test;
		$diner_application->diner->name			= null;
		$diner_application->diner->mail			= $this->mail_test;
		$diner_application->diner->street		= $this->street_test;
		$diner_application->diner->streetNumber	= $this->streetNumber_test;
		$diner_application->diner->floor		= $this->floor_test;
		$diner_application->diner->door			= $this->door_test;
		$diner_application->diner->latitude		= $this->latitude_test;
		$diner_application->diner->longitude	= $this->longitude_test;
		$diner_application->diner->zipCode		= $this->zipCode_test;
		$diner_application->diner->phone		= $this->phone_test;
		$diner_application->diner->link			= $this->link_test;
		$diner_application->diner->description	= $this->description_test;
		$diner_application->diner->state		= DINER_APPROVED;
		
		//Inicio del Test
	    $test      = $this->Diner_application_model->edit($diner_application);
	    $test_name = $name;
	    $notes     = var_export($test, true);
	    $this->unit->run($test, 'is_null' , $test_name, $notes);
	}
}