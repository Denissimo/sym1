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
        $app = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->findBy(
            [\Users::ID => $appId]
        )[0];

            /** @var \Fields[] $fields */
        $fields = Proxy::init()->getEntityManager()->getRepository(\Fields::class)->findAll();

        /** @var \FieldValues[] $fieldValues */
        $fieldValues = Proxy::init()->getEntityManager()->getRepository(\FieldValues::class)->matching(
            (new Builder())->fieldValuesByAppId($app)
        )->toArray();

//        var_dump($fieldValues[1]->getValue());die;
//        var_dump($fieldValues[0]->getField()->getName());die;
//        var_dump($fieldValues[0]->getField()->getDescription());die;
//        var_dump($fields[9]->getDescription());die;
//        var_dump($app->getUser()->getName());die;


        $data[self::FIELD_VALUES] = $fieldValues;
        $data[self::APP_ID] = $appId;
        $data[self::APP] = $app;
        return (new Render())->render($data, 'application.html.twig');
    }
}