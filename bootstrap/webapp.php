<?php
use Silex\Application;
use ViewComponents\TestingHelpers\Application\Http\EasyRouting;
use ViewComponents\TestingHelpers\Application\Http\WebServerTestController;
use ViewComponents\ViewComponents\Rendering\RendererInterface;
use ViewComponents\ViewComponents\Rendering\SimpleRenderer;
use ViewComponents\ViewComponents\Service\Bootstrap;
use ViewComponents\ViewComponents\Service\ServiceContainer;
use ViewComponents\ViewComponents\Service\ServiceName;

require __DIR__ . '/bootstrap.php';

$app = new Application();
$app['debug'] = true;
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
    $container->extend(ServiceName::RENDERER, function (RendererInterface $renderer) {
        if (!$renderer instanceof SimpleRenderer) {
            throw new Exception(
                "Only SimpleRenderer is supported, current: " . get_class($renderer)
            );
        }
        $renderer->registerViewsPath(TESTING_HELPERS_DIR . '/resources/views');
        return $renderer;
    });
});

return $app;