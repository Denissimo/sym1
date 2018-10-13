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

class PostController extends BaseController
{
    /**
     * @Route("addcomment", name="addcomment")
     * @return RedirectResponse
     */
    public function addComment()
    {
//        var_dump(self::getRequest()->request); die;
//        var_dump(\DateTime::createFromFormat(
//                        'Y-m-d\TH:i',
//                        self::getRequest()->get('reminder')
//                    )
//        );die;
        Proxy::init()->getEntityManager()->persist(
            (new \Comments())
                ->setAppId(self::getRequest()->get(self::APP_ID))
                ->setComment(self::getRequest()->get('comment'))
                ->setUid(self::getRequest()->get('user_id'))
                ->setTs(new \DateTime())
                ->setReminder(
                    \DateTime::createFromFormat(
                        'Y-m-d\TH:i',
                        self::getRequest()->get('reminder')
                    )
                )
        );
        Proxy::init()->getEntityManager()->flush();
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );

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