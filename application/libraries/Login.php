<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase para el manejo de la seguridad de la aplicación
 *
 * @author		Marco Cupo
 */
class Login {

	/**
	 * CI Singleton
	 *
	 * @var object
	 */
	protected $CI;

	/**
	 * Constructor de clase
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		log_message('info', 'Security Class Initialized');
	}
	
	/**
	 * Funcion que verifica si el usuario esta autenticado y lo redirige al login en caso contrario
	 * @param 		integer 	$id id del diner para cuando se trata de una edición
	 * @return		bool		Devuelve TRUE si esta logeado
	 */
	public function is_logged_in()
	{
		$is_logged_in = $this->CI->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
			redirect('login');
	}
	
	/**
	 * Funcion que traduce el role ID a descripción
	 * @param 		role 		$role id del role
	 * @return		string		Devuelve la descripción del rol
	 */
	public function get_role_description($role)
	{
		switch ($role) {
		    case 0: return 'Administrador de Sistema';
		    case 1: return 'Administrador de Comedor';
		    case 2: return 'Empleado';
		    case 3: return 'Colaborador';
			case 4: return 'Invitado';
		}
	}
}
