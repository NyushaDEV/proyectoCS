$(document).ready(function () {

  var AirportsDepart = [], AirportsArrival = [];

  window.onload = function () {
    openModal();
    
  };

  function openModal(modal) {
    let html = '<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> <div class="modal-body"><form> <div class="form-group"> <label for="exampleInputEmail1">E-mail</label> <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"></div> <div class="form-group"> <label for="exampleInputPassword1">Contraseña</label> <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"> </div> </form></div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Registrarse</button> <button type="button" class="btn btn-primary">Entrar</button> </div> </div> </div> </div>';
    $('.container').append(html);
  }

});