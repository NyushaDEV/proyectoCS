<?php

/**
 * Controlador para los Usuarios
 */
class UserController {
    private $usermodel;
    private $core;
    public function __construct($usermodel)
    {
        global $usermodel;
        global $core;
        $this->usermodel = $usermodel;
        $this->core = $core;
    }

    public function login()
    {
        global $db;

        $ajax = array();
        $ajax['status'] = 'error';

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $login_user_data = $this->usermodel->data($email, $password);

            if(empty($email)) {
                $ajax['message']['email'] = 'Campo email vacio.';
            }
            if(empty($password)) {
                $ajax['message']['pass'] = 'Campo contraseña vacio.';
            }

         else if($login_user_data) {
                // login correct
                $ajax['status'] = 'success';
                $_SESSION['email']  = $email;
                $_SESSION['password']  = $password;
                
            } else {
                $ajax['status'] = 'no_account';
                $ajax['message']['no_account'] = 'La dirección email o la contraseña no son correctos.';
            }
 
        }
        echo json_encode($ajax, true);
    }


    public function logout() {
        session_destroy();
        unset($_SESSION);
        header('location: http://proyectocs.io');
        exit();
    }

    public function redirectIfNotLogged() {

        if(!$this->usermodel->isLogged()) {
            $this->core->redirect('/');
        }
    }
    
}
