$( document ).ready(function() {

    var AirportsDepart = [
        "Málaga (AGP)",
        "Oslo (OSL)"
      ];
      $( "#origen" ).autocomplete({
        source: AirportsDepart
      });

});