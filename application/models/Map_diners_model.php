<?php
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Map_diners_model extends CI_Model
{

    /**
     * Variables para el rest client
     *
     * @var string
     */
    private $base_uri = 'http://localhost:3000';

    private $client;

    private $timeout = 5.0;

    /**
     * Comunico con la API
     *
     * @var string
     */
    public function __construct ()
    {
        parent::__construct();
        $this->client = new Client(
                [
                        'headers'   => ['x-access-token' => $this->session->token, 'x-geo-enabled' => 'true'],
                        'base_uri'  => $this->base_uri,
                        'timeout'   => $this->timeout
                ]);
    }

    /**
     * Realiza la consulta segun URL enviado por URL
     *
     * Consulta los usuarios
     * @param 		string 		$url
     * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
     *
     */
    private function search($url)
    {    
    	$response = $this->client->request('GET', $url);
	    if($response->getStatusCode()==HTTP_OK)
	    {
	        $body = $response->getBody();
	        return json_decode($body,TRUE);
	    }
	    else
	        return NULL;
    }
    
    /**
     * Consulta por los mapas cercanos
     *
     * @param string $page            
     */
    public function get_near_diners ($latitude, $longitude)
    {
        $url = 'api/diners?latitude=' .$latitude. '&longitude=' . $longitude;
        return $this->search($url);
    }

    /**
     * Busco los datos de un comedor por su ID
     *
     * Consulta los usuarios
     * @param 		string 		$url
     * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
     *
     */
    public function search_diner_by_id($id)
    {    
        $url = 'api/diners/' . $id;
		return $this->search($url);
    }

    
    /**
     * Función que mapea el mensaje de error desde la API usado en los editores
     * @param 	exception $exceptionData
     */
    private function errorMessage($exceptionData)
    {
        $errorResponse = json_decode($exceptionData->getResponse()->getBody(), TRUE);
        $errorResponse['errors'] = TRUE;
        if($exceptionData->getCode() == 500)
        {
            return $errorResponse;
        }
        return NULL;
    }
    
        
}