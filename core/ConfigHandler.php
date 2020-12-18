<?php


namespace Contentus;


class ConfigHandler
{
    /**
     * @return mixed
     */
    public function getRoutesConfig(){
        $routesConfig = file_get_contents(__DIR__.'/../config/Routes.json');
        $routesConfig = json_decode($routesConfig);
        return $routesConfig;
    }
}
