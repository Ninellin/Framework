<?php


namespace Contentus;


class SiteController
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
