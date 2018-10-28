

<nav class="navbar">
    <div class="navbar-brand">
        <a class="navbar-item" href="/">
            <?= SITENAME; ?>
        </a>
        <div class="navbar-burger burger" data-target="navMenuColordark-example">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="">
                Inicio
            </a>
            <a class="navbar-item" href="<?= WWW; ?>/reserva">
                Reserva
            </a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <?php if($usermodel->isLogged()) { ?>
                <a class="navbar-item" href="#animatedModal">Mi cuenta</a>
                <a class="navbar-item" href="<?= WWW; ?>/ajax/logout.php">Desconectar</a>
                <?php } else { ?>
                <div class="buttons">
                    <a id="demo01" class="button is-light" href="#animatedModal">Iniciar sesión</a>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
    </div>
</nav>

<!--
    <div class="navbar-text">
        <?php //$core->l('test', 'hola!', array('class' => 'btn', 'target' => '_blank')); ?>
        <?php if (!$usermodel->isLogged()): ?>
            <a id="demo01" href="#animatedModal">Iniciar sesión</a>
        <?php else: ?>
            <a href="<?= WWW; ?>/ajax/logout.php">Desconectarse</a>
        <?php endif; ?>
    </div>
-->