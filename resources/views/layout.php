<?php
use ViewComponents\ViewComponents\Component\Layout;
/** @var Layout $layout */
/** @var string $title */
?>
<html>
<head>
    <title><?= $title ?></title>
    <?= $layout->section('head')->render() ?>
</head>
<body>
<?= $layout->section('menu')->render() ?>
<div class="container">
    <div style="margin: 10px">
        <h1>Demo App<?= $title ? "<small> \\\\ $title</small>" : '' ?></h1>
        <hr/>
    </div>
    <?= $layout->mainSection()->render() ?>
</div>
<?= $layout->section('footer')->render() ?>
<?php include __DIR__ . '/timing.php' ?>
<style>
    .container {
        margin-right: auto;
        margin-left: auto;
        max-width: 1170px;
        padding: 10px;
    }
</style>
</body>
</html>
