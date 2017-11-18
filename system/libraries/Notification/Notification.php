<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * ****************************************************************************************************
 * CLASE NOTIFICATION
 * *****************************************************************************************************
 * HISTORIA: HU021 - 22 - 23 -24 - 25
 * TITULO: Notificacion de usuario Usuario comedor
 * ****************************************************************************************************
 */
class Notification extends CI_Email
{
    
    // Constantes
    const url_mail      = 'http://localhost/suc_web/login/logout';
    const url_mail_mod  = 'email/notification_changes_user_data.php';
    const url_mail_new  = 'email/notification_new_user.php';
    const sender        = 'suc@no-reply.com';
    const send_des      = 'Sistema ušnico de Comedores';
    const tit_mail_mod  = 'Modificación de datos usuario';
    
    // Variables
    private $variables;
    private $config;
    
    // Salida
    
    /**
     * Constructor - Sets Email Preferences
     *
     * The constructor can be passed an array of config values
     *
     * @param array $config
     *            = array()
     * @return void
     */
    public function __construct ()
    {
        //$this->load->library('email');
        parent::__construct();
    }

    /**
     * _Send_mail - Envio de mail para notificaciones
     *
     * Da formato al envio de mail para notificaciones Usuario
     *
     * @param array $user_mail
     *            = array()
     * @param $type (Tipo
     *            de mail HTML o TEXT)
     * @param $action Alta
     *            baja o modificacion de datos de usuario
     * @return BOOL
     */
    public function _send_mail (
            array $mail_user = array ('mail', 'name', 'alias', 'pass'), $mail_type = 'html', $action, $mail_body)
    {
        // Inicializar Objeto
        $this->clear();
        $this->set_mailtype($mail_type);
        
        // Valido el Mail, si no valida devuelvo error
        if (! $this->valid_email($user_mail['mail'])) {
            throw new Exception("Verificar el Mail: " . $mail_user['mail']);
        }
        
        switch ($action) {
            case 'PUT':
                $this->set_mail_modif($mail_user);
                break;
            case 'POST':
                $this->set_mail_new($mail_user);
                break;
            case 'DELETE':
                $this - set_ > mail_del($mail_user);
                break;
            default:
                throw new Exception("Acción erronea");
        }
        
        //Envio de mail
        $flag_mail = $this->send();
        
        // Verificación de envio
        if ($flag_mail == TRUE) {
            return $flag_mail;
        } elseif ($flag_mail == FALSE) {
            throw new Exception("Verificar el Mail: " . $mail_user['mail']);
        } else {
            throw new Exception(
                    "Ocurrio un error, verifique la resepcion del mismo.");
        }
    }

    /**
     * set_mail_html_modif - Modificación datos personales
     *
     * Mail por cambio en los datos de usuario
     *
     * @param array $user_mail = array()
     */
    private function set_mail_html_modif (
            array $mail_user = array ('mail', 'name', 'alias', 'pass'), $mail_body)
    {
        $this->subject('Modificación datos personales');
        $body = $mail_body->view(url_mail_mod, $mail_user, TRUE);
        $this->message($body); // adjunto el php al cuerpo del mail
        $this->set_newline("\r\n"); // Sin esta liñea falla el envio
    }
    
    /**
     * set_mail_html_new - Alta de usuario en sistema
     *
     * Mail que informa el alta en el sistema
     *
     * @param array $user_mail = array()
     */
    private function set_mail_html_new (
            array $mail_user = array ('mail', 'name', 'alias', 'pass'), $mail_body)
    {
        $this->subject('Alta de usuario - Bienvenido');
        $body = $mail_body->view(url_mail_new, $mail_user, TRUE);
        $this->message($body); // adjunto el php al cuerpo del mail
        $this->set_newline("\r\n"); // Sin esta liñea falla el envio
    }
    
    /**
     * set_mail_html_del - Baja de usuario en sistema
     *
     * Mail que informa la baja en el sistema
     *
     * @param array $user_mail = array()
     */
    private function set_mail_html_del (
            array $mail_user = array ('mail', 'name', 'alias', 'pass'), $mail_body)
    {
        $this->subject('Baja de sistema');
        $body = $mail_body->view(url_mail_del, $mail_user, TRUE);
        $this->message($body); // adjunto el php al cuerpo del mail
        $this->set_newline("\r\n"); // Sin esta liñea falla el envio
    }
}