<?php


class VuelosController
{
    private $db;

    private $flightmodel;

    public function __construct($flightmodel)
    {
        $this->flightmodel = $flightmodel;
        global $db;
        $this->db = $db;

    }

    public function displayFlights()
    {

        global $db, $core;
        $id = $db->q('SELECT codigo FROM aeropuertos WHERE nombre=:nombre LIMIT 1',
            array('nombre' => $_SESSION['vuelo']['aeropuerto_destino']))[0]->codigo;
        // select idruta
        $sql = $db->q('SELECT id, cod_aerop_origen, cod_aerop_destino FROM rutas WHERE cod_aerop_origen=:codigo', array('codigo' => $id));

        $idruta = $sql[0]->id;
        $to = $sql[0]->cod_aerop_origen;
        $from = $sql[0]->cod_aerop_destino;
        if (isset($_POST['buscar_fecha'])) {
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

            if ($core->formatDate($vuelo->fecha_salida, 'd-m-Y') == $fecha && $core->formatDate($vuelo->fecha_salida, 'd-m-Y') > $core->formatDate(time(), 'd-m-Y')) {

                $fecha_dia = date('d', $vuelo->fecha_salida);
                $fecha_mes = date('m', $vuelo->fecha_salida);
                $fecha_year = date('Y', $vuelo->fecha_salida);

                $reservar = $vuelo->asientos == 0 ? '<button  class="btn btn-secondary disabled">No hay plazas</button>' : '<form action="' . WWW . '/booking&flight=' . $vuelo->idvuelo . '&from='.$from.'&to='.$to.'" method="post"><input type="hidden" name="id_vuelo" value="'.$vuelo->idvuelo.'"><button name="reservar_vuelo" class="btn btn-primary">Reservar</button></form>';
                $textoreserva = $vuelo->asientos > 0 && $vuelo->asientos < 20 ? '<div><mark class="small">Quedan menos de 20 asientos para este vuelo!</mark></div>' : '';
                $output .= '<tr>
                <td>' . $core->formatDate($vuelo->fecha_salida, 'H:i') . '</td>
                <td>' . $core->formatDate($vuelo->fecha_llegada, 'H:i') . '</td>
                      <td><span class="badge badge-success price">' . $vuelo->precio_inicial . ' €</span></td>
                      <td>' . $reservar . $textoreserva . '</td>
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

    public function loadSavedResearch()
    {
        global $db, $core;
        $output = '';

        $this->displayFlights();

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

                if ($repeats_date !== $core->formatDate($result->fecha_salida, 'd-m-Y') && $core->formatDate($result->fecha_salida, 'd-m-Y') > $core->formatDate(time(), 'd-m-Y')) {
                    echo '<div class="col-md-3">
                        <form method="post" action="">
                        <input type="hidden" name="id_ruta" value="' . $idruta . '"/>
                        <input type="hidden" name="codigo_aeropuerto" value="' . $id . '"/>
                        <input type="hidden" name="fecha" value="' . $core->formatDate($result->fecha_salida, 'd-m-Y') . '"/>
                        <button name="buscar_fecha" class="btn btn-secondary">' . $core->formatDate($result->fecha_salida, 'l d F') . '</button>
                        </form>
                        </div>';
                }
                $repeats_date = $core->formatDate($result->fecha_salida, 'd-m-Y');
            }//end foreach */
            echo '</div>'; // end .row

        } else {
            $output .= '<p>No tienes ninguna reserva hecha. </p> <a class="btn btn-primary" href="' . WWW . '">Buscar vuelos</a>';
        }

        echo $output;
    }


    public function booking() {
        if (isset($_POST['reservar_vuelo']) && isset($_GET['flight']) || isset($_GET['flight'])) {
            $flight_id = $_GET['flight'];
            // Si el vuelo existe
            if($this->flightmodel->get_flight_id($flight_id) !=='not_found') {
                // Si hay más de un asiento
                if($this->flightmodel->get_flight_seats($flight_id) > 0) {
                     $this->createFlightForm(2, $_GET['from'], $_GET['to']);
                }
            }
        }
    }

    public function createFlightForm($people=1, $from, $to) {
        $output = '<h1>'.$this->flightmodel->get_airport_names($from, $to).'</h1>';
        $output .= '<form id="flight_booking_form" action="" method="post">';
        for ($i=1; $i <= $people; $i++) {
            $output .= '<div class="form-group">';
            $output .= '<h2>Información personal del pasajero ('.$i.')</h2>';
            $output .= '<label for="Passanger_name_'.$i.'">Nombre</label>';
            $output .= '<input id="Passanger_name_'.$i.'" class="form-control" name="passanger_name_'.$i.'">';
            $output .= '</div>';
            $output .= '<div class="form-group">';
            $output .= '<label for="passanger_lastname_'.$i.'">Apellido(s)</label>';
            $output .= '<input id="passanger_lastname_'.$i.'" class="form-control" name="passanger_lastname_'.$i.'">';
            $output .= '</div>';

            $output .= '<div class="form-group">';
            $output .= '<label for="passanger_birthday_'.$i.'">Fecha de nacimiento</label>';
            $output .= '<input id="passanger_birthday_'.$i.'" class="form-control" name="passanger_birthday_'.$i.'">';
            $output .= '</div>';

            if($i==1) {
                $output .= '<div class="form-group">';
                $output .= '<label for="passanger_lastname_'.$i.'">Número de teléfono</label>';
                $output .= '<input id="passanger_phone_number" class="form-control" name="passanger_phonenumber">';
                $output .= '</div>';
            }

            $output .= '<div class="form-group">';
            $output .= '<label for="passanger_address_'.$i.'">Dirección</label>';
            $output .= '<input id="passanger_address_'.$i.'" class="form-control" name="passanger_address_'.$i.'">';
            $output .= '</div>';

            $output .= '<div class="form-group">';
            $output .= '<label for="passanger_postalcode_'.$i.'">Código postal</label>';
            $output .= '<input id="passanger_postalcode_'.$i.'" class="form-control" name="passanger_postalcode_'.$i.'">';
            $output .= '</div>';


            $output .= '<div class="form-group">';
            $output .= '<button class="btn btn-primary">Continuar</button>';
            $output .= '</div>';
        }
        $output .= '</form>';
        echo $output;
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