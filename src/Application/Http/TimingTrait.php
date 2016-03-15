<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy Stepanenko
 * Date: 15.03.2016
 * Time: 16:19
 */

namespace ViewComponents\TestingHelpers\Application\Http;


use PHP_Timer;
use ViewComponents\ViewComponents\Component\Layout;

trait TimingTrait
{
    /**
     * @return Layout
     */
    abstract protected function layout();

    public function prepareTiming()
    {
        $layout = $this->layout();
        // start controller action times
        PHP_Timer::start();

        $layout->mergeData(
            [
                'bootstrapTime' => PHP_Timer::timeSinceStartOfRequest(),
                'hasControllerActionTime' => true,
            ]
        );
    }
}