$( document ).ready(function() {

  var AirportsDepart = []; 
  window.onload = function() {
    cargarRutas();
  };


  function cargarRutas() {
    $.ajax({
      
        url: "ajax/rutas.php",
        data: {  },
        datatype: 'json',
    }).done(function (data) {

      let rutas = $.parseJSON(data);


      console.log(rutas[0][0]);

      $( "#origen" ).autocomplete({
        source: ""
      });

    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus);
      
    });

  }

    
      

      console.log(AirportsDepart);
});