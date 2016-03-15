<?php
use ViewComponents\ViewComponents\Component\Layout;
/** @var Layout $layout */
/** @var string $title */
?>
<html>
<head>
    <title><?= $title ?></title>
    <?= $layout->section('head') ?>
</head>
<body>
<?= $layout->section('menu') ?>
<div class="container">
    <div style="margin: 10px">
        <h1>Demo App<?= $title ? "<small> \\\\ $title</small>" : '' ?></h1>
        <hr/>
    </div>
    <?= $layout->mainSection() ?>
</div>
<?= $layout->section('footer') ?>
<?php include __DIR__ . '/timing.php' ?>
</body>
</html>
