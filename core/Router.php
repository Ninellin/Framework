<?php

namespace Contentus;

use Controller\index;
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
        $this->routes['get'][$link] = $path;
    }


    private function registerPostPath(string $link, string $path)
    {
        $this->routes['post'][$link] = $path;
    }


    public function route()
    {
        $currentPath = $this->request->getPath();
        $currentMethod = $this->request->getMethod();

        if (!$this->currentPathIsAllowed($currentPath, $currentMethod))
        {
            echo '404';
            die();
        }

        return $this->getControllerForGivenRoute($currentPath, $currentMethod);

    }


    private function getControllerForGivenRoute(string $currentPath, string $currentMethod)
    {
        $pathToController = $this->routes[$currentMethod][$currentPath];
        $controller = (substr($pathToController, 0, strpos($pathToController, '.php')));

        $str = "\\Controller\\" . $controller;

        $controller = new $str;

        return $controller;
    }


    private function currentPathIsAllowed(string $currentPath, string $currentMethod)
    {
        if (!array_key_exists($currentPath, $this->routes[$currentMethod]))
        {
            return false;
        }

        return true;
    }


    private function loadRoutesFromConfig()
    {
        $this->routesConfig = $this->configHandler->getRoutesConfig();
    }
}
