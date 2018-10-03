<?php


class VuelosController {


    public function buscar() {
        if(isset($_POST['buscarvuelos'])) {
            echo "buscando vuelo...";
            var_dump($_POST);

        }
    }
}