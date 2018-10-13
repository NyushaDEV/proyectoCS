<?php
$vuelos = new VuelosController();
$vuelos->buscar();
$airports = $this->db->q('SELECT id, nombre FROM aeropuertos');

?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión</h5> <button type="submit" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> <div class="modal-body">
<form method="post" id="loginform" action="ajax/login.php">
<div class="form-group"> <label for="exampleInputEmail1">E-mail</label>
<input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"></div>
<div class="form-group"> <label for="exampleInputPassword1">Contraseña</label>
<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
</div> </form></div> <div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-dismiss="modal">Registrarse</button>
 <button id="login" type="submit" class="btn btn-primary">Entrar</button> </div> </div> </div> </div>
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
  }
  </style>

<div id="search">

    <div class="row">
        <div class="col">
        </div>
        <div class="col">
            <h2>Buscar vuelo...</h2>
        </div>
        <div class="col"></div>
    </div>

    <div class="row">

    
        <div class="col-md-6">
            <form method="post" id="aeropuertos" action="">
                <h4>Origen</h4>


                <div class="form-group">
                    <div class="ui-widget">
                        <select  name="aeropuerto_origen" id="combobox_origen">
                            <option value="">Select one...</option>

                            <?php foreach ($airports as $airport) {?>
                            <option value="<?=$airport->nombre;?>"><?=$airport->nombre;?></option>
                            <?php } //end foreach; ?>

                        </select>
                    </div>
                </div>
        </div>

        <div class="col-md-6">
            <h4>Destino</h4>
            <div class="form-group">
            <select  name="aeropuerto_destino" id="combobox_destino">
                            <option value="">Select one...</option>
                            <?php foreach ($airports as $airport) {?>
                            <option value="<?=$airport->nombre;?>"><?=$airport->nombre;?></option>
                            <?php } //end foreach; ?>
                        </select>
            </div>
        </div>
    
        <div class="col col-md-12">
            <div class="form-group">
                <button name="buscarvuelos" id="buscarVuelo" class="btn btn-secondary">
                    Buscar vuelo
                </button>
            </div>
            </form>
        </div>

    </div> <!--/.row-->
</div>