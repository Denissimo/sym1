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


class MainController extends BaseController
{


    private $gte = [
        self::CREATE_FROM,
        self::UPDATE_FROM,
    ];

    private $lte = [
        self::CREATE_TO,
        self::UPDATE_TO,
    ];

    private $eq = [
        self::USER_ID,
    ];
    /**
     * @var \Apps
     */
    private $unit;

    private $s;

    /**
     * LuckyController constructor.
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @Route("/", name="main")
     * @return Response
     */
    public function main()
    {
        $data['login'] = self::getRequest()->headers->get('referer');
        $data['number'] = random_int(0, 100);
        $data['post'] = self::getRequest()->getMethod();
        return (new Render())->render($data);
    }


    /**
     * @Route("apps", name="apps")
     * @return Response
     */
    public function apps()
    {

        $data['login'] = self::getRequest()->get('_route');
        $data['number'] = 'docs';
        $data['request'] = self::getRequest()->query->all();
        $data['post'] = self::getRequest()->getMethod();

//        /** @var \Apps $apps */
//        $apps = Proxy::init()->getEntityManager()->getRepository('Apps')->matching(
//            (new Builder())->appsCommon(self::getRequest())
//        )->getValues();

        $apps = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
            (new Builder())->appsCommon(self::getRequest())
        );
/*
        $appsArray = (new AppBuilder())->getArrayById($apps);
        $ids = array_keys($appsArray);

        $comments = Proxy::init()->getEntityManager()->getRepository(\Comments::class)->matching(
            (new Builder())->commentsCommon($ids)
        )->toArray();

        $data['comments'] = $comments;
*/
        $data['apps'] = $apps->toArray();

        /** @var \Comments $comment */
//        $comment = $comments->toArray()[0];
        //var_dump($comment->getApp()); die;

//        $commetsArray = (new AppBuilder())->getArrayByAppId($comments);
//        var_dump((new AppBuilder())->getArrayById($apps));


//        echo "<pre>";
//        try {
//            var_dump((new Qb())->queryApps());
//        } catch (\Exception $e) {
//            var_dump($e->getMessage());
//        }
//        var_dump($apps->getUserId());
//        echo "<pre>";
//        die;


//        $param = array("id" => "1");
//        $urls = Proxy::init()->getEntityManager()->getRepository('Users')->findBy($param);
        /** @var \Users $user */
//        $user = $urls[0];
//        echo "<pre>";
//        var_dump($user->getRole()->getKeys());
//        var_dump($this->s);
//        var_dump(get_class($apps));

//        /** @var \Apps $app */
//        $app = $apps->toArray()[0];

        /** @var \Comments $comment */
//        $comment = $comments->toArray()[0];
//        var_dump(($comment));
//        echo "<pre>";
//        var_dump($app->getComments()[0]->getId());
//        echo "</pre>";
//        die;
//        Proxy::init()->getLogger()->addWarning(
//            \GuzzleHttp\json_encode(
//                $app->getUser()->getName()
//            )
//        );

        return (new Render())->render($data, 'appstable.html.twig');
    }

    /**
     * @Route("autorize", name="autorize")
     * @return RedirectResponse
     */
    public function autorize()
    {
        (new Autorize())->autorize(self::getRequest());
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );

    }

    /**
     * @Route("addcomment", name="addcomment")
     * @return RedirectResponse
     */
    public function addComment()
    {
//        (new Autorize())->autorize(self::getRequest());
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );

    }
}