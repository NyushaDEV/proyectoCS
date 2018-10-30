<?php

class Flight {

    private $flight_id;
    /**
     * Flight constructor.
     * @param $flight_id
     */
    public function __construct($flight_id=null)
    {
        $this->flight_id = $flight_id;
    }

    /**
     * @param $fid
     * @return bool
     */
    public function get_flight_id($fid) {
        global $db;
        $flight_id = $db->q('SELECT idvuelo FROM vuelos WHERE idvuelo=:idvuelo', array('idvuelo' => $fid));
        return $flight_id ? $flight_id[0]->idvuelo : 'not_found';
    }

    public function get_flight_seats($fid) {
        global $db;
        $flight_seats = $db->q('SELECT asientos FROM vuelos WHERE idvuelo=:idvuelo', array('idvuelo' => $fid));
        return $flight_seats ? $flight_seats[0]->asientos : 'not_found';
    }

    public function get_flight_info($fid) {
        global $db;
        $flight = $db->q('SELECT * FROM vuelos WHERE idvuelo=:idvuelo', array('idvuelo' => $fid));
        return $flight[0];
    }

    public function get_airport_names($from, $to) {
        global $db;
        $depart = $db->q('SELECT codigo, nombre FROM aeropuertos WHERE codigo=:codigo', array(
            'codigo'  => $from,
        ));

        $arrival = $db->q('SELECT codigo, nombre FROM aeropuertos WHERE codigo=:codigo', array(
            'codigo'  => $to,
        ));

        if($depart && $arrival) {
            return $depart[0]->nombre . ' - ' . $arrival[0]->nombre;
        }
    }

    public  function calculatePrice($fid) {
        $price = $this->get_flight_info($fid)->precio_inicial;

        // do some calculations then return price
        // ..
        return $price;
    }

    public function bookUnloggedPassenger($idvuelo, $uid = null) {
        global $db;
        if($uid == null) {
            $db->save('INSERT INTO reservas (idreserva, id_vuelo) VALUES(:idreserva, :id_vuelo) ', array(
                'idreserva' => $this->generateBookingReference(),
                'id_vuelo' => $idvuelo
            ));
            $db->save('UPDATE vuelos SET asientos = asientos - 1 WHERE idvuelo =:idvuelo', array('idvuelo' => $idvuelo));
        } else {
            $db->save('INSERT INTO reservas (idreserva, uid, id_vuelo, check_in) VALUES(:idreserva, :id_vuelo, 0) ', array(
                'idreserva' => $this->generateBookingReference(),
                'uid' => $uid,
                'id_vuelo' => $idvuelo,
            ));
        }

    }

    public function generateBookingReference() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 7; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}