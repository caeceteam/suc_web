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
     * Busco usuarios
     *
     * Consulta tipos de insumo por id o devuelve toda la tabla
     * 
     * @param string $id            
     * @return array Si la consulta fue exitosa devuelve un array, sino devuelve
     *         NULL
     */
    public function search ($idUser = NULL)
    {
        $response = $this->client->request('GET', 
                $idUser != NULL ? 'api/users/' . $idUser : 'api/users/');
        if ($response->getStatusCode() == HTTP_OK) {
            $body = $response->getBody();
            return json_decode($body, TRUE);
        } else
            return NULL;
    }

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
        } catch (ServerException $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * Edici�n de input type
     * 
     * @param object $user_diner            
     * @return array Si la edici�n fue exitosa, devuelve un array con el input
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
        //LLamo al servicio concatenadno el ID que paso por paremetro al momento de instanciar
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
    public function get_inputtypes_by_page ($page)
    {
        $url = 'api/users?page=' . $page;
        return $this->search($url);
    }

    /**
     * Funci�n que mapea el mensaje de error desde la API usado en los editores
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