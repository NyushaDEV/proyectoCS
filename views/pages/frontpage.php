<?php
$vuelos = new VuelosController();
$vuelos->buscar();
$airports = $this->db->q('SELECT id, nombre FROM aeropuertos');

?>
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

        <div class="col">
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
        
        <div class="col">
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

    </div>
</div>