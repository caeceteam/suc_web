<?php

require_once("Role_interface.php");

class Diner_admin implements Role_interface
{

	/**
	 * CI Singleton
	 *
	 * @var object
	 */
	protected $CI;
	
	private $authorization_flags;
	
    public function __construct()
    {
    	$this->CI =& get_instance();    	
    	$this->authorization_flags = new stdClass();
        $this->authorization_flags->diner_approval = FALSE;
        $this->authorization_flags->donation_approval = TRUE;
        $this->authorization_flags->diner_administration = TRUE;
        $this->authorization_flags->diner_edit = TRUE;
        $this->authorization_flags->suc_maintenance = FALSE;
        $this->authorization_flags->diner_application_form = TRUE;
        $this->authorization_flags->home = TRUE;
    }
    public function get_authorization()
    {
        return $this->authorization_flags;
    }
    public function get_menu()
    {
    	return 'templates/menuDinerAdmin';
    }
}