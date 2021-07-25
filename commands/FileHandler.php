<?php


namespace Commands;


use Commands\errors\FileException;

class FileHandler
{
    public function __construct(RouteConfigHandler $routeConfigHandler, TextHandler $textHandler)
    {
        $this->textHandler = $textHandler;
        $this->routeConfigHandler = $routeConfigHandler;

        $this->texts = $this->textHandler->getTextsByLang();
    }


    public function deleteFiles($name)
    {
        $type = $this->routeConfigHandler->getControllerType($name);

        if (!file_exists(__DIR__ . '/../controller/' . $name . 'Controller.php'))
        {
            throw new FileException($this->texts['errors']['CONTROLLER_NOT_EXISTS']);
        }
        elseif (!file_exists(__DIR__ . '/../views/' . $name . '.' . $type))
        {
            throw new FileException($this->texts['errors']['VIEW_NOT_EXISTS']);
        }

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
