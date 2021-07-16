<?php


namespace Commands;


class FileHandler
{
    public function __construct(RouteConfigHandler $routeConfigHandler)
    {
        $this->routeConfigHandler = $routeConfigHandler;
    }


    public function deleteFiles($name)
    {
        $type = $this->routeConfigHandler->getControllerType($name);
        unlink(__DIR__ . '/../controller/' . $name . 'Controller.php');
        unlink(__DIR__ . '/../views/' . $name . '.' . $type);
    }


    public function createFiles($name, $type)
    {
        $this->createController($name, ucfirst($type) . 'Controller');
        file_put_contents(__DIR__ . '/../views/' . $name . "." . $type, '#TODO Change this File');
    }


    private function createController($name, $controllerType)
    {
        $template = file_get_contents(__DIR__ . '/templates/controllerTemplates/' . $controllerType);
        $template  = str_replace('%%%CONTROLLERNAME%%%', $name, $template);
        file_put_contents(__DIR__ . '/../controller/' . $name . 'Controller.php', $template);
    }
}
