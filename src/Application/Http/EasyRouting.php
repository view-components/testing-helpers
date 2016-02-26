<?php

namespace ViewComponents\TestingHelpers\Application\Http;

use Nayjest\StrCaseConverter\Str;
use Silex\Application;

class EasyRouting
{
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public static function instance(Application $app)
    {
        return new static($app);
    }

    public static function getPrefix($controller)
    {
        $parts = explode('\\', $controller);
        $baseClassName = array_pop($parts);
        return Str::toSnakeCase(str_replace('Controller', '', $baseClassName), '-');
    }

    public static function getUri($controller, $method)
    {
        $prefix = static::getPrefix($controller);
        return $prefix . '/' . Str::toSnakeCase($method, '-');
    }

    public static function getUris($controller)
    {
        $uris = [];
        $methods = get_class_methods($controller);
        $exceptions = [
            '__construct',
        ];
        foreach($methods as $method) {
            if (in_array($method, $exceptions)) {
                continue;
            }
            $uris[$method] = static::getUri($controller, $method);
        }
        return $uris;
    }

    /**
     * @param $controller string
     * @return $this
     */
    public function make($controller)
    {
        $uris = static::getUris($controller);
        $prefix = static::getPrefix($controller);
        foreach($uris as $method => $uri) {
            $this->app->get($uri, "$controller::$method");
            if ($method === 'index') {
                $this->app->get("$prefix", "$controller::$method");
                $this->app->get("$prefix/", "$controller::$method");
            }
        }
        return $this;
    }
}
