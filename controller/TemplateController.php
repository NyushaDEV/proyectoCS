<?php

/**
 * Esta clase se encarga de mostrar las vistas.
 */
class TemplateController {

    private $gcore; // global core
    public function __construct($core) {
        $this->gcore = $core;
    }

    public function load($template) {
        $path =  $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'] . '/views';
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