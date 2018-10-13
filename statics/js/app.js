$(document).ready(function () {

  var AirportsDepart = [], AirportsArrival = [];

  window.onload = function () {
    openModal();

   // $(document).on('submit','form#login', login);
  };

  function openModal(modal) {
    let html = '';
    $('.container').append(html);
  }


  $('#login').on('click', function(e) {
    e.preventDefault();
    console.log('kkekekeke');

    $.ajax({
      url: 'ajax/login.php',
      type: 'post',
      dataType: 'json',
      data: $('#loginform').serialize()
    })
      //data: $('form#login').serialize()
      //dataType: 'json',

      .done(function(data) {
        console.log(data);
      })

      .fail(function(x, status, msg) {
        console.log(msg);
      })

  });
});


