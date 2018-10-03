<?php
require_once '../core/global.php';

$origen = isset($_REQUEST['origen']) ? $_REQUEST['origen'] : '';

$id = $db->q('SELECT idaeropuerto_origen FROM rutas WHERE idaeropuerto_destino= 
(SELECT id FROM aeropuertos WHERE nombre=:nombre)', array(
    'nombre'    =>  $origen
));


foreach($id as $k => $v) {
    $destino[] = $db->q('SELECT nombre FROM aeropuertos WHERE id=:id', array('id' => $v->idaeropuerto_origen));
}
echo json_encode($destino, true);
