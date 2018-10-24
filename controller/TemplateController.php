<?php

/**
 * Esta clase se encarga de mostrar las vistas.
 */
class TemplateController {

    public function __construct($core, $db, $users) {


        $this->core = $core;
        $this->db = $db;
        $this->users = $users;
        $this->pageLoader();

        global $users;

    }

    private function pageLoader() {
        global $users;
        $p = isset($_GET['p']) ? $_GET['p'] : '';
        $allowed_pages = array('frontpage', 'flights', 'users', 'reserva', 'booking');
        
        // Se carga el header para todas las páginas.
        $this->load('components/header');

        if($p=='') {
            $this->load('pages/frontpage');
        } else {

            if(in_array($p, $allowed_pages)) {
                $this->load('pages/'.$p.'');
            } else {
                $this->load('pages/404');
            }
        }
        // Se carga el footer para todas las páginas.
        $this->load('components/footer');

    }

    public function load($template, $page=false) {
        global $vuelos;
        global $usermodel, $core;
        $path =  root_path . '/views';
        
        $file = $path . '/' . $template . '.php';

        if(file_exists($file)) {
            ob_start();
            include($file);
            ob_end_flush();
        } else {
            $this->core->sysMessage('System Error: ' . $file . ' not found!');
        }
    }


    public static function addRessource($file, $type, $external=false) {
        $output = "";

        if($type=='css') {

        if($external) {
            '<link rel="stylesheet" href="'.$file.'">
        ';
        }
        $output = '<link rel="stylesheet" href="statics/css/'.$file.'.css"/>
        ';
    } else {
        if($external) {
            $output = '<script src="'.$file.'"></script>
        ';
        } else {
            $output = '<script src="statics/js/'.$file.'.js?v='.rand(0, 555).'"></script>
            ';
        }
    }

        return $output;
    }
}