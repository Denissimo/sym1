<?php

namespace App\Controller;

use App\Api\Config;

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
use App\Api\RequestAPI\RequestAPI;


class ApiController extends BaseController
{

    /**
     * @Route("api", name="api")
     * @return Response
     */
    public function api()
    {
        $appId = self::getRequest()->get(self::APP_ID);
//        $data['data'] = json_decode(Config::get('requestAPI.workingTime'), true);
        $res = true;
            var_dump(self::getRequest()->getRequestUri());


        try {
            $data = file_get_contents("php://input");
            Proxy::init()->getLogger()->addWarning(
                "\nINPUT:\r\n" . \GuzzleHttp\json_encode($data)
            );
            Proxy::init()->getLogger()->addWarning(
                "\nPOST:\r\n" . \GuzzleHttp\json_encode($_POST)
            );

            Proxy::init()->getLogger()->addWarning(
                "\nGET:\r\n" . \GuzzleHttp\json_encode($_GET)
            );
//            var_dump($_POST);die;
            new RequestAPI($data);
            $res = $data;
            $renderData['data'] = $res;
            return (new Render())->simpleRender($renderData, 'test.html.twig');

        } catch (\Exception $e) {
            Proxy::init()->getLogger()->addWarning(
                $e->getMessage()
            );
            $res = $e->getMessage();
            return (new Render())->simpleRender(['data' => $e->getMessage()], 'test.html.twig');
        }
//        $data['data'] = Config::get('requestAPI.workingTime');
    }

    /**
     * @Route("postlog", name="postlog")
     * @return Response
     */
    public function postlog()
    {
        Proxy::init()->getLogger()
            ->addWarning(\GuzzleHttp\json_encode(self::getRequest()->request->all()));
        return (new Render())->simpleRender([], 'test.html.twig');
    }
}