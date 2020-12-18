<?php


namespace Contentus;


class Application
{
    public function __construct()
    {
        $router = new Router();
        $router->register_routes();
        $router->route();
    }
}
