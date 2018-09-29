<?php

/**
 * Esta clase se encarga de mostrar las vistas.
 */
class TemplateController {

    private $gcore; // global core
    public function __construct($core) {
        $this->gcore = $core;
        $this->pageLoader();
    }

    private function pageLoader() {
        $p = isset($_GET['p']) ? $_GET['p'] : '';
        $allowed_pages = array('frontpage', 'flights', 'users');


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
        $path =  root_path . '/views';
        
        $file = $path . '/' . $template . '.php';

        if(file_exists($file)) {
            ob_start();
            include($file);
            ob_end_flush();
        } else {
            $this->gcore->sysMessage('System Error: ' . $file . ' not found!');
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
            $output = '<script src="'.$file.'">
        ';
        } else {
            $output = '<script src="statics/js/'.$file.'.js"></script>
            ';
        }
    }

        return $output;
    }
}