<?php

namespace App\Routing;


class Map
{
    public function build(RouteList $routList)
    {
        foreach ($routList->getUrls() as $key => $route) {

        }
        $a = $routList->getUrls()[0];
        var_dump($a);
    }
}