<?php


namespace Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewRenderer
{
    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../../views');
        $this->twig = new Environment($this->loader);
    }

    public function render(string $nameOfView, array $params)
    {
        echo $this->twig->render($nameOfView, $params);
    }
}
