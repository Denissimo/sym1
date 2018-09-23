<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;

class LuckyController extends BaseController
{
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
    public function number()
    {
//        Proxy::init()->getSession()->set('aza', 'sdfd4444444444');
//        var_dump(Proxy::init()->getSession()->get('aza'));
        $param = array("id" => "60002");
        var_dump(Proxy::init()->getEntityManager()->getRepository('Users')->findAll());
        $data['number'] = random_int(0, 100);

        return new Response(
            Proxy::init()->getTwigEnvironment()->render(
                'white1.html.twig',
                $data
            )
        );
    }
}