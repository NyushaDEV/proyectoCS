<?php
define('SITENAME', 'Córdoba AirWays');
define('root_path', dirname(__DIR__), true);
define('DS', DIRECTORY_SEPARATOR);
define('CWD', str_replace('core' . DS, '',dirname(__FILE__) . DS));
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
 * Se instancia las clases
 */
$db = new DataBaseController();
$core = new CoreController();