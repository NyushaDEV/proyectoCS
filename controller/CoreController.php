<?php

class CoreController {

    /**
     * @param $message
     * @param string $type
     */
    public function sysMessage($message, $type='error') {
        echo '<div class="sys-message '.$type.'"><strong>SYS ERROR: </strong>' . $message .'</div>';
    }

    /**
     * @param $url
     * @param $text
     * @param array $options
     */
    public function l($url, $text, $options = []) {
        foreach($options as $k => $option) {
            $output = $k . '="' . $option  . '"';
            echo '<a '.$output.' href="'.WWW . '/' . $url .'">'.$text.'</a>';
        }
    }

    /**
     * @param $url
     */
    public function redirect($url) {
        header('LOCATION: '. WWW . '/'. $url);
    }

    /**
     * @param $timestamp
     * @return false|string
     */
    public function formatDate($timestamp, $params) {
        return date($params, $timestamp);
    }

}