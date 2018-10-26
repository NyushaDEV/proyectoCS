<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= $this->addRessource('bulma.min', 'css'); ?>
    <?= $this->addRessource('styles', 'css'); ?>
    <?= $this->addRessource('jquery-ui.min', 'css'); ?>
    <?= $this->addRessource('animate.min', 'css'); ?>
    <?= $this->addRessource('https://use.fontawesome.com/releases/v5.4.1/css/all.css', 'css', true); ?>



    <title><?= SITENAME; ?></title>
</head>
<body>
<script>
    var site_url = '<?= WWW; ?>';
</script>

<?php  $this->load('components/navbar'); ?>

<!-- Container -->
<div class="container">
    <?php $this->load('components/modal/login'); ?>
