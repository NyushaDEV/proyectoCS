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

        if($p=='') {
            $this->load('pages/frontpage');
        } else {

            if(in_array($p, $allowed_pages)) {
                $this->load('pages/'.$p.'');
            } else {
                $this->load('pages/404');
            }
        }


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


    public function css($file) {
        return '<link rel="stylesheet" href="public/css/'.$file.'.css">';
    }
}