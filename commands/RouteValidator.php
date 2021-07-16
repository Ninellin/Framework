<?php

namespace Commands;

use Commands\errors\InOutException;

class RouteValidator
{
    public function __construct(TextHandler $textHandler)
    {
        $this->textHandler = $textHandler;
        $this->texts = $this->textHandler->getTextsByLang();
    }


    public function validate($config, $controllerName, $path, $methods)
    {
        $this->validatePath($config["routes"], $path, function (){
            throw new InOutException($this->texts["errors"]["PATH_TAKEN"]);
        });

        $this->validateController($config["routes"], $controllerName, function () {
            throw new InOutException($this->texts["errors"]["CONTROLLER_EXISTS"]);
        });
    }

    private function validatePath($configPaths, $path, callable $onFound)
    {
        foreach ($configPaths as $paths)
        {
            if ($paths["path"] === $path)
            {
                return $onFound($paths);
            }
        }
    }


    private function validateController($configPaths, $controllerName, callable $onFound)
    {
        {
            foreach ($configPaths as $paths)
            {
                if ($paths["controller"] === $controllerName . "Controller.php")
                {
                    return $onFound($paths);
                }
            }
        }
    }
}
