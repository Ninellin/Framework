<?php


namespace Contentus;


class SiteController
{
    public function run()
    {
        $data = $this->getData();
        $this->renderView($data);
    }


    public function getData()
    {
        return [];
    }


    public function renderView($data)
    {
        $renderer = new \Renderer\ViewRenderer();
        $renderer->render('about.twig', $data);
    }
}
