<?php


namespace Contentus;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewRenderer
{
    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/templates');
        $this->twig = new Environment($this->loader);
    }

    public function render(string $pathToView, array $params)
    {
        echo $this->twig->render($pathToView, $params);
    }
}
