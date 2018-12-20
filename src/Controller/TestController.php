<?php

namespace App\Controller;

use Doctrine\ORM\Mapping\EntityResult;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Controller\Forms\FormBuilder;
use Users;
use App\Twig\Render;
use App\Controller\Query;

class TestController extends BaseController
{

    /**
     * @Route("/sql")
     */
    public function sql()
    {
        $qb = Proxy::init()->getEntityManager()->createQueryBuilder();
        $res =  $qb
            ->select('a.id', 'a.userId')
            ->from(\Apps::class, 'a')
//            ->where('a.userId=9')
            ->setMaxResults(50)->getQuery()
            ->execute()
            ;
        var_dump($res); die;
        $data['data'] = \GuzzleHttp\json_encode($res);
        return (new Render())->render($data, 'test.html.twig');
    }

    /**
     * @Route("/sql2")
     */
    public function sql2()
    {
        $qb = Proxy::init()->getEntityManager()->createQueryBuilder();
        $res = $qb->select('u')
            ->from(\Users::class, 'u')
            ->groupBy('u.id')
            ->getQuery()
            ->execute()
        ;
        var_dump($res); die;
        $data['data'] = \GuzzleHttp\json_encode($res);
        return (new Render())->render($data, 'test.html.twig');
    }
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