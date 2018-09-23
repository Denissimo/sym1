<?php

namespace App\Controller;

use App\Proxy;


abstract class BaseController
{
    public function __construct()
    {
        Proxy::init()->initTwig();
        Proxy::init()->initDoctrine();
        Proxy::init()->initSession()->getSession()->start();
    }
}