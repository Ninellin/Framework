<?php

namespace Controller;

use Contentus\SiteController;
use Renderer\TwigRenderer;

class about extends SiteController
{
    /**
     * about constructor.
     */
    public function __construct()
    {
    }

    public function run()
    {
        parent::run();
    }

    private function getData()
    {
        return [];
    }


    private function renderView($data)
    {
        $renderer = new TwigRenderer();
        $renderer->render('about.twig', $data);
    }
}
