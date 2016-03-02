<?php
use ViewComponents\ViewComponents\Component\Layout;

/** @var Layout $layout */
?>
<html>
<head>
    <title><?= $title ?></title>
    <?= $layout->section('head') ?>
</head>
<body>
<?= $layout->section('menu') ?>
<div class="container">
    <h1>Demo App<?= $title ? "<small>$title</small>" : '' ?></h1>
    <?= $layout->mainSection() ?>
</div>
<?= $layout->section('footer') ?>
</body>
</html>

