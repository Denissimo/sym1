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
     * @Route("api4s", name="api4s")
     * @param Request $request
     */
    public function api4s(Request $request)
    {
        (new Api4s())->dataSend($request);
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