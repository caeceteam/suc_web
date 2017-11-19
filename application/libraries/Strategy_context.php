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
	public function set_strategy($strategy)
	{
		$this->strategy = $strategy;
	}

	public function get_menu()
	{
		return $this->strategy->get_menu();
	}
	
	public function set_role($role){
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
}