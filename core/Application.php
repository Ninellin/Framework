<?php

namespace Contentus;


class Application
{
    public function __construct()
    {
        $this->router = new Router();
        $this->router->register_routes_from_config();
    }


    public function run()
    {
        $controller = $this->router->route();
        $controller->run();
    }
}
