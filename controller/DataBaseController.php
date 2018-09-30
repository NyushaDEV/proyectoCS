<?php

class DataBaseController {

    private $user = 'root';
    private $pass = '';
    private $dbname = 'cordairways';
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
            $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname.'', $this->user, $this->pass);

        } catch(Exception $e) {
            die($e);
        }
    }

}