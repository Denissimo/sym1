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
        QTY = 'qty',
        NAME = 'name',
        DAYS = 'P380D',
        MAX = 1000;

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

    /**
     * @Route("statreport", name="statreport")
     * @return Response
     */
    public function statReport()
    {

        $query = 'SELECT p.id AS pid, p.title, a.status, `as`.picture, a.trash,
COUNT(a.id) AS qty FROM apps a LEFT JOIN partners p ON a.partner_id = p.id
LEFT JOIN app_status `as` ON a.status=`as`.id GROUP BY p.title, a.status, a.trash';
        $statReport = Proxy::init()->getConnecton()->query($query)->fetchAll();
        $statTable = [];
        $statList[\Apps::TRASH][self::NAME] = \Apps::TRASH;
        $statList[\Apps::TRASH][\AppStatus::PICTURE] = '<p class="emoji emoji1f4a9" style="margin: 0 0 0 0;"></p>';
        foreach ($statReport as $stat) {
            $status = $stat[\Apps::STATUS];
            $pid = $stat[\Partners::PID];
            $title = $stat[\Partners::TITLE];
            $trash = $stat[\Apps::TRASH];
            $picture = $stat[\AppStatus::PICTURE];
            $qty = $stat[self::QTY];
            //При более простом синтаксисе - notice
            $statTable[$pid][\Apps::TRASH][self::QTY] = $statTable[$pid][\Apps::TRASH][self::QTY] ?? 0;
            $statTable[$pid][$status][self::QTY] = $statTable[$pid][$status][self::QTY] ?? 0;
            $statTable[$pid][\Apps::TRASH][\Partners::TITLE] = $title;
            $statTable[$pid][$status][\Partners::TITLE] = $title;
            $statList[$status][self::NAME] = $status;
            $statList[$status][\AppStatus::PICTURE] = '<img src="/images/color_labels/' . $picture . '" class="color_label">';
            if ($trash) {
                $statTable[$pid][\Apps::TRASH][self::QTY] += $qty;
            } else {
                $statTable[$pid][$status][self::QTY] += $qty;
            }

        }

//        echo "<pre>";
//        var_dump($statTable);

        $data['statTable'] = $statTable;
        $data['statList'] = $statList;

        return (new Render())->render($data, 'statreport.html.twig');
    }

}