<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/"><?= SITENAME; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="reserva">Reserva</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="routes">Rutas</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="help">Ayuda</a>
      </li>
      
    </ul>
  </div>

  <div class="navbar-text">
    <?php //$core->l('test', 'hola!', array('class' => 'btn', 'target' => '_blank')); ?>
<?php if(!$usermodel->isLogged()): ?>
        <a data-toggle="modal" data-target="#loginModal" href="#">Iniciar sesión</a>
<?php else: ?>
<a  href="<?= WWW; ?>/ajax/logout.php">Desconectarse</a>
<?php endif; ?>
  </div>

</nav>