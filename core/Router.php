<?php

namespace Contentus;

use Commands\errors\InOutException;
use stdClass;

class Router
{
    protected array $routes = [];

    protected stdClass $routesConfig;

    private Request $request;

    private ConfigHandler $configHandler;


    public function __construct(ConfigHandler $configHandler, Request $request)
    {
        $this->configHandler = $configHandler;

        $this->request = $request;
    }


    public function register_routes_from_config()
    {
        $this->loadRoutesFromConfig();


        foreach ($this->routesConfig->routes as $route)
        {
            $path = $route->path;
            $controller = $route->controller;
            $methodsToRegister = $route->allowed_methods;

            if (in_array('get', $methodsToRegister))
            {
                $this->registerGetPath($path, $controller);
            }
            if (in_array('post', $methodsToRegister))
            {
                $this->registerPostPath($path, $controller);
            }
        }
    }


    private function registerGetPath(string $path, string $controller)
    {
        $this->routes[] = new Route("get", $path, $controller);
    }


    private function registerPostPath(string $path, string $controller)
    {
        $this->routes[] = new Route("post", $path, $controller);
    }


    public function route()
    {
/*        if (!$this->currentPathIsAllowed())
        {
            echo '404';
            die();
        }*/

        return $this->getControllerForGivenRoute();

    }


    private function getControllerForGivenRoute()
    {
        foreach ($this->routes as $route)
        {
            if ($route->matches($this->request))
            {
                $pathToController = $route->getController();
                $controller = (substr($pathToController, 0, strpos($pathToController, '.php')));

                $str = "\\Controller\\" . $controller;

                $controller = new $str;

                return $controller;
            }
        }
        throw new InOutException("Path not found");
    }


    private function loadRoutesFromConfig()
    {
        $this->routesConfig = $this->configHandler->getRoutesConfig();
    }
}
