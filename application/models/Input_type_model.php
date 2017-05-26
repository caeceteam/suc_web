<?php

use GuzzleHttp\Client;

class Input_type_model extends CI_Model {
	/**
	 * Variables para el rest client
	 * @var string
	 */
	private $base_uri 	= '';
	
	/**
	 * Variables para los atributos del modelo
	 * @var string
	 */
	public $id;
	public $code;
	public $name;
	public $description;
	
	public function __construct()
	{
		$this->load->database();
	}
	
	/**
	 * Consulta de tipo de insumo
	 * 
	 * Consulta personas por cuil o devuelve toda la tabla
	 * @param 		string 		$cuil
	 * @return 		mixed 		object|array Devuelve un objeto Persona si se consulta por un CUIL, sino devuelve un array
	 */
	public function consulta($cuil=NULL)
	{
		$query = $this->db->query($this->sp_consulta, array('cuil' => $cuil));
		if($cuil)
		{
			if ($query->num_rows() > 0) {
				$row=$query->row_array();
				$this->cuil=$row["cuil"];
				$this->nombre=$row["nombre"];
				$this->apellido=$row["apellido"];
				$this->mail=$row["mail"];
			}
			return $this;
		}
		else
		{
			return $query->result_array();
		}
	}
	
	/**
	 * Alta de tipo de insumo
	 * @param		object	$persona
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function alta($persona)
	{	
		if($this->db->query($this->sp_alta, 
				array(
						'cuil' 		=> $persona->cuil, 
						'Nombre' 	=> $persona->nombre, 
						'Apellido' 	=> $persona->apellido, 
						'Mail' 		=> $persona->mail))
				)
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
	
	/**
	 * Edicion de tipo de insumo
	 * @param		object	$persona
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function editar($persona)
	{
		if($this->db->query($this->sp_editar, 
				array(
						'cuil' 		=> $persona->cuil, 
						'Nombre' 	=> $persona->nombre, 
						'Apellido' 	=> $persona->apellido, 
						'Mail' 		=> $persona->mail))
				)
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
	
	/**
	 * Baja de tipo de insumo
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function baja($cuil = FALSE)
	{
		if($query = $this->db->query($this->sp_baja, array('cuil' => $cuil)))
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
}