<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
 |--------------------------------------------------------------------------
 | Codigos de status HTTP
 |--------------------------------------------------------------------------
 |
 | Usados para validar las llamadas a la API.
 |
 */
defined('HTTP_OK')      		OR define('HTTP_OK', 200);
defined('HTTP_CREATED')      	OR define('HTTP_CREATED', 201);
defined('HTTP_ACCEPTED')      	OR define('HTTP_ACCEPTED', 202);
defined('HTTP_NO_CONTENT')      OR define('HTTP_NO_CONTENT', 204);
defined('HTTP_BAD_REQUEST')     OR define('HTTP_BAD_REQUEST', 400);
defined('HTTP_UNAUTHORIZED')    OR define('HTTP_UNAUTHORIZED', 401);
defined('HTTP_FORBIDDEN')     	OR define('HTTP_FORBIDDEN', 403);
defined('HTTP_NOT_FOUND')     	OR define('HTTP_NOT_FOUND', 404);
defined('HTTP_INTERNAL_SERVER') OR define('HTTP_INTERNAL_SERVER', 500);

/*
 |--------------------------------------------------------------------------
 | Codigos de estados de comedor
 |--------------------------------------------------------------------------
 |
 | Usados para manejar los estados de las solicitudes de comedores
 |
 */
defined('DINER_PENDING')      	OR define('DINER_PENDING', 0);
defined('DINER_APPROVED')      	OR define('DINER_APPROVED', 1);
defined('DINER_REJECTED')      	OR define('DINER_REJECTED', 2);
/*
 |--------------------------------------------------------------------------
 | Codigos de estados de donación
 |--------------------------------------------------------------------------
 |
 | Usados para manejar los estados de las solicitudes de donaciones
 |
 */
defined('DONATION_PENDING')      	OR define('DONATION_PENDING', 0);
defined('DONATION_APPROVED')      	OR define('DONATION_APPROVED', 1);
defined('DONATION_REJECTED')      	OR define('DONATION_REJECTED', 2);
/*
 |--------------------------------------------------------------------------
 | Codigos de estados de usuario
 |--------------------------------------------------------------------------
 |
 | Usados para manejar los estados de la adminsitraciï¿½n de usuarios
 |
 */
defined('USER_INACTIVE')     	OR define('USER_INACTIVE', 0);
defined('USER_ACTIVE')      	OR define('USER_ACTIVE', 1);

/*
 |--------------------------------------------------------------------------
 | Codigos de roles de usuario
 |--------------------------------------------------------------------------
 |
 | Usados para manejar los roles de usuarios
 |
 */
defined('SYS_ADMIN')     		OR define('SYS_ADMIN', 0);
defined('DINER_ADMIN')      	OR define('DINER_ADMIN', 1);
defined('EMPLOYEE')      		OR define('EMPLOYEE', 2);
defined('COLABORATOR')      	OR define('COLABORATOR', 3);
defined('GUEST')      			OR define('GUEST', 4);

/*
 |--------------------------------------------------------------------------
 | Codigos de Mail Type
 |--------------------------------------------------------------------------
 |
 | Usados para manejar los tipos de mail de la api /emails/
 |
 */
defined('REGISTRATION_MAIL')     	 OR define('REGISTRATION_MAIL', 0);
defined('APPROVAL_MAIL')      		 OR define('APPROVAL_MAIL', 1);
defined('REJECTION_MAIL')      		 OR define('REJECTION_MAIL', 2);
//defined('FORGOT_YOUR_PASSWORD')		 OR define('FORGOT_YOUR_PASSWORD', 3);
defined('NEW_DINER_USER')			 OR define('NEW_DINER_USER', 3);
defined('CHANGE_PERSON_INFORMATION') OR define('CHANGE_PERSON_INFORMATION', 4);
defined('CHANGE_PERSON_PASS') 		 OR define('CHANGE_PERSON_PASS', 5);