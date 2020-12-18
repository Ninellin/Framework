<?php

namespace Contentus;

use Controller\index;

class Router
{
    protected array $routes = [];


    public function __construct()
    {
        $this->configHandler = new ConfigHandler();
        $this->routesConfig = $this->configHandler->get_routes_config();

        $this->request = new Request();
    }

    public function register_routes()
    {
        foreach ($this->routesConfig->routes as $route)
        {
            $path = $route->path;
            $link = $route->link;
            $methodsToRegister = $route->allowed_methods;

            if (in_array('get', $methodsToRegister))
            {
                $this->register_get($link, $path);
            }
            if (in_array('post', $methodsToRegister))
            {
                $this->register_post($link, $path);
            }
        }
    }


    private function register_get($link, $path)
    {
        $this->routes['get'][$link] = $path;
    }


    private function register_post($link, $path)
    {
        $this->routes['post'][$link] = $path;
    }


    public function route()
    {
        $currentPath = $this->request->getPath();
        $currentMethod = $this->request->getMethod();

        if (!array_key_exists($currentPath, $this->routes[$currentMethod]))
        {
            echo '404';
            die();
        }

        $pathToController = $this->routes[$currentMethod][$currentPath];

        $controller = (substr($pathToController, 0, strpos($pathToController, '.php')));

        include_once '../public/'. $pathToController;

        $controller = new $controller;

    }
}
