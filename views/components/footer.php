<!---->
<!--<footer>-->
<!--<div class="content has-text-centered has-text-black">-->
<!--    <p>-->
<!--        Proyecto Fin de Ciclo - Hecho por Kamal Nouari -  &copy; 2018-->
<!--    </p>-->
<!--    <p> IES TRASSIERRA - Córdoba</p>-->
<!--</div>-->
<!---->
<!---->
<!--</footer>-->


</div> <!-- ./container -->
<?= $this->addRessource('jquery-3.3.1.min', 'js'); ?>
<?= $this->addRessource('bootstrap.min', 'js'); ?>
<?= $this->addRessource('jquery-ui.min', 'js'); ?>
<?= $this->addRessource('animatedModal.min', 'js'); ?>
<?= $this->addRessource('autocomplete', 'js'); ?>
<?= $this->addRessource('app', 'js'); ?>

<script>

    $("#demo01").animatedModal({
        color: '#484848',
        animatedIn: 'zoomIn',
        animatedOut: 'bounceOut',
        animationDuration: '.4s'
    });

</script>

</body>
</html>