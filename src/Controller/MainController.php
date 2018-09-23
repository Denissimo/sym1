<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
//use GuzzleHttp\Psr7\Request;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Actions\Autorize;


class MainController extends BaseController
{
    /**
     * @var \Apps
     */
    private $unit;
    /**
     * LuckyController constructor.
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @Route("/", name="blog_list")
     */
    public function run()
    {
        $login = (new Autorize())->login(self::getRequest());
//        var_dump($login);
        $data['number'] = random_int(0, 100);
        return new Response(
            Proxy::init()->getTwigEnvironment()->render(
                'white1.html.twig',
                $data
            )
        );
    }
}