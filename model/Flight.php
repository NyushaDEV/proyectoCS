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
}