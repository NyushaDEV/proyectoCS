<?php

class User {

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function data($email, $password) {
        return $this->db->q('SELECT * FROM usuarios WHERE email=:email AND password=:password LIMIT 1',array(
            'email' => $email,
            'password' => $password
        ));
    }

    public function isLogged() {
        if(isset($_SESSION['email'])) {
            return $this->data($_SESSION['email'], $_SESSION['password']) ? true : false;
        } 
        return false;
    }

}