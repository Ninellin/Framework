<?php


namespace Commands;


class FileHandler
{
    public function __construct()
    {
    }


    public function deleteTwigFiles($name)
    {
        unlink(__DIR__ . '/../controller/' . $name . 'Controller.php');
        unlink(__DIR__ . '/../views/' . $name . '.twig');
    }


    public function createTwigFiles($name)
    {
        $this->createController($name, 'TwigController');
        file_put_contents(__DIR__ . '/../views/' . $name . '.twig', '#TODO Change this File');
    }


    private function createController($name, $controllerType)
    {
        $template = file_get_contents(__DIR__ . '/templates/controllerTemplates/' . $controllerType);
        $template  = str_replace('%%%CONTROLLERNAME%%%', $name, $template);
        file_put_contents(__DIR__ . '/../controller/' . $name . 'Controller.php', $template);
    }
}
