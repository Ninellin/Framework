<?php


namespace Contentus;


class Route
{
    private $controller;
    private $methode;
    private $path;

    public function __construct($methode, $path, $controller)
    {
        $this->methode = $methode;
        $this->path = $path;
        $this->controller = $controller;
    }


    public function matches($request): bool
    {
        if ($this->path === $request->getPath() && $this->methodeAllowed($request))
        {
            return true;
        }

        return false;
    }


    public function getController(): string
    {
        return $this->controller;
    }


    private function methodeAllowed($request): bool
    {
        if ($this->methode === $request->getMethod())
        {
            return true;
        }

        return false;
    }
}
