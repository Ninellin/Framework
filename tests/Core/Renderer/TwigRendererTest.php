<?php

namespace Tests\Core\Renderer;

use Renderer\TwigRenderer;
use PHPUnit\Framework\TestCase;
use Twig\Error\LoaderError;

class TwigRendererTest extends TestCase
{
    private TwigRenderer $twigRenderer;


    private function init()
    {
        $this->twigRenderer = new TwigRenderer();
    }


    /////Start test render/////
    public function testRenderAndExpectExceptionOnUnknownView()
    {
        $this->init();

        $this->expectException(LoaderError::class);

        $this->twigRenderer->render("abcdefghijklmnopqrstuvwxyz1234567890", []);
    }
    /////End test render/////
}
