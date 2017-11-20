<?php

// La clase Context
class Strategy_context
{

	/**
	 * CI Singleton
	 *
	 * @var object
	 */
	protected $CI;
	
	public $strategy;

	public function __construct() 
	{
		$this->CI =& get_instance();
		
		$this->CI->load->library(array('sys_admin', 'diner_admin', 'colaborator' ,'employee', 'guest', 'session'  ));

		$this->set_role($this->CI->session->role);		
	}
	
	/**
	 * Funcion para setear la estrategia
	 */
	public function set_strategy($strategy)
	{
		$this->strategy = $strategy;
	}
	
	/**
	 * Funcion que retorna el nombre de la vista
	 * del menú que puede utilizar el user según su rol
	 */
	public function get_menu()
	{
		return $this->strategy->get_menu();
	}
	
	/**
	 * Funcion para setear la estrategia según el rol
	 */
	public function set_role($role)
	{
		// Si no está definido el rol,
		// es porque es un invitado dando de alta
		if ( $role === NULL )
		{
			$role = GUEST;
		}
		
		// Creo la estrategia según el rol
		switch ($role) {
			case SYS_ADMIN:
				$this->strategy = new Sys_admin();
				break;
			case DINER_ADMIN:
				$this->strategy = new Diner_admin();
				break;
			case EMPLOYEE:
				$this->strategy = new Employee();
				break;
			case COLABORATOR:
				$this->strategy = new Colaborator();
				break;
			default:
				$this->strategy = new Guest();
				break;
		}
	}
	
	/**
	 * Funcion que devuelve la URL según el permiso
	 * del usuario
	 */
	public function get_url($url)
	{
		return $this->validate_url($url) ? $url : 'errors/html/error_403';
	}
	
	/**
	 * Funcion que valida si el usuario puede 
	 * acceder o no a cierta URL
	 */
	public function validate_url($url)
	{
		//Obtengo los permisos
		$authorization_flags = new stdClass();
		$authorization_flags = $this->strategy->get_authorization();
		
		// VALIDACIÓN
		
		// URL de eventos, almacén, insumos, personal y concurrentes
		if (   (strpos($url, 'event'		)	!== false	)
		 	|| (strpos($url, 'diner_food'	)	!== false	)
		 	|| (strpos($url, 'diner_input'	) 	!== false	)
		 	|| (strpos($url, 'assistant'	)   !== false	)
			|| (strpos($url, 'user_diner'	)	!== false	)	)
		{
	    	return $authorization_flags->diner_administration;
		}
		
		//URL de buscar y editar comedor
		if (   ($url == 	 'diner/search' 	)
			|| ($url == 	 'diner/edit'   	)	)
		{
			return $authorization_flags->diner_edit;
		}
		
		// URL de input type, food type
		if (   (strpos($url, 'admin_application'	)	!== false	)
			|| (strpos($url, 'input_type'			)	!== false	)
			|| (strpos($url, 'food_type'			) 	!== false	)	)
		{
			return $authorization_flags->suc_maintenance;
		}
		
		// URL de aprobación de comedor/usuario
		if (   (strpos($url, 'admin_application'	)	!== false	)	)
		{
			return $authorization_flags->diner_approval;
		}
		
		// URL de aprobación de donación
		if (   (strpos($url, 'donation'	)	!== false	)	)
		{
			return $authorization_flags->donation_approval;
		}
		
		// URL del formulario de alta de comedor
		if (   (strpos($url, 'diner_application'	)	!== false	)	)
		{
			return $authorization_flags->diner_application_form;
		}
		
		// URL del HOME
		if (   (strpos($url, 'home'	)	!== false	)	)
		{
			return $authorization_flags->home;
		}
	}
}