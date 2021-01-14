<?php


namespace Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer
{
    public function __construct()
    {
        $this->fileLoader = new FilesystemLoader(__DIR__ . '/../../views');
        $this->twigHandler = new Environment($this->fileLoader);
    }

    public function render(string $nameOfView, array $params)
    {
        echo $this->twigHandler->render($nameOfView, $params);
    }
}
