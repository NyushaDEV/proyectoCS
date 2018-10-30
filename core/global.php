<?php
session_start();
define('SITENAME', 'Córdoba AirWays');
define('root_path', dirname(__DIR__), true);
define('DS', DIRECTORY_SEPARATOR);
define('CWD', str_replace('core' . DS, '',dirname(__FILE__) . DS));
define('WWW',  'http://' . $_SERVER['SERVER_NAME']);

/**
 * 
 * Autoloader que sirve para autocargar clases sin tener que definir la ruta de cada archivo de las clase.
 * El nombre de la clase tiene que ser igual al del archivo
 * 
*/ 
function __autoload( $class_name ) {
	
	$file_name =   CWD . '//controller/' .  $class_name . '.php';
	if( file_exists( $file_name ) ) {
		require_once $file_name;
	} 
}
/**
 * Se instancia las clases de los modelos
 */
require_once CWD . 'model/User.php';
require_once CWD . 'model/Flight.php';

$db = new DataBaseController();
$core = new CoreController();

$usermodel = new User();
$fmodel = new Flight();

$vuelos = new VuelosController($fmodel);
$users = new UserController($usermodel);
// no cargamos las vistas cuando se trata de archivos que están en el directorio "ajax"
if(dirname($_SERVER['REQUEST_URI']) !== '/ajax') {
    $template = new TemplateController($core, $db, $users);
}
