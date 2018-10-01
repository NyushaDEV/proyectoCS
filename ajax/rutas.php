<?php
require_once '../core/global.php';

$rutas[] = $db->q('select id, origen, destino FROM rutas WHERE deleted=:deleted', array('deleted' => 0));

echo json_encode($rutas, true);