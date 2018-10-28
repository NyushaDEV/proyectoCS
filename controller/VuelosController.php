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

    public function displayFlights() {
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

        $output = '<table class="table is-striped is-fullwidth ">
              <thead>
                <tr>
                  <th scope="col">Hora de salida</th>
                  <th scope="col">Hora de llegada</th>
                  <th scope="col">Precio </th>
                  <th scope="col">Reservar</th>
                </tr>
              </thead><tbody>';
        foreach ($vuelos as $vuelo) {
//$core->formatDate($vuelo->fecha_salida, 'd-m-Y') == $fecha &&
            if ( $core->formatDate($vuelo->fecha_salida, 'd-m-Y') > $core->formatDate(time(), 'd-m-Y')) {

                $fecha_dia = date('d', $vuelo->fecha_salida);
                $fecha_mes = date('m', $vuelo->fecha_salida);
                $fecha_year = date('Y', $vuelo->fecha_salida);

                $reservar = $vuelo->asientos == 0 ? '<button  class="button is-disabled">No hay plazas</button>' : '<form action="' . WWW . '/booking&flight=' . $vuelo->idvuelo . '&from='.$from.'&to='.$to.'" method="post"><input type="hidden" name="id_vuelo" value="'.$vuelo->idvuelo.'"><button name="reservar_vuelo" class="button is-primary">Reservar</button></form>';
                $textoreserva = $vuelo->asientos > 0 && $vuelo->asientos < 20 ? '<span class="tag is-warning">Quedan menos de 20 asientos para este vuelo!</span>' : '';
                $output .= '<tr>
                <td>' . $core->formatDate($vuelo->fecha_salida, 'H:i') . '</td>
                <td class="center">' . $core->formatDate($vuelo->fecha_llegada, 'H:i') . '</td>
                      <td><span class="badge badge-success price">' . $vuelo->precio_inicial . ' €</span></td>
                      <td>' . $textoreserva  . $reservar .'</td>
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




        echo '<section class="hero is-warning hero-body">
<div class="container padding-25">

      <h1 class="title">Reservar vuelo</h1>';
        if (isset($_SESSION['vuelo'])) {
            echo '<h2>' . $_SESSION['vuelo']['aeropuerto_origen'] . ' - ' . $_SESSION['vuelo']['aeropuerto_destino'] . '</h2>';

            echo '<div><a href="'.WWW.'" class="button is-large is-dark is-pulled-right">Buscar de nuevo</a></div>';
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
            echo '<div class="columns"><div class="column">';
            $repeats_date = null;
            foreach ($vuelos as $result) {

                echo '<div class="tabs is-centered is-boxed is-medium"><ul>';
                if ($repeats_date !== $core->formatDate($result->fecha_salida, 'd-m-Y') && $core->formatDate($result->fecha_salida, 'd-m-Y') > $core->formatDate(time(), 'd-m-Y')) {
                    echo '
                        <form method="post" action="">
                        <input type="hidden" name="id_ruta" value="' . $idruta . '"/>
                        <input type="hidden" name="codigo_aeropuerto" value="' . $id . '"/>
                        <input type="hidden" name="fecha" value="' . $core->formatDate($result->fecha_salida, 'd-m-Y') . '"/>
                        <li class="is-active">
                        <a href="">
                        <span class="icon is-small"><i class="fas fa-calendar-alt " aria-hidden="true"></i></span>
                        <span>' . $core->formatDate($result->fecha_salida, 'l d F') . '</span></a>
                        </li>
                        </form>
                        ';
                }
                $repeats_date = $core->formatDate($result->fecha_salida, 'd-m-Y');
            }//end foreach */
            echo '</ul></div></div></div></div></section>'; // end .row

        } else {
            $output .= '<p>No tienes ninguna reserva hecha. </p> <a class="btn btn-primary" href="' . WWW . '">Buscar vuelos</a>';
        }

        echo $output;
    }


    /**
     * Muestra el formulario para hacer la reserva
     */
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

    /**
     * Crea uno o varios formularios  dependiendo de $people
     * @param int $people
     * @param $from
     * @param $to
     */
    public function createFlightForm($people=1, $from, $to) {
        $output = '<div class="columns"><div class="column is-8"><h1>'.$this->getCurrentDistination().'</h1>';
        $output .= '<div id="ajax-response"></div>';
        $output .= '<form id="flight_booking_form" action="'.WWW.'/ajax/savepassanger.php" method="post">';
        $output .= '<div class="field">';
            $output .= '<h2>Información personal del pasajero </h2>';
            $output .= '<label for="passanger_name">Nombre</label>';
            $output .= '<input id="passanger_name" class="input" name="passanger_name">';
            $output .= '</div>';
            $output .= '<div class="field">';
            $output .= '<label for="passanger_lastname">Apellido(s)</label>';
            $output .= '<input id="passanger_lastname" class="input" name="passanger_lastname">';
            $output .= '</div>';

            $output .= '<div class="field">';
            $output .= '<label for="passanger_birthday">Fecha de nacimiento</label>';
            $output .= '<input id="passanger_birthday" class="input" name="passanger_birthday">';
            $output .= '</div>';

            $output .= '<div class="field">';
            $output .= '<label for="passanger_lastname">Número de teléfono</label>';
            $output .= '<input id="passanger_phone_number" class="input" name="passanger_phonenumber">';
            $output .= '</div>';

            $output .= '<div class="field">';
            $output .= '<label for="passanger_city">Ciudad</label>';
            $output .= '<input id="passanger_city" class="input" name="passanger_city">';
            $output .= '</div>';

            $output .= '<div class="field">';
            $output .= '<label for="passanger_address">Dirección</label>';
            $output .= '<input id="passanger_address" class="input" name="passanger_address">';
            $output .= '</div>';

            $output .= '<div class="field">';
            $output .= '<label for="passanger_postcode">Código postal</label>';
            $output .= '<input id="passanger_postcode" class="input" name="passanger_postcode">';
            $output .= '</div>';

            $output .= '<div class="field"><label for="passanger_lugage">Equipaje</label></div> <div class="select">';
            $output .= '';
            $output .= '<select name="passanger_lugage">
                        <option>Sólo equipaje de mano</option>
                        <option>1 Maleta (20€)</option>
                        <option>2 Maletas (38€)</option>
                        </select>';
            $output .= '</div>';

        $output .= '<div class="field"><button id="add-passanger" class="button is-danger is-pulled-right">Añadir otro pasajero</button></div>';

        $output .= '</div>';
            $output .= $this->get_flight_summary();
            $output .= '</form></div>';
        echo $output;
    }

    public function get_flight_summary() {
        global $core;
        $fid = isset($_GET['flight']) ? $_GET['flight'] : null;
        $output = '<div class="column">';
        $output .= '<h2>Mi vuelo</h2>';
        $output .= '<p><strong>'.$this->getCurrentDistination().'</strong></p>';
        $output .= $core->formatDate($this->flightmodel->get_flight_info($fid)->fecha_salida, 'l M. H:i');
        $output .= '<div class="field"><button id="savePassanger" name="hacer_reserva" class="button is-large is-info">Continuar</button></div>';

        $output .= '<div class="summary-price">'.$this->flightmodel->calculatePrice($fid).'</div>';
        $output .= '</div>';
        return $output;
    }

    public function getCurrentDistination() {
        $from = $_GET['from'];
        $to = $_GET['to'];
        return $this->flightmodel->get_airport_names($from, $to);
    }

    public  function savePassanger() {
        $error = false;
        $ajax = array();
        if(isset($_POST['passanger_name'])) {

            $name = $_POST['passanger_name'];
            $lastname = $_POST['passanger_lastname'];
            $birthday = $_POST['passanger_birthday'];
            $phonenumber = $_POST['passanger_phonenumber'];
            $address = $_POST['passanger_address'];
            $postcode= $_POST['passanger_postcode'];

            /*if(empty($name) || empty($lastname) || empty($birthday) || empty($phonenumber) || empty($address) || empty($postcode)) {
                $ajax['message'] = 'Por favor, rellena todos los campos.';
                $ajax['status'] = 'empty';
                $error=true;
            }*/


        }
        echo json_encode($ajax, true);
    }
}