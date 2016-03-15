<hr>
<small>

    <?php if (isset($hasControllerActionTime)): ?>
        <div>Controller Action Execution Time: <?= PHP_Timer::secondsToTimeString(PHP_Timer::stop()) ?></div>
    <?php endif ?>

    <div>Execution time: <?= PHP_Timer::timeSinceStartOfRequest() ?></div>

    <?php if (isset($bootstrapTime)): ?>
        <div>Application Bootstrap time: <?= $bootstrapTime ?></div>
    <?php endif ?>

    <?php if (!empty($timers)) foreach ($timers as $name => $value): ?>
        <div><?= \Stringy\StaticStringy::humanize($name) ?>: <?= $value ?></div>
    <?php endforeach ?>

</small>