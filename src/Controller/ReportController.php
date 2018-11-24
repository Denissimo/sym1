<?php

namespace App\Controller;

use App\Api\Config;

use App\Exceptions\DefaultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Proxy;
use App\Twig\Render;
use App\Api\RequestAPI\RequestAPI;
use App\Api\Slovo\Api4s;


class ReportController extends BaseController
{

    /**
     * @Route("report", name="report")
     * @return Response
     */
    public function report()
    {

        Proxy::init()->getConnecton()->query();

        return (new Render())->simpleRender(['data' => $e->getMessage()], 'test.html.twig');
    }

}