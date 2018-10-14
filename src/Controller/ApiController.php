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



        try {
            $data = file_get_contents("php://input");
            Proxy::init()->getLogger()->addWarning(
                "\r\nINPUT:\r\n" . \GuzzleHttp\json_encode($data)
            );
            Proxy::init()->getLogger()->addWarning(
                "\r\nPOST:\r\n" . \GuzzleHttp\json_encode($_POST)
            );

            Proxy::init()->getLogger()->addWarning(
                "\r\nGET:\r\n" . \GuzzleHttp\json_encode($_POST)
            );
//            var_dump($_POST);die;
            new RequestAPI($data);
            $res = $data;
            $data['data'] = $res;
            return (new Render())->render($data, 'test.html.twig');

        } catch (\Exception $e) {
            Proxy::init()->getLogger()->addWarning(
                $e->getMessage()
            );
            $res = $e->getMessage();
            return (new Render())->render(['data' => $e->getMessage()], 'test.html.twig');
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
            ->addWarning(\GuzzleHttp\json_encode(self::getRequest()->request));
        return (new Render())->render([], 'test.html.twig');
    }
}