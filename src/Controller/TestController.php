<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Controller\Forms\FormBuilder;
use Users;
use App\Twig\Render;

class TestController extends BaseController
{
     /**
      * @Route("/test")
      */
    public function test()
    {

        Proxy::init()->initDoctrine();


        /** @var \Users[] $user */
        $user = Proxy::init()->getEntityManager()
            ->getRepository(\Users::class)
            ->findBy(['name' => 'Den Drake']);

//        var_dump($user); die;
//        $user[0]->setName('ZZdddzz');
//        Proxy::init()->getEntityManager()->flush();

        /*
        $newUser = (new Users())
            ->setName('sdfgag')
            ->setEmail('ss@xhx.xx')
            ->setPassword('kjhgfkjfkfku')
            ->setEnabled(true)
        ;
        */

//        Proxy::init()->getEntityManager()->persist($newUser);
//        Proxy::init()->getEntityManager()->flush();
        $data['data'] = 'zdf';
        $data['form'] = (new FormBuilder())->buildForm()->createView();
        return (new Render())->render($data, 'test.html.twig');
    }
}