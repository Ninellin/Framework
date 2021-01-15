<?php


class ControllerCommands
{

    const INPUT_ERROR = "Unknown Input";

    public function createTwigController($controllerName)
    {
        $template = file_get_contents(__DIR__ . '/../templates/controllerTemplates/TwigController');

        $template  = str_replace("%%%CONTROLLERNAME%%%", $controllerName, $template);

        $this->addToRouteConfig($controllerName);

        file_put_contents(__DIR__ . "/../../controller/". $controllerName . "Controller.php", $template);
        file_put_contents(__DIR__ . "/../../views/". $controllerName . ".twig", "#TODO Change this File");
    }


    public function createHtmlController($controllerName)
    {

    }


    private function addToRouteConfig($controllerName)
    {
        $methods = [];

        $routesJson = file_get_contents(__DIR__ . "/../../config/Routes.json");
        $routes = json_decode($routesJson, true);

        $path = readline("Path: ");
        $this->routeAllreadyExist($routes, $path);

        $userMethods = readline("Methodes (p=post; g=get; pg=both) ");

        switch ($userMethods)
        {
            case "p":   $methods[] = "post";
                        break;

            case "g":   $methods[] = "get";
                        break;

            case "pg":  $methods[] = "get";
                        $methods[] = "post";
                        break;

            default:    echo self::INPUT_ERROR;
                        die();
        }

        $routes["routes"][$controllerName]["path"] = $controllerName . "Controller.php";
        $routes["routes"][$controllerName]["link"] = $path;
        $routes["routes"][$controllerName]["allowed_methods"] = $methods;

        $routes = json_encode($routes);

        file_put_contents(__DIR__ . "/../../config/Routes.json", $routes);
    }


    private function routeAllreadyExist($routes, $path)
    {
        foreach ($routes["routes"] as $route)
        {
            if ($route["link"] === $path)
            {
                die("Path allready taken");
            }
        }

    }


    private function contollerAllreadyExist($routes, $controllerName)
    {
        foreach ($routes["routes"] as $route)
        {
            if ($routes["path"] === $controllerName . "Controller.php")
            {
                die("Controller already exist");
            }
        }
    }

}
