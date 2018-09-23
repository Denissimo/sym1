<?php

namespace App\Controller;

use App\Proxy;
use Symfony\Component\HttpFoundation\Request;


abstract class BaseController
{
    /**
     * @var Request
     */
    private static $request;

    public function __construct()
    {
        self::$request = Request::createFromGlobals();
        Proxy::init()->initTwig();
        Proxy::init()->initDoctrine();
        Proxy::init()->initSession()->getSession()->start();
    }

    /**
     * @return Request
     */
    public static function getRequest(): Request
    {
        return self::$request;
    }
}