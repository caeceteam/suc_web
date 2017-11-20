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
        $user_and_diner   = $this->Map_diners_model->get_diner($this->form_data->idDiner);
        $this->map_data['dinLog'] = $this->get_diner_log($user_and_diner);
        $this->map_data['dinSer'] = $this->get_diner_ser($user_and_diner);
        $this->set_map_diners($this->map_data['dinLog'],$this->map_data['dinSer'] );
    }
    
    /**
     * Obtengo todos los datos del comedor logueado
     * @param  array con datos de logue, usuario y comedores 
     * @return object Array datos de comedor
     */
    private function get_diner_log ($diners_data)
    {                        
        foreach ($diners_data['diners'] as $diner)
        {   
            if($diner['idDiner'] == $this->form_data->idDiner)
            {
                $data = array(
                        'street'        => $diner['street'],
                        'streetNumber'  => $diner['streetNumber'],
                        'mail'          => $diner['mail'],
                        'phone'         => $diner['phone'],
                        'description'   => $diner['description'],
                        'name'          => $diner['name'],
                        'link'          => $diner['link'],
                        'latitude'      => $diner['latitude'],
                        'longitude'     => $diner['longitude']
                );
            }
       }
       
       $this->form_data->street        = $data['street'];
       $this->form_data->streetNumber  = $data['streetNumber'];
       $this->form_data->mail          = $data['mail'];
       $this->form_data->phone         = $data['phone'];
       $this->form_data->description   = $data['description'];
       $this->form_data->name          = $data['name'];
       $this->form_data->link          = $data['link'];
       $this->form_data->latitude      = $data['latitude'];
       $this->form_data->longitude     = $data['longitude'];
       
       return $data;
    }
    
    /**
     * Obtengo todos los comedores cercanos (No funciona en esta vercion de la API Modifcar)
     * @param  array con datos de logue, usuario y comedores
     * @return object Array datos de comedor distintos al de logueo 
     */
    private function get_diner_ser ($diners_data)
    {   $data = array();
      //Comedores en sistema excluyendo el comedor logueado
       foreach ($diners_data['diners'] as $diner)
        {
            if($diner['idDiner'] != $this->form_data->idDiner)
            {       
                array_push($data, $diner);
            }
        }
       
        //Si hay comedores devuelvo el listado en formato Array
        if ($data != null){
            return $data;
        }
       
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
