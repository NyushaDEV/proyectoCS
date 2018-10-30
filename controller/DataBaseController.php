<?php

class DataBaseController {

    private $user = 'root';
    private $pass = '';
    private $dbname = 'proyectodaw';
    private $host = 'proyectocs.io';
    private $pdo;

    public function __construct($host=null, $user=null, $pass=null, $dbname=null){
        if($host!==null) {
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->dbname = $dbname;
        }

        try {
            $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname.'', $this->user, $this->pass,
            array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ));

        } catch(Exception $e) {
            die($e);
        }
    }

    /**
     * Obtiene datos
     * @param $sql
     * @param array $data
     * @return array
     */
    public function q($sql, $data=array()) {
        $q = $this->pdo->prepare($sql);
        $q->execute($data);
        return $q->fetchAll(PDO::FETCH_OBJ);
      }

    /**
     * Guarda y borra datos de la base de datos.
     * @param $sql
     * @param array $data
     * @return bool
     */
    public function save($sql, $data=array()) {
        $q = $this->pdo->prepare($sql);
        return $q->execute($data);
        }
    }