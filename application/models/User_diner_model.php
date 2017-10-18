<?php
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class User_diner_model extends CI_Model
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
     * Variables para los atributos del modelo
     *
     * @var string
     */
    public $idUser;

    public $name;

    public $surname;

    public $alias;

    public $pass;
    // public $chekPass;
    public $mail;

    public $idDiner;

    public $phone;
    // public $state;
    public $role;

    public $docNumber;

    public $bornDate;

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
                        'base_uri' => $this->base_uri,
                        'timeout' => $this->timeout
                ]);
    }

    /**
     * ********************************************************************************************
     * BUSQUEDAS
     ********************************************************************************************* */
      /**
     * Busqueda primera pagina, la uso para ver primera pagina segun la cantidad de usuarios 
     * que quiera visualizar
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
     * Busco los usuarios por ID, es usado para seleccionar un unico Usuarios (ABM)
     * @param 	int 	$id
     */
    public function search_by_id($id)
    {
        $url = 'api/users/' . $id;
        return $this->search($url);
    }
    
    /**
     * Cusnulato los usuarios segun criterio de paginación
     * @param 	string 	$page
     */
    public function get_user_diner_by_page($page)
    {
        $url = 'api/users?page=' . $page;
        return $this->search($url);
    }
    
      
    /**
     * ********************************************************************************************
     * ALTA
     ********************************************************************************************* */
        
    /**
     * Alta de input type
     *
     * @param object $user_diner            
     * @return array Si el alta fue exitosa, devuelve un array con el input
     *         type, sino devuelve NULL
     */
    public function add ($user_diner)
    {
        try {
            $response = $this->client->request('POST', 'api/users', 
                    [
                            'json' => $user_diner
                    ]);
            if ($response->getStatusCode() == HTTP_CREATED) {
                $body = $response->getBody();
                return json_decode($body, TRUE);
            } else
                return NULL;
        } catch (Exception $e) {
            return $this->errorMessage($e);
        }
        catch (ClientException $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * Edición de input type
     *
     * @param object $user_diner            
     * @return array Si la edición fue exitosa, devuelve un array con el input
     *         type, sino devuelve NULL
     */
    public function edit ($user_diner)
    {
        $response = $this->client->request('PUT', 
                'api/users/' . $user_diner->idUser, 
                [
                        'json' => $user_diner
                ]);
        if ($response->getStatusCode() == HTTP_ACCEPTED) {
            $body = $response->getBody();
            return json_decode($body, TRUE);
        } else
            return NULL;
    }

    /**
     * Delete de input type
     *
     * @param string $id            
     * @return bool Si la baja fue exitosa, devuelve un array con el input type,
     *         sino devuelve NULL
     */
    public function delete ($id)
    {
        // LLamo al servicio concatenadno el ID que paso por paremetro al
        // momento de instanciar
        $response = $this->client->request('DELETE', 'api/users/' . $id);
        if ($response->getStatusCode() == HTTP_OK) {
            return TRUE;
        } else
            return FALSE;
    }

    /**
     * Consulta la cantidad de paginas que devuelve la consulta
     * 
     * @param string $page            
     */
    public function get_userdiner_by_page ($page)
    {
        $url = 'api/users?page=' . $page;
        return $this->search($url);
    }

    /**
     * Función que mapea el mensaje de error desde la API usado en los editores
     * 
     * @param exception $exceptionData            
     */
    private function errorMessage ($exceptionData)
    {
        $errorResponse = json_decode($exceptionData->getResponse()->getBody(), 
                TRUE);
        $errorResponse['errors'] = TRUE;
        foreach ($errorResponse['fields'] as $errorKey => $errorValue) {
            $errorResponse['fields'][$errorKey] = $errorValue .
                     " ya esta siendo utilizado";
        }
        if ($exceptionData->getCode() == 500) {
            return $errorResponse;
        }
        return NULL;
    }
}
;
