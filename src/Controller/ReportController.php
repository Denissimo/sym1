<?php

namespace App\Controller;

use App\Api\Config;

use App\Exceptions\DefaultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Proxy;
use App\Twig\Render;
use Doctrine\Common\Collections\Criteria;
use App\Api\RequestAPI\RequestAPI;
use App\Api\Slovo\Api4s;


class ReportController extends BaseController
{
    const
        DAYS = 'P380D',
        MAX = 1000
    ;

    /**
     * @Route("report", name="report")
     * @return Response
     */
    public function report()
    {

//        $query = 'SELECT * FROM apps a LEFT JOIN users u ON a.user_id = u.id WHERE DATE(a.createdAt) > (CURDATE() - '.self::DAYS.')';
//        $data['report'] = Proxy::init()->getConnecton()->query($query)->fetchAll();
        $criteria = Criteria::create();
        $data = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
            $criteria->where(
                Criteria::expr()->gte('createdat', (new \DateTime())->sub(new \DateInterval(self::DAYS))
                )
            )
            ->orderBy(['id' => Criteria::DESC])
            ->setMaxResults(self::MAX)
        )->toArray();
//        var_dump($data);

        return (new Render())->simpleRender(['data' => $data], 'report.html.twig');
    }

}