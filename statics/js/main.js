$(document).ready(function () {

  var AirportsDepart = [], AirportsArrival = [];

  window.onload = function () {
    $("#fechasalida").datepicker({ minDate: 0, maxDate: "+12M +10D" });

    bookFlightValidate();
    $(document).on('submit','#flight_booking_form', savePassenger);

    // Fecha nacimiento en la página de hacer reservas
    $("#passenger_birthday").datepicker({ minDate: "-100Y" , maxDate: 0 });

      $('input[name="tipo"]').on('change', idayVuelta);

    $('#showFlightDate').on('click', function(event) {
      console.log($('#inpt_combobox_origen').val());
      event.preventDefault();
      if($('#inpt_combobox_origen').val() !=='' && $($('#inpt_combobox_destino')).val() !=='') {
        $('.hidden-flight-wrapper').removeClass('is-invisible');
      } else {
          cordairways_api_show_error_message('#ajax-message', 'Debes elegir un lugar de origen y destino.');
      }

    });

  };


  function bookFlightValidate() {
      $("#flight_booking_form").validate({
          errorClass: 'is-danger',
          rules: {
              passenger_name: {
                  required: true,
                  minlength: 5
              }
              passenger_lastname: {
                  required: true,
                  minlength: 5
              },
              passenger_birthday: {
                  required: true
              },
              passenger_phonenumber: {
                  required: true,
                  minlength: 5
              },
              passenger_city: {
                  required: true,
                  minlength: 5
              },
              passenger_address: {
                  required: true,
                  minlength: 5
              },
              passenger_postcode: {
                  required: true,
                  minlength: 4
              },
              passenger_luggage: {
                  required: true
              }
          }
      });
  }

    function savePassenger(e) {

      e.preventDefault();
      var form = $('form#flight_booking_form');

      $('#error-message-api').hide();


      let passenger_name = $('#passenger_name');
      let passenger_lastname = $('#passenger_lastname');
      let passenger_birthday = $('#passenger_birthday');
      let passenger_phone = $('#passenger_phone_number');
      let passenger_address = $('#passenger_address');
      let passenger_city = $('#passenger_city');
      let passenger_postcode = $('#passenger_postcode');

      $.ajax({
          url: form.attr('action'),
          type: 'post',
          dataType: 'json',
          data: form.serialize(),
          beforeSend: function(){
              //form.hide();
              cordairways_api_create_loader('#ajax-response');
              $('#loading').removeClass('is-hidden');
          },
          complete: function(){
              //form.show();
              $('#loading').addClass('is-hidden');
          }
      })


          .done(function(data) {
              if(data.status == 'success') {
                  console.log(data.message);
              }

          })
          .fail(function (x, status, msg) {
              console.log(msg);
          })
  }


  function idayVuelta() {
    if (this.checked && this.value == 'idavuelta') {
      $('#fechaderegreso').removeClass('is-invisible');
      $("#fecharegreso").datepicker({ minDate: 0, maxDate: "+12M +10D" });
    } else if (this.value == 'ida') {
      $('#fechaderegreso').addClass('is-invisible');
    }
  }


  $('#login').on('click', function (e) {

    let errorEmail = false;
    let errorPassword = false;
    e.preventDefault();
    $ajax = $('#ajax');

    $ajax.show();

    // $ajax.html('<img src="'+site_url+'/statics/images/loading.svg">Iniciando sesión...');
    // $('#loginform').hide();

    $.ajax({
      url: 'ajax/login.php',
      type: 'post',
      dataType: 'json',
      data: $('#loginform').serialize()
    })
      .done(function (data) {
          // $ajax.hide();
          // $('#loginform').show();
          console.log(data);

        if(!errorEmail) {
          $('#loginEmail').removeClass('is-danger');
            $('#error-email').remove();
        }
        if(!errorPassword) {
          $('#loginPassword').removeClass('is-danger');
            $('#error-password').remove();
        }

        if ($('#loginEmail').val() == '') {
          errorEmail = true;
          console.log(data.message['email']);
          $('#loginEmail').addClass('is-danger');
          $('#loginEmail').after('<div id="error-email" class="tag is-danger">'+data.message['email']+'</div>');
        }
        if($('#loginPassword').val() == '') {
          errorPassword = true;
            $('#loginPassword').addClass('is-danger');
          $('#loginPassword').after('<div id="error-password" class="tag is-danger">'+data.message['pass']+'</div>');
        }
        if(data.status=='no_account') {
          console.log(data.message['no_account']);
          $('#error-no-account').remove();
          $('#loginPassword').after('<div id="error-no-account" class="tag is-warning">'+data.message['no_account']+'</div>');
        }
        if(data.status == 'success') {
          $('#loginModal').slideUp();
          window.location.href = 'frontpage';
        }
      })

      .fail(function (x, status, msg) {
        console.log(msg);
      })



  });

  function openModal(modalid) {
      var html = '<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
          '    <div class="modal-dialog" role="document">\n' +
          '        <div class="modal-content">\n' +
          '            <div class="modal-header">\n' +
          '                <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión</h5> <button type="submit" class="close"\n' +
          '                    data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>\n' +
          '            </div>\n' +
          '            <div class="modal-body">\n' +
          '                <form method="post" id="loginform" action="ajax/modal.php">\n' +
          '                    <div class="form-group"> <label for="loginEmail">E-mail</label>\n' +
          '                        <input name="email" type="email" class="form-control " id="loginEmail" aria-describedby="emailHelp"\n' +
          '                            placeholder="Enter email">\n' +
          '                        <div class="errors">\n' +
          '\n' +
          '                        </div>\n' +
          '                        </div>\n' +
          '                    <div class="form-group"> <label for="exampleInputPassword1">Contraseña</label>\n' +
          '                        <input name="password" type="password" class="form-control" id="loginPassword"\n' +
          '                            placeholder="Password">\n' +
          '                    </div>\n' +
          '                </form>\n' +
          '            </div>\n' +
          '            <div class="modal-footer">\n' +
          '                <button type="button" class="btn btn-secondary" data-dismiss="modal">Registrarse</button>\n' +
          '                <button id="modal" type="submit" class="btn btn-primary">Entrar</button> </div>\n' +
          '        </div>\n' +
          '    </div>\n' +
          '</div>';
      $('body').append(html);
  }
});


