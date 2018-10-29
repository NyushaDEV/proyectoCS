<?php
$vuelos->buscar();
$airports = $this->db->q('SELECT * FROM aeropuertos');
var_dump($_SESSION);
?>

<div id="search">
    <style>
        .custom-combobox {
            position: relative;
            display: inline-block;
        }
        .custom-combobox-toggle {
            position: absolute;
            top: 0;
            bottom: 0;
            margin-left: -1px;
            padding: 0;
        }
        .custom-combobox-input {
            margin: 0;
            padding: 5px 10px;
            width: 400px !important;
        }
    </style>
    <div class="row">
        <div class="col">
        </div>
        <div class="col">
            <h1>Buscar vuelos...</h1>
        </div>
        <div class="col"></div>
    </div>

    <div class="columns">
        <div class="column">
            <form method="post" id="aeropuertos" action="">
                <h4>Origen</h4>
                <div class="control">
                    <div class="ui-widget">
                        <select name="aeropuerto_origen" id="combobox_origen">
                            <option value="">Select one...</option>

                            <?php foreach ($airports as $airport) {?>
                                <option value="<?=$airport->nombre;?>"><?=$airport->nombre;?> (<?= $airport->codigo; ?>)</option>
                            <?php } //end foreach; ?>

                        </select>
                    </div>
                </div>

        </div>

        <div class="column">
            <h4>Destino</h4>
            <div class="control">
                <select name="aeropuerto_destino" id="combobox_destino">
                    <option value="">Select one...</option>
                    <?php foreach ($airports as $airport) {?>
                        <option value="<?=$airport->nombre;?>"><?=$airport->nombre;?> (<?= $airport->codigo; ?>)</option>
                    <?php } //end foreach; ?>
                </select>
            </div>

        </div>

    </div>

    <div class="columns">

        <div class="column ">
            <div class="control">
                <a id="showFlightDate" class="button is-large is-warning is-full-mobile" href="">Continuar</a>
                <div id="ajax-message"></div>
            </div>
        </div>

    </div>

    <div class="columns">

        <div class="column">
            <div class="hidden-flight-wrapper is-invisible">
                <div class="control">
                    <input class="form-check-input" checked type="radio" name="tipo" id="radioIda" value="ida">
                    <label class="form-check-label" for="radioIda">Solo ida</label>
                    <input class="form-check-input" type="radio" name="tipo" id="idayVuelta" value="idavuelta">
                    <label class="form-check-label" for="idayVuelta">Ida y vuelta</label>
                </div>

                <div class="control">
                    <label for="fechasalida">Fecha de Salida</label>
                    <input  name="fechasalida" class="input" type="text" placehoder="Fecha de salida" id="fechasalida">

                    <div id="ajax-message-fechasalida"></div>
                </div>

            </div>
        </div>

        <div class="column">
            <div class="control hidden-flight-wrapper">
                <div id="fechaderegreso" class="is-invisible"><br>
                    <label for="fecharegreso">Fecha de regreso</label>
                    <input name="fecharegreso" class="input" type="text" placehoder="Fecha de regreso" id="fecharegreso">
                </div>
            </div>
        </div>
    </div><!--/.columns-->

    <div class="columns">

        <div class="column hidden-flight-wrapper is-invisible">
            <div class="control">
                <label for="Adultos">Adultos</label>
                <input type="number" name="adultos" class="input" value="1"  min="0" max="10">
            </div>
        </div>
    </div><!-- /.columns -->

    <div class="columns">
        <div class="column">
            <div class="hidden-flight-wrapper is-invisible">
                <div class="control">
                    <button name="buscarvuelos" id="buscarVuelo" class="button is-large is-danger is-fullwidth">
                        Buscar vuelo
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>