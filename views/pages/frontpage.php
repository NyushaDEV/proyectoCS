<?php
$vuelos->buscar();
$airports = $this->db->q('SELECT * FROM aeropuertos');
var_dump($_SESSION);
?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión</h5> <button type="submit" class="close"
                    data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>

            <div class="modal-body">

                <div id="ajax"></div>
                <form method="post" id="loginform" action="ajax/login.php">
                    <div class="form-group"> <label for="loginEmail">E-mail</label>
                        <input name="email" type="email" class="form-control " id="loginEmail" aria-describedby="emailHelp"
                            placeholder="Enter email">
                        <div class="errors">

                        </div>
                        </div>
                    <div class="form-group"> <label for="exampleInputPassword1">Contraseña</label>
                        <input name="password" type="password" class="form-control" id="loginPassword"
                            placeholder="Password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Registrarse</button>
                <button id="login" type="submit" class="btn btn-primary">Entrar</button> </div>
        </div>
    </div>
</div>





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

    <div class="row">
        <div class="col-xs-6 col-md-6">
            <form method="post" id="aeropuertos" action="">
                <h4>Origen</h4>


                <div class="form-group">
                    <div class="ui-widget">
                        <select name="aeropuerto_origen" id="combobox_origen">
                            <option value="">Select one...</option>

                            <?php foreach ($airports as $airport) {?>
                                <option value="<?=$airport->nombre;?>"><?=$airport->nombre;?> (<?= $airport->codigo; ?>)</option>
                            <?php } //end foreach; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <a id="showFlightDate" class="btn btn-secondary" href="">Continuar</a>
                </div>
        </div>

        <div class="col-xs-6 col-md-6">
            <h4>Destino</h4>
            <div class="form-group">
                <select name="aeropuerto_destino" id="combobox_destino">
                    <option value="">Select one...</option>
                    <?php foreach ($airports as $airport) {?>
                        <option value="<?=$airport->nombre;?>"><?=$airport->nombre;?> (<?= $airport->codigo; ?>)</option>
                    <?php } //end foreach; ?>
                </select>
            </div>



        </div>

        <div class="col-xs-6 col-md-6">
            <div class="hidden-flight-wrapper d-none">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" checked type="radio" name="tipo" id="radioIda" value="ida">
                    <label class="form-check-label" for="radioIda">Solo ida</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo" id="idayVuelta" value="idavuelta">
                    <label class="form-check-label" for="idayVuelta">Ida y vuelta</label>
                </div>

                <div class="form-group">
                    <label for="fechasalida">Fecha de Salida</label>
                    <input  name="fechasalida" class="form-control" type="text" placehoder="Fecha de salida" id="fechasalida">

                </div>

            </div>
        </div>

        <div class="col-xs-6 col-md-6">
            <div class="hidden-flight-wrapper d-none">
                <div class="form-group">
                    <div id="fechaderegreso" class="d-none"><br>
                        <label for="fecharegreso">Fecha de regreso</label>
                        <input name="fecharegreso" class="form-control" type="text" placehoder="Fecha de regreso" id="fecharegreso">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 col-md-2 hidden-flight-wrapper d-none">
            <div class="form-group">
                <label for="Adultos">Adultos</label>
                <input type="number" name="adultos" class="form-control" value="1"  min="0" max="10">
            </div>
        </div>

        <div class="col col-xs-12 col-md-12">
            <div class="hidden-flight-wrapper d-none">

                <div class="form-group">
                    <button name="buscarvuelos" id="buscarVuelo" class="btn btn-secondary">
                        Buscar vuelo
                    </button>
                </div>
                </form>
            </div>
        </div>

    </div><!--/.row-->

</div>