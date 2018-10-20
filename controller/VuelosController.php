<?php


class VuelosController {

    public function __construct() {
        $this->reservarVuelo();
    }

        public function reservarVuelo() {
            if(isset($_POST['reservar'])) {
                echo "eeeeee";
            }
        }

    public function buscar() {
        global $core;
        $ajax=false;
        if(isset($_POST['buscarvuelos'])) {
            $origen = $_POST['aeropuerto_origen'];
            $destino = $_POST['aeropuerto_destino'];
            $fecha_salida = $_POST['fechasalida'];
            if(isset($_POST['fecharegreso'])) {
                $fecha_regreso = $_POST['fecharegreso'];
            }

            $adultos = $_POST['adultos'];

            if(!empty($origen) || !empty($destino) || !empty($fecha_salida) || !empty($adultos)) {
                (array) $_SESSION['vuelo'] = $_POST;
                $core->redirect('reserva');
            } else {
                $ajax['mensaje'] = 'Campos vacios';

            }

            echo json_encode($ajax, true);
        }
    }

        public function loadSavedResearch() {
            global $db;
            $output ="<h1>Reservar vuelo</h1>";
            if(isset($_SESSION['vuelo'])) {
                $output .= '<h2>'. $_SESSION['vuelo']['aeropuerto_origen'] . ' - '. $_SESSION['vuelo']['aeropuerto_destino'].'</h2>';

                $id = $db->q('SELECT codigo FROM aeropuertos WHERE nombre=:nombre LIMIT 1',
                array('nombre' => $_SESSION['vuelo']['aeropuerto_destino']))[0]->codigo;
                // select idruta
                $idruta = $db->q('SELECT id FROM rutas WHERE cod_aerop_origen=:codigo', array('codigo' => $id))[0]->id;
                $vuelos = $db->q('SELECT * FROM vuelos WHERE idruta=:origen',
                array('origen' => $idruta));

                $output .= "<p>Fechas:</p>";

                foreach($vuelos as $result) {
                    $output .= '<form action="" method="post">';
                    $output .='<input type="hidden" value="'.$id.'" name="hidden_idvuelo">';
                    $output .= "<p>Fecha salida: $result->fecha_salida - Quedan: $result->asientos asientos</p>";
                    $output .= "<p>Fecha llegada: $result->fecha_llegada </p>";
                    $output .= "<p>Precio <span class='badge badge-success price'>$result->precio_inicial €</span> </p>";
                    if($result->asientos < 10 && $result->asientos > 0) {
                        $output .='<div class="errors"><span class="error">¡Quedan menos de 10 asientos!</span></div>';
                    }
                    if($result->asientos==0) {
                        $output .= '<button disabled name="reservar" class="btn btn-danger">No puedes reservar este vuelo</button>';
                        $output .='<div class="errors"><span class=" error">No quedan asientos para este vuelo</span></div>';

                    } else {
                        $output .= '<button name="reservar" class="btn btn-primary">Reservar</button>';
                    }
                    $output .='</form>';
                }

            } else {
                $output .= '<p>No tienes ninguna reserva hecha. </p> <a class="btn btn-primary" href="'.WWW.'">Buscar vuelos</a>';
            }
            echo $output;
        }
}