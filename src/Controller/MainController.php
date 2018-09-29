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
use App\Controller\Query\Builder as Qb;


class MainController extends BaseController
{
    const
        CREATE_FROM = 'create_from',
        CREATE_TO = 'create_from',
        UPDATE_FROM = 'update_from',
        UPDATE_TO = 'update_to',
        USER_ID = 'userId',
        PER_PAGE = 'per_page';

    private $fields = [
        self::CREATE_FROM,
        self::CREATE_TO,
        self::UPDATE_FROM,
        self::UPDATE_TO,
        self::USER_ID
    ];

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
     * @Route("docs", name="docs")
     * @return Response
     */
    public function docs()
    {

        $data['login'] = self::getRequest()->get('_route');
        $data['number'] = 'docs';
        $data['post'] = self::getRequest()->getMethod();

        /** @var \Apps $apps */
        $apps = Proxy::init()->getEntityManager()->getRepository('Apps')->matching(
            (new Builder())->appsCommon(self::getRequest())
        )[0];

//        echo "<pre>";
//        var_dump((new Qb())->queryApps());
//        var_dump($apps->getUserId());
//        echo "<pre>";
//        die;


//        $param = array("id" => "1");
//        $urls = Proxy::init()->getEntityManager()->getRepository('Users')->findBy($param);
//        /** @var \Users $user */
//        $user = $urls[0];
//        echo "<pre>";
//        var_dump($user->getRole()->getKeys());
//        echo "<pre>";
//        die;

        try {
            (new Validator())->validateRequired(
                $data,
                ['numer'],
                'Mess 1'
            );
        } catch (DefaultException $e) {
            $data['number'] = $e->getMessage();
        }
        return (new Render())->render($data);
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
}