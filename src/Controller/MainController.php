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
use App\Validator\Validator;


class MainController extends BaseController
{
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
        try{
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