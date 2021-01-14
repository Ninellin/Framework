<?php

namespace Contentus;

use Exception;
use stdClass;

class Router
{
    protected array $routes = [];

    protected stdClass $routesConfig;

    private Request $request;

    private ConfigHandler $configHandler;


    public function __construct()
    {
        $this->configHandler = new ConfigHandler();

        $this->request = new Request();
    }


    public function register_routes_from_config()
    {
        $this->loadRoutesFromConfig();

        foreach ($this->routesConfig->routes as $route)
        {
            $path = $route->path;
            $link = $route->link;
            $methodsToRegister = $route->allowed_methods;

            if (in_array('get', $methodsToRegister))
            {
                $this->registerGetPath($link, $path);
            }
            if (in_array('post', $methodsToRegister))
            {
                $this->registerPostPath($link, $path);
            }
        }
    }


    private function registerGetPath(string $link, string $path)
    {
        $this->routes[] = new Route("get", $link, $path);
    }


    private function registerPostPath(string $link, string $path)
    {
        $this->routes[] = new Route("post", $link, $path);
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
        throw new Exception("Path not found");
    }


    private function loadRoutesFromConfig()
    {
        $this->routesConfig = $this->configHandler->getRoutesConfig();
    }
}
