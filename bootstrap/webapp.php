<?php
use Silex\Application;
use ViewComponents\TestingHelpers\Application\Http\EasyRouting;
use ViewComponents\TestingHelpers\Application\Http\WebServerTestController;

require __DIR__ . '/bootstrap.php';

$app = new Application();
$routeGenerator = EasyRouting::instance($app);
$routeGenerator->make(WebServerTestController::class);

// register additional controllers
$controllers = getenv('WEBAPP_CONTROLLERS');
$hasAdditionalControllers = false;
if ($controllers !== false) {
    $controllers = explode(',', $controllers);
    foreach ($controllers as $controller) {
        $routeGenerator->make($controller);
    }
}
if (!$hasAdditionalControllers) {
    $app->get('/', WebServerTestController::class . '::' . 'index');
}
return $app;