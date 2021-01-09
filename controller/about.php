<?php

namespace Controller;

use Contentus\SiteController;
use Contentus\ViewRenderer;

class about extends SiteController
{
    /**
     * about constructor.
     */
    public function __construct()
    {
        echo 'about';
    }


    private function getData()
    {
        return [];
    }


    private function renderView($data)
    {
        $renderer = new \Renderer\ViewRenderer();
        $renderer->render('about.twig', $data);
    }
}
