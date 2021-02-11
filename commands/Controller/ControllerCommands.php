<?php


class ControllerCommands
{
    const INPUT_ERROR = "Unknown Input";

    public function __construct()
    {
         $this->userInterface = new UserInputOutput();
         $this->routeConfigHandler = new RouteConfigHandler();
    }

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

        $path = $this->userInterface->askUserForInput("Path: ");
        $this->routeAlreadyExist($routes, $path);

        $this->onControllerExist($routes, $controllerName, function() {
            throw new InOutException('Controller already exist');
        });

        $methods = $this->askUserforMethodsAndParse($methods);

        $routes["routes"][$controllerName]["path"] = $controllerName . "Controller.php";
        $routes["routes"][$controllerName]["link"] = $path;
        $routes["routes"][$controllerName]["allowed_methods"] = $methods;

        $routes = json_encode($routes);

        file_put_contents(__DIR__ . "/../../config/Routes.json", $routes);
    }


    private function routeAlreadyExist($routes, $path)
    {
        foreach ($routes["routes"] as $route)
        {
            if ($route["link"] === $path)
            {
                throw new InOutException("Path allready taken");
            }
        }

    }


    private function onControllerExist($routes, $controllerName, callable $onFound )
    {
        foreach ($routes["routes"] as $route)
        {
            if ($route["path"] === $controllerName . "Controller.php")
            {
                return $onFound($route);
            }
        }
    }

    /**
     * @param array $methods
     * @return array
     */
    private function askUserforMethodsAndParse(array $methods): array
    {
        $userMethods = readline("Methods (p=post; g=get; pg=both) ");

        switch ($userMethods) {
            case "p":
                $methods[] = "post";
                break;

            case "g":
                $methods[] = "get";
                break;

            case "pg":
                $methods[] = "get";
                $methods[] = "post";
                break;

            default:
                throw new InOutException(self::INPUT_ERROR);
        }
        return $methods;
    }

}
