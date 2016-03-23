<?php
use Silex\Application;
use ViewComponents\TestingHelpers\Application\Http\EasyRouting;
use ViewComponents\TestingHelpers\Application\Http\WebServerTestController;
use ViewComponents\ViewComponents\Rendering\RendererInterface;
use ViewComponents\ViewComponents\Rendering\SimpleRenderer;
use ViewComponents\ViewComponents\Service\Bootstrap;
use ViewComponents\ViewComponents\Service\ServiceContainer;
use ViewComponents\ViewComponents\Service\ServiceName;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

require __DIR__ . '/bootstrap.php';

// create app
$app = new Application();
$app['debug'] = true;

// error handling
ErrorHandler::register();
ExceptionHandler::register();

// register basic controller
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
$routeGenerator->make(WebServerTestController::class);
if (!$hasAdditionalControllers) {
    $app->get('/', WebServerTestController::class . '::' . 'index');
}

Bootstrap::registerServiceProvider(function (ServiceContainer $container) {
    // register views path
    $container->extend(ServiceId::RENDERER, function (RendererInterface $renderer) {
        $renderer->getFinder()->registerPath(TESTING_HELPERS_DIR . '/resources/views');
        return $renderer;
    });
});

return $app;