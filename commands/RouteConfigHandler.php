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


    public function addToRouteConfig($controllerName, $type, $path, $methods)
    {
        $routeConfig = $this->getRouteConfigFromFile();

        $routeValidater = new RouteValidator();
        $routeValidater->validate($routeConfig, $controllerName, $path, $methods);

        $routeConfig = $this->buildEntry($routeConfig, $type, $controllerName, $path, $methods);

        $this->putRouteConfigToFile($routeConfig);
    }


    public function deleteFromRouteConfig( $controllerName)
    {
        $routeConfig = $this->getRouteConfigFromFile();
        $this->controllerExistsInConfig($controllerName, $routeConfig);

        unset($routeConfig['routes'][$controllerName]);

        $this->putRouteConfigToFile($routeConfig);
    }


    public function getControllerType($controllerName)
    {
        $routeConfig = $this->getRouteConfigFromFile();
        $this->controllerExistsInConfig($controllerName, $routeConfig);

        return $routeConfig["routes"][$controllerName]["type"];
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

    private function buildEntry($config, $type, $controllerName, $path, $methods)
    {
        $config["routes"][$controllerName]["path"] = $controllerName . "Controller.php";
        $config["routes"][$controllerName]["type"] = $type;
        $config["routes"][$controllerName]["link"] = $path;
        $config["routes"][$controllerName]["allowed_methods"] = $methods;

        return $config;
    }


    private function controllerExistsInConfig($controllerName, $routeConfig)
    {
        if (!array_key_exists($controllerName, $routeConfig['routes']))
            throw new InOutException($this->texts['errors']['CONTROLLER_NOT_EXISTS']);
    }
}
