$(document).ready(function () {

  var AirportsDepart = [], AirportsArrival = [];

  window.onload = function () {
  };

/**
 * Llamada en ajax que carga las rutas del Aeropuerto de origen
 */
/*
  function cargarRutasOrigen() {
    $.ajax({

      url: "ajax/ruta_origen.php",
      data: {},
    }).done(function (data) {
      let rutas = JSON.parse(data);

      $.each(rutas[0], function (i, ele) {
       AirportsDepart[i] = ele.nombre; 
      });

      $("#origen").autocomplete({
        source: AirportsDepart
      });

    }).fail(function (jqXHR, textStatus) {
      console.log(textStatus);

    });

  }
*/
/**
 * Llamada en ajax que carga las rutas del Aeropuerto de destino
 */
/*
function cargarRutasDestino() {

  $.ajax({
    type: 'POST',
    url: "ajax/ruta_destino.php",
    dataType: 'json',
    data: {
      origen: $('input#origen').val()
    },
  }).done(function (data) {


    $.each(data, function(i, ele) {
      AirportsArrival[i] = ele[0].nombre;
    });


    $("#destino").autocomplete({
      source: AirportsArrival
    });
    
  }).fail(function ( jqXHR, textStatus, msg) {
    console.log(msg);

  });

}
*/
});