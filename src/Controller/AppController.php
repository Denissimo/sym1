<?php

namespace App\Controller;

use App\Exceptions\DefaultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Actions\Autorize;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Twig\Render;
use App\Validator;
use App\Controller\Criteria\Builder;
use App\Controller\Apps\Builder as AppBuilder;
use App\Controller\Query\Builder as Qb;
use Monolog\Logger;

class AppController extends BaseController
{
    /**
     * @Route("app", name="app")
     * @return Response
     */
    public function app()
    {
        $appId = self::getRequest()->get(self::APP_ID);
        /** @var \Apps $app */
        $app = (array)Proxy::init()->getEntityManager()->getRepository(\Apps::class)->findBy(
            [self::ID => $appId]
        )[0];

        $fieldValues = Proxy::init()->getEntityManager()->getRepository(\FieldValues::class)->matching(
            (new Builder())->fieldValuesByAppId($appId)
        );
//        var_dump($fieldValues);die;
//        $data[self::APP] =

        $data[self::APP_ID] = $appId;
        $data[self::APP] = $app;
        return (new Render())->render($data, 'application.html.twig');
    }
}