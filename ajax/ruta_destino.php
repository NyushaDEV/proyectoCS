<?php
require_once '../core/global.php';

$origen = isset($_REQUEST['origen']) ? $_REQUEST['origen'] : '';

$id = $db->q('SELECT cod_aerop_origen,cod_aerop_destino FROM rutas WHERE cod_aerop_destino= 
(SELECT codigo FROM aeropuertos WHERE nombre=:nombre)', array(
    'nombre'    =>  $origen
));


foreach($id as $k => $v) {
    $destino[] = $db->q('SELECT nombre FROM aeropuertos WHERE codigo=:codigo', 
    array('codigo' => $v->cod_aerop_origen));
}
echo json_encode($destino, true);
