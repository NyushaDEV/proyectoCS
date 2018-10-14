<?php

class User {

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function data($email, $password) {
        $user = false;
        $q = $this->db->q('SELECT * FROM usuarios WHERE email=:email AND password=:password LIMIT 1',array(
            'email' => $email,
            'password' => $password
        ));
        foreach($q as $data) {
            $user[] = $data;
        }
        return $data;
    }

}