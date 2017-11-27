<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/******************************************************************************************************
 * CLASE MAP_DINERS
 *******************************************************************************************************
 * HISTORIA: HU0
 * TITULO: Usuario comedor
 ********************************************************************************************************
 */
class Map_diners extends CI_Controller
{
    /**
     * Constructor de clase
     * Se encarga de hacer el load de los modulos necesarios
     *
     * @return void
     */
    public function __construct ()
    {   //Clase Padre
        parent::__construct();
        
        //Carga las librerias a usar
        $this->load->library(
                array(
                        'form_validation',
                        'session',
                        'upload',
                        'googlemaps',
                        'login'
                ));
        
        $this->load->helper(
                array(
                        'url',
                        'form'
                ));
        
        //Cargo el modelo
        $this->load->model('Map_diners_model');
        $this->load->model('Diner_model');
        
        //Objeto persistente usado para la carga de datos
        $this->form_data = new stdClass();
        $this->map_data['dinLog'] = array(); // Datos del comedor logueado 
        $this->map_data['dinSer'] = array(); // Datos de los comedores cercanos recuperados
        
        //Variable para indicar si hay que resetear los campos del formulario
        $this->variables['reset']           =  FALSE;
        $this->variables['controller-name'] = 'map_diners';
        $this->_initialize_fields();
        
    }
    
    /**
     * Funcion que se carga por default al invocar al controlador sin
     * especificar la URL completa
     *
     * @return void
     */
    public function index ()
    {
        $this->variables['data-request-url'] = site_url( 'map_diners/set_map');
        $this->set_map();
        $this->load->view('map_diners/search', $this->variables);
    }
    
    /**
     * Funcion que inicializa las propias del Comedor
     *
     * @return void
     */
    private function _initialize_fields ()
    {
        $idDiner = $this->session->userdata['idDiner'];
        $this->form_data->idDiner       = $idDiner;
        $this->form_data->street        = '';
        $this->form_data->streetNumber  = '';
        $this->form_data->mail          = '';
        $this->form_data->phone         = '';
        $this->form_data->description   = '';
        $this->form_data->name          = '';
        $this->form_data->link          = '';
        $this->form_data->latitude      = '';
        $this->form_data->longitude     = '';
        
    }
    
    
    /**
     * Obtiene los datos del comedor consultado
     *
     * @param integer $id
     *            id del input type para cuando se trata de una edición
     * @return object $user_diner
     */
    private function set_map ($id = NULL)
    {   
        $diner_data				  = $this->Map_diners_model->search_diner_by_id($this->session->idDiner);
        $this->map_data['dinLog'] = $this->get_diner_log($diner_data);
        $this->map_data['dinSer'] = $this->get_diner_near($diner_data);
        $this->set_map_diners($this->map_data['dinLog'],$this->map_data['dinSer'] );
    }
    
    /**
     * Obtengo todos los datos del comedor logueado
     * @param  array con datos de logue, usuario y comedores 
     * @return object Array datos de comedor
     */
    private function get_diner_log ($diners_data)
    {                        
       $this->form_data->street        = $diners_data['street'];
       $this->form_data->streetNumber  = $diners_data['streetNumber'];
       $this->form_data->mail          = $diners_data['mail'];
       $this->form_data->phone         = $diners_data['phone'];
       $this->form_data->description   = $diners_data['description'];
       $this->form_data->name          = $diners_data['name'];
       $this->form_data->link          = $diners_data['link'];
       $this->form_data->latitude      = $diners_data['latitude'];
       $this->form_data->longitude     = $diners_data['longitude'];
       
       return $diners_data;
    }
    
    /**
     * Obtengo todos los comedores cercanos (No funciona en esta version de la API Modifcar)
     * @param  latitude y longitude
     * @return object Array datos de comedor distintos al de logueo 
     */
    private function get_diner_near ($diner_data)
    {   
    	$near_diners = array();
    	
    	foreach ($this->Map_diners_model->get_near_diners($diner_data['latitude'], $diner_data['longitude'])['diners'] as $key => $diner) {
    		if ($diner['idDiner'] != $this->session->idDiner) {
    			array_push($near_diners, $diner);
    		}
    	}
    	
    	return $near_diners;
    }
    
    /**
     * Obtiene los datos de comedor legueado
     * @param integer $id
     *            id del input type para cuando se trata de una edición
     * @return object $user_diner
     */
    private function set_map_diners( $diner_log, $diner_ser )
    {  
        //Configuracion del Mapa.
        $longitud = $diner_log['longitude']; 
        $latitude = $diner_log['latitude'];
        $config['center']   = $latitude . ','.  $longitud ;
        $config['zoom']     = '16';
        $config['apiKey']   = 'AIzaSyAQI7u6RI5Mtxh6FFqgPY9eMccFYmxLVzU';
        $this->googlemaps->initialize($config);
        
        //Marcador del comedor en el que estoy logueado. 
        $marker = array();
        $marker['position']           = $latitude . ','.  $longitud ;
        $marker['infowindow_content'] =  $this->form_data->name . ' - ' . $this->form_data->mail;
        $marker['icon']               = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
        $this->googlemaps->add_marker($marker);
        
        //Cargo los distintos comedores
		if($diner_ser)
		{
			foreach ( $diner_ser as $diner)
			{

				//Configuracion del Mapa.
				$longitud = $diner['longitude'];
				$latitude = $diner['latitude'];

				//Marcador del comedor en el que estoy logueado.
				$marker = array();
				$marker['position']           = $latitude . ','.  $longitud ;
				$marker['infowindow_content'] =  $diner['name'] . ' - ' . $diner['mail'];
				$this->googlemaps->add_marker($marker);
			}
		}
         
       
        //Cargar mapa en las variables de salida [map]
        $this->variables['map'] = $this->googlemaps->create_map();
    }
 
 }
