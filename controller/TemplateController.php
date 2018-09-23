<?php

class Template {

    public function __construct() {

    }

    public function load($template) {

        $path =  $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'] . '/views';
        $file = $path . '/' . $template . '.php';

        if(file_exists($file)) {
            ob_start();
            include($file);
            ob_end_flush();
        } else {
            die('System Error: ' . $file . ' not found!');
        }
    }
}