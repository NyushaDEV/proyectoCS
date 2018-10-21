<?php


class VuelosController {
    private $db;
    public function __construct()
    {
        global $db;
        $this->db = $db;

    }

    public function mostrarVuelos() {

        global $db, $core;


            $id = $db->q('SELECT codigo FROM aeropuertos WHERE nombre=:nombre LIMIT 1',
                array('nombre' => $_SESSION['vuelo']['aeropuerto_destino']))[0]->codigo;
            // select idruta
            $idruta = $db->q('SELECT id FROM rutas WHERE cod_aerop_origen=:codigo', array('codigo' => $id))[0]->id;

            if(isset($_POST['buscar_fecha'])) {
                $fecha = str_replace('/', '-', $_POST['fecha']);
            } else {
                $fechasalida = $_SESSION['vuelo']['fechasalida'];
                $fecha_explode = explode('/', $fechasalida);
                $fecha = $fecha_explode[1] . '-' . $fecha_explode[0] . '-' . $fecha_explode[2];
            }

            $vuelos = $db->q('SELECT * FROM vuelos WHERE idruta=:origen', array(
                'origen' => $idruta
            ));

            $output = '<table class="table text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Hora de salida</th>
                  <th scope="col">Hora de llegada</th>
                  <th scope="col">Precio </th>
                  <th scope="col">Reservar</th>
                </tr>
              </thead><tbody>';
            foreach ($vuelos as $vuelo) {

                if( $core->formatDate($vuelo->fecha_salida, 'd-m-Y') == $fecha && $core->formatDate($vuelo->fecha_salida, 'd-m-Y') > $core->formatDate(time(), 'd-m-Y')) {

                    $fecha_dia = date('d', $vuelo->fecha_salida);
                    $fecha_mes = date('m', $vuelo->fecha_salida);
                    $fecha_year = date('Y', $vuelo->fecha_salida);

                    $reservar = $vuelo->asientos==0 ? '<a href="#" class="btn btn-secondary disabled">No hay plazas</a>': '<a href="'.WWW.'/reserva&do=reservar&vuelo='.$vuelo->idvuelo.'" class="btn btn-primary">Reservar</a>';
                    $textoreserva = $vuelo->asientos < 20 ? '<div><mark class="small">Quedan menos de 20 asientos para este vuelo!</mark></div>' : '';
                    $output .= '<tr>
                <td>' . $core->formatDate($vuelo->fecha_salida, 'H:i') . '</td>
                <td>' . $core->formatDate($vuelo->fecha_llegada, 'H:i') . '</td>
                      <td><span class="badge badge-success price">' . $vuelo->precio_inicial . ' €</span></td>
                      <td>'.$reservar . $textoreserva .'</td>
                    </tr>';

                }
            }
            echo $output;


    }

    public function buscar()
    {
        global $core;
        $ajax = false;
        if (isset($_POST['buscarvuelos'])) {

            var_dump($_POST);
            $origen = $_POST['aeropuerto_origen'];
            $destino = $_POST['aeropuerto_destino'];
            $fecha_salida = $_POST['fechasalida'];
            if (isset($_POST['fecharegreso'])) {
                $fecha_regreso = $_POST['fecharegreso'];
            }

            $adultos = $_POST['adultos'];

            if (!empty($origen) || !empty($destino) || !empty($fecha_salida) || !empty($adultos)) {
                (array)$_SESSION['vuelo'] = $_POST;
                $core->redirect('reserva');
            } else {
                $ajax['mensaje'] = 'Campos vacios';

            }

            echo json_encode($ajax, true);
        }
    }

    public function loadSavedResearch() {
        global $db, $core;
        $output = '';

        $this->mostrarVuelos();


        echo "<h1>Reservar vuelo</h1>";
        if (isset($_SESSION['vuelo'])) {
            echo '<h2>' . $_SESSION['vuelo']['aeropuerto_origen'] . ' - ' . $_SESSION['vuelo']['aeropuerto_destino'] . '</h2>';

            $id = $db->q('SELECT codigo FROM aeropuertos WHERE nombre=:nombre LIMIT 1',
                array('nombre' => $_SESSION['vuelo']['aeropuerto_destino']))[0]->codigo;
            // select idruta
            $idruta = $db->q('SELECT id FROM rutas WHERE cod_aerop_origen=:codigo', array('codigo' => $id))[0]->id;
            $busqueda_fecha = explode('/', $_SESSION['vuelo']['fechasalida']);
            $busqueda_fecha_mes = $busqueda_fecha[0];
            $busqueda_fecha_dia = $busqueda_fecha[1];
            $busqueda_fecha_year = $busqueda_fecha[2];

            $vuelos = $db->q('SELECT * FROM vuelos WHERE idruta=:origen', array(
                'origen' => $idruta
            ));
            echo '<div class="row">';


            $repeats_date = null;
            foreach ($vuelos as $result) {

                if ($repeats_date !== $core->formatDate($result->fecha_salida, 'd-m-Y') &&  $core->formatDate($result->fecha_salida, 'd-m-Y') >  $core->formatDate(time(), 'd-m-Y')) {
                    echo '<div class="col-md-3">
                        <form method="post" action="">
                        <input type="hidden" name="id_ruta" value="'.$idruta.'"/>
                        <input type="hidden" name="codigo_aeropuerto" value="'.$id.'"/>
                        <input type="hidden" name="fecha" value="'.$core->formatDate($result->fecha_salida, 'd-m-Y').'"/>
                        <button name="buscar_fecha" class="btn btn-secondary">' . $core->formatDate($result->fecha_salida, 'l d F') . '</button>
                        </form>
                        </div>';
                }
                $repeats_date = $core->formatDate($result->fecha_salida, 'd-m-Y');
            }//end foreach */
            echo '</div>'; // end .row

        }




        else {
            $output .= '<p>No tienes ninguna reserva hecha. </p> <a class="btn btn-primary" href="' . WWW . '">Buscar vuelos</a>';
        }

        echo $output;

        $this->reservar();

    }


    public function reservar() {
        if(isset($_GET['do'])) {
            $do = $_GET['do'];
            echo $do;
        }
    }

    public function _load_flights_helper()
    {
        $html = '<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Hora de salida</th>
      <th scope="col">Hora de llegada</th>
      <th scope="col">Reservar</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>';
        return $html;
    }
}