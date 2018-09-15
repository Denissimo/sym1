<?php

namespace App\Loader;

use App\Proxy;
use Silex\Application as Silex;


class Loader
{
    public $test = 'Rds';

    public function __construct()
    {
        Proxy::init()->setSilex(new Silex());
    }
}