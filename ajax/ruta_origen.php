<?php
require_once '../core/global.php';

$rutas[] = $db->q('select id, nombre FROM aeropuertos');

echo json_encode($rutas, true);