$(document).ready(function () {

  var AirportsDepart = [], AirportsArrival = [];

  window.onload = function () {
    openModal();
    $("#fechasalida").datepicker({ minDate: 0, maxDate: "+12M +10D" });
    $('input[name="tipo"]').on('change', idayVuelta);

    $('#showFlightDate').on('click', function(event) {
      console.log($('#inpt_combobox_origen').val());
      event.preventDefault();
      if($('#inpt_combobox_origen').val() !=='' && $($('#inpt_combobox_destino')).val() !=='') {
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

    let errorEmail = false;
    let errorPassword = false;
    e.preventDefault();
    $ajax = $('#ajax');

    $ajax.show();

    $ajax.html('<img src="'+site_url+'/statics/images/loading.svg">Iniciando sesión...');
    $('#loginform').hide();


    $.ajax({
      url: 'ajax/login.php',
      type: 'post',
      dataType: 'json',
      data: $('#loginform').serialize()
    })


      .done(function (data) {
          $ajax.hide();
          $('#loginform').show();
          console.log(data);

        $('.errors').empty("");

        if(!errorEmail) {
          $('#loginEmail').removeClass('is-invalid');
        }
        if(!errorPassword) {
          $('#loginPassword').removeClass('is-invalid');
        }

        if ($('#loginEmail').val() == '') {
          errorEmail = true;
          console.log(data.message['email']);
          $('#loginEmail').addClass('is-invalid');
          $('#loginEmail').after('<div class="errors"><span class="error">'+data.message['email']+'</span></div>');
        }
        if($('#loginPassword').val() == '') {
          errorPassword = true;
          $('#loginPassword').addClass('is-invalid');
          $('#loginPassword').after('<div class="errors"><span class="error">'+data.message['pass']+'</span></div>');
        }
        if(data.status=='no_account') {
          console.log(data.message['no_account']);
          $('#error-no-account').remove();
          $('.modal-body').append('<div id="error-no-account" class="alert alert-warning">'+data.message['no_account']+'');
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
          '                <form method="post" id="loginform" action="ajax/login.php">\n' +
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
          '                <button id="login" type="submit" class="btn btn-primary">Entrar</button> </div>\n' +
          '        </div>\n' +
          '    </div>\n' +
          '</div>';
      $('body').append(html);
  }
});


