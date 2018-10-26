<div id="animatedModal">
<div class="close-animatedModal">
        <img width="50" align="right" src="statics/images/close_icon.svg" alt="">
    </div>
<div class="hero is-primary">


    <div class="hero-body">
        <div class="container">


    <div class="modal-content">

        <div id="ajax"></div>
        <h1 class="title">Iniciar sesión</h1>

        <p>Iniciar sesión ahora para gestionar tus vuelos</p>
        <form method="post" id="loginform" action="<?= WWW; ?>/ajax/login.php">

            <div class="field">

                <p class="control has-icons-left has-icons-right">
                <input name="email" type="email" class="input" id="loginEmail" aria-describedby="emailHelp"
                       placeholder="Enter email">
                <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
                </p>

            </div>

            <div class="field">
                <p class="control has-icons-left has-icons-right">
                    <input name="password" type="password" class="input" id="loginPassword" aria-describedby="emailHelp"
                           placeholder="**********">
                    <span class="icon is-small is-left">
                  <i class="fas fa-unlock"></i>
                </span>
                </p>
            </div>


<br>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <button id="login" type="submit" class="button is-large is-fullwidth">Entrar</button> </div>
                </div>
                <div class="column">
                    <div class="field">
                        <button type="button" class="button is-large is-warning  is-full-mobile is-full-tablet">Crear cuenta</button>
                    </div>
                </div>
            </div>

        </form>

    </div>
        </div>
    </div>
</div>
</div>