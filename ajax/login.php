
<?php

$ajax = array();

if(isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) || !empty($password)) {
        $ajax['status'] = 'ok';
        $ajax['message'] = 'entrando...';
    } else {
        $ajax['status'] = 'error';
        $ajax['message'] = 'Campos vacios!';
    }
}

echo json_encode($ajax, true);

