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
                        'headers'   => ['x-access-token' => $this->session->token],
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
    {    $response = $this->client->request('GET', $url);
    if($response->getStatusCode()==HTTP_OK)
    {
        $body = $response->getBody();
        return json_decode($body,TRUE);
    }
    else
        return NULL;
    }
    
    /**
     * Consulta la cantidad de paginas que devuelve la consulta
     *
     * @param string $page            
     */
    public function get_diner ($page)
    {
        $url = 'api/diners?id=' . $page;
        return $this->search($url);
    }


    /**
     * Busco todos los comedores que se encuentran cargados en sistema
     * Busca todos los comedores en sistema
     * 
     * @return array Si la consulta fue exitosa devuelve un array, sino devuelve
     *         NULL
     *        
     */
    private function search_all()
    {
        $response = $this->client->request('GET', 'diners');
        if ($response->getStatusCode()==HTTP_OK){
            $body = $response->getBody();
            return json_decode($body, TRUE);
        } 
        else{ 
            return NULL;
        }
    }

    /**
     * Busco los datos de un comedor por su ID
     *
     * Consulta los usuarios
     * @param 		string 		$url
     * @return 		array 		Si la consulta fue exitosa devuelve un array, sino devuelve NULL
     *
     */
    private function search_by_id($id)
    {    
        $url = 'api/diners/?idDiner=' . $id;
        $response = $this->client->request('GET', $url);
        if($response->getStatusCode()==HTTP_OK)
        {
            $body = $response->getBody();
            return json_decode($body,TRUE);
        }
        else{
            return NULL;
        }
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