<?php

namespace App\Routing;

use App\Proxy;
use Silex\Application as Silex;


class Init
{
    public function __construct()
    {
        Proxy::init()->initSilex(new Silex());
        Proxy::init()->initDoctrine();
//        Proxy::init()->getSilex()->get('/blog', function () {
//            return 'Zxzs';
//        });
    }

    public function run()
    {
        (new Map())->build(new RouteList());
    }
}