<?php


namespace Contentus;


class TwigController
{
    public function run()
    {
        $data = $this->getData();
        $this->renderView($data);
    }


    private function getData()
    {
    }


    private function renderView($data)
    {
    }
}
