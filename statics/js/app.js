$(document).ready(function () {

  var AirportsDepart = [], AirportsArrival = [];

  window.onload = function () {
    openModal();
    $("#fechasalida").datepicker({ minDate: 0, maxDate: "+12M +10D" });
    $('input[name="tipo"]').on('change', idayVuelta);



    $('#showFlightDate').on('click', function(event) {
      console.log($('#inpt_combobox_origen').val());
      event.preventDefault();
      if($('#inpt_combobox_origen') !=='' && $($('#inpt_combobox_destino')).val() !=='') {
        $('.hidden-flight-wrapper').removeClass('d-none');
      } else {
        console.log('Empty!');
      }
    });
  };

  function openModal(modal) {
    let html = '';
    $('.container').append(html);
  }

  function idayVuelta() {
    if (this.checked && this.value == 'idavuelta') {
      $('#fechaderegreso').removeClass('d-none');
      $("#fecharegreso").datepicker({ minDate: 0, maxDate: "+12M +10D" });
    } else if (this.value == 'ida') {
      $('#fechaderegreso').addClass('d-none');
    }
  }


  $('#login').on('click', function (e) {
    e.preventDefault();
    console.log('kkekekeke');

    $.ajax({
      url: 'ajax/login.php',
      type: 'post',
      dataType: 'json',
      data: $('#loginform').serialize()
    })

      .done(function (data) {

        if ($('#loginEmail').val() == '') {
          console.log(data.message['email']);
          $('#loginEmail').addClass('is-invalid');
          $('#loginEmail').after('<div class="errors"><span class="error">'+data.message['email']+'</span></div>');
        }
        if($('#loginPassword').val() == '') {
          $('#loginPassword').addClass('is-invalid');
          $('#loginPassword').after('<div class="errors"><span class="error">'+data.message['pass']+'</span></div>');

        }
        console.log(data);
      })

      .fail(function (x, status, msg) {
        console.log(msg);
      })

  });
});


