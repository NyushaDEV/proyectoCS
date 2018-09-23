<?php

class CoreController {
    

    public function sysMessage($message, $type='error') {
        echo '<div class="sys-message '.$type.'"><strong>SYS ERROR: </strong>' . $message .'</div>';
    }
}