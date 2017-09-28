<?php defined('BASEPATH') OR exit('No direct script access allowed.');

$config['useragent']        = 'CodeIgniter';              	
$config['protocol']         = 'smtp';                   // 'mail', 'sendmail', or 'smtp'
$config['mailpath']         = '/usr/sbin/sendmail';
$config['smtp_host']        = 'smtp.gmail.com';
$config['smtp_user']        = 'sistemaunicodecomedores@gmail.com';
$config['smtp_pass']        = 'caeceteam';
$config['smtp_port']        = 465;
$config['smtp_timeout']     = 30;                       // (in seconds)
$config['smtp_keepalive']   = FALSE;
$config['smtp_crypto']      = 'ssl';                    // '' or 'tls' or 'ssl'
$config['wordwrap']         = TRUE;
$config['wrapchars']        = 76;
$config['mailtype']         = 'html';                   // 'text' or 'html'
//$config['charset']        = ISO-8859-1;       		//Ya esta definido en el archivo config. 'UTF-8', 'ISO-8859-15', ...; NULL (preferable) means config_item('charset'), i.e. the character set of the site.
$config['validate']         = TRUE;
$config['priority']         = 3;                        // 1, 2, 3, 4, 5;
$config['crlf']             = "\n";                     // "\r\n" or "\n" or "\r"
$config['newline']          = "\n";                     // "\r\n" or "\n" or "\r"
$config['bcc_batch_mode']   = FALSE;
$config['bcc_batch_size']   = 200;