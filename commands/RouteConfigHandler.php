<?php

namespace Commands;

use Commands\errors\InOutException;

class RouteConfigHandler
{
    public function __construct()
    {
        $this->textHandler = new TextHandler();
        $this->texts = $this->textHandler->getTextsByLang();
    }


    public function addToRouteConfig($controllerName, $path, $methods)
    {
        $routeConfig = $this->getRouteConfigFromFile();

        $routeValidater = new RouteValidator();
        $routeValidater->validate($routeConfig, $controllerName, $path, $methods);

        $routeConfig = $this->buildEntry($routeConfig, $controllerName, $path, $methods);

        $this->putRouteConfigToFile($routeConfig);
    }


    public function deleteFromRouteConfig( $controllerName)
    {
        $routeConfig = $this->getRouteConfigFromFile();

        if (array_key_exists($controllerName, $routeConfig['routes']))
        {
            unset($routeConfig['routes'][$controllerName]);
        }
        else
        {
            throw new InOutException($this->texts['errors']['CONTROLLER_NOT_EXISTS']);
        }

        $this->putRouteConfigToFile($routeConfig);
    }


    private function getRouteConfigFromFile()
    {
        $routesJson = file_get_contents(__DIR__ . "/../config/Routes.json");
        return json_decode($routesJson, true);
    }

    private function putRouteConfigToFile($routeConfig)
    {
        $routesJson = json_encode($routeConfig);
        file_put_contents(__DIR__ . "/../config/Routes.json", $routesJson);
    }

    private function buildEntry($config, $controllerName, $path, $methods)
    {
        $config["routes"][$controllerName]["path"] = $controllerName . "Controller.php";
        $config["routes"][$controllerName]["link"] = $path;
        $config["routes"][$controllerName]["allowed_methods"] = $methods;

        return $config;
    }
}
