<?php

/**
 * 
 * Autoloader que sirve para autocargar clases sin tener que definir la ruta de cada archivo de las clase.
 * El nombre de la clase tiene que ser igual al del archivo
 * 
*/ 
function __autoload( $class_name ) {
	
	$file_name = 'controller/' .  $class_name . '.php';
	if( file_exists( $file_name ) ) {
		require $file_name;
	} 
}
/**
 * Se instancia las clases
 */
$core = new CoreController();
$template = new TemplateController($core);

$template->load('tesst');
