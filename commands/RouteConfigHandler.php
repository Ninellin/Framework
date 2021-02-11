<?php


class RouteConfigHandler
{
    public function addToRouteConfig($controllerName, $path, $methods)
    {
        $routeConfig = $this->getRouteConfigFromFile();



        $this->putRouteConfigToFile($routeConfig);
    }

    private function getRouteConfigFromFile()
    {
        $routesJson = file_get_contents(__DIR__ . "/../../config/Routes.json");
        $this->routes = json_decode($routesJson, true);
    }

    private function putRouteConfigToFile($routeConfig)
    {
        $routesJson = json_encode($routeConfig);
        file_put_contents(__DIR__ . "/../../config/Routes.json", $routesJson);
    }
}
