<?php

namespace App\Controller;

use App\Proxy;
use App\Cfg\Config;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Actions\Autorize;


abstract class BaseController
{
    const
        POST = 'POST',
        LOGOUT = 'logout';
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
        $this->autorize();
    }

    /**
     * @return Request
     */
    public static function getRequest(): Request
    {
        return self::$request;
    }

    private function autorize()
    {
        if(self::$request->getMethod() == self::POST && self::$request->get(Config::getRequestUserField())) {
            (new Autorize())->login(self::$request);
        }

        if(self::$request->getMethod() == self::POST && self::$request->get(self::LOGOUT)) {
            (new Autorize())->logout();
        }
    }
}