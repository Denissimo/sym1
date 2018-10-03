<?php

namespace App\Controller;

use App\Proxy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


abstract class BaseController extends Controller
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
        Proxy::init()->initValidator();
        Proxy::init()->initLogger();
    }

    /**
     * @return Request
     */
    public static function getRequest(): Request
    {
        return self::$request;
    }

}