<?php

/**
 * Controlador para los Usuarios
 */
class UserController
{
    public function login()
    {
        global $db;

        var_dump($db);

        $ajax = array();

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if(empty($email)) {
                $ajax['message']['email'] = 'Campo email vacio.';
            }
            if(empty($password)) {
                $ajax['message']['pass'] = 'Campo contraseña vacio.';
            }

            if (!empty($email) || !empty($password)) {
                $ajax['status'] = 'ok';
                $ajax['message'][] = 'entrando...';
            } 
        }
        echo json_encode($ajax, true);
    }
}
