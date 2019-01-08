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
use App\Controller\MainController as Controller;


class ReportController extends BaseController
{
    const
        TPL_DATE_TIME = 'd.m.Y',
        QTY = 'qty',
        NAME = 'name',
        NEW = 'new',
        ALL = 'all',
        SUMM = 'summ',
        SUMM_LABEL = 'Итого',
        READY = 'ready',
        DAYS = 'P380D',
        AND = ' AND ',
        MAX = 1000;

    /**
     * @Route("report", name="report")
     * @return Response
     */
    public function report()
    {
        $criteria = Criteria::create();
        $data = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
            $criteria->where(
                Criteria::expr()->gte('createdat', (new \DateTime())->sub(new \DateInterval(self::DAYS))
                )
            )
                ->orderBy(['id' => Criteria::DESC])
                ->setMaxResults(self::MAX)
        )->toArray();

        return (new Render())->simpleRender(['data' => $data], 'report.html.twig');
    }

    /**
     * @Route("statreport", name="statreport")
     * @return Response
     */
    public function statReport()
    {
        $query = 'SELECT p.id AS pid, p.title, a.in_work, a.status, `as`.picture, a.trash,
COUNT(a.id) AS qty FROM 
  (SELECT * FROM apps ' . $this->buildPeriod() . ') a 
LEFT JOIN partners p ON a.partner_id = p.id
LEFT JOIN app_status `as` ON a.status=`as`.id GROUP BY p.title, a.status, a.in_work, a.trash';
        $statReport = Proxy::init()->getConnecton()->query($query)->fetchAll();
        $statTable = [];
        $summ[\Apps::TRASH][self::QTY] = 0;
        $summ[\Apps::IN_WORK][self::QTY] = 0;
        $summ[self::READY][self::QTY] = 0;
        $summ[self::NEW][self::QTY] = 0;
        $summ[self::ALL][self::QTY] = 0;
        foreach ($statReport as $stat) {
            $status = $stat[\Apps::STATUS];
            $pid = $stat[\Partners::PID];
            $title = $stat[\Partners::TITLE];
            $trash = $stat[\Apps::TRASH];
            $inWork = $stat[\Apps::IN_WORK];
            $qty = $stat[self::QTY];
            //При более простом синтаксисе - notice
            $statTable[$pid][\Apps::TRASH][self::QTY] = $statTable[$pid][\Apps::TRASH][self::QTY] ?? 0;
            $statTable[$pid][\Apps::IN_WORK][self::QTY] = $statTable[$pid][\Apps::IN_WORK][self::QTY] ?? 0;
            $statTable[$pid][self::READY][self::QTY] = $statTable[$pid][$status][self::QTY] ?? 0;
            $statTable[$pid][self::NEW][self::QTY] = $statTable[$pid][self::NEW][self::QTY] ?? 0;
            $statTable[$pid][self::ALL][self::QTY] = $statTable[$pid][self::ALL][self::QTY] ?? 0;
            $statTable[$pid][\Apps::TRASH][\Partners::TITLE] = $title;
            $statTable[$pid][\Apps::IN_WORK][\Partners::TITLE] = $title;
            $statTable[$pid][self::READY][\Partners::TITLE] = $title;
            $statTable[$pid][self::NEW][\Partners::TITLE] = $title;
            $statTable[$pid][self::ALL][\Partners::TITLE] = $title;
            if ($trash) {
                $statTable[$pid][\Apps::TRASH][self::QTY] += $qty;
                $summ[\Apps::TRASH][self::QTY] += $qty;
                $summ[\Apps::TRASH][\Partners::TITLE] = self::SUMM_LABEL;
            } elseif (!$inWork) {
                $statTable[$pid][self::NEW][self::QTY] += $qty;
                $summ[self::NEW][self::QTY] += $qty;
                $summ[self::NEW][\Partners::TITLE] = self::SUMM_LABEL;
            } elseif ($status == \AppStatus::GREEN) {
                $statTable[$pid][self::READY][self::QTY] += $qty;
                $summ[self::READY][self::QTY] += $qty;
                $summ[self::READY][\Partners::TITLE] = self::SUMM_LABEL;
            } else {
                $statTable[$pid][\Apps::IN_WORK][self::QTY] += $qty;
                $summ[\Apps::IN_WORK][self::QTY] += $qty;
                $summ[\Apps::IN_WORK][\Partners::TITLE] = self::SUMM_LABEL;
            }
            $statTable[$pid][self::ALL][self::QTY] += $qty;
            $summ[self::ALL][self::QTY] += $qty;
            $summ[self::ALL][\Partners::TITLE] = self::SUMM_LABEL;
        }
        $statTable[self::SUMM] = $summ;

        $data['request'] = self::getRequest()->query->all();
        $data['statTable'] = $statTable;
        $data['statList'] = [
            self::ALL => [self::NAME => self::ALL, \AppStatus::PICTURE => 'Все&nbsp;<img src="/images/color_labels/color_all.png" class="color_label">'],
            self::NEW => [self::NAME => self::NEW, \AppStatus::PICTURE => 'Новые&nbsp;<img src="/images/color_labels/color_white.png" class="color_label">'],
            \Apps::IN_WORK => [self::NAME => \Apps::IN_WORK, \AppStatus::PICTURE => 'В&nbsp;работе&nbsp;<img src="/images/color_labels/color_cyan.png" class="color_label">'],
            self::READY => [self::NAME => self::READY, \AppStatus::PICTURE => 'Готовые&nbsp;<img src="/images/color_labels/color_green.png" class="color_label">'],
            \Apps::TRASH => [self::NAME => \Apps::TRASH, \AppStatus::PICTURE => 'Корзина&nbsp;<div class="emoji emoji1f4a9" style="margin: 0 0 8px 0;"></div>'],
        ];

        return (new Render())->render($data, 'statreport.html.twig');
    }

    /**
     * @return string|null
     */
    private function buildPeriod()
    {
        $fields = [
            self::CREATE_FROM => self::getRequest()->get(self::CREATE_FROM),
            self::CREATE_TO => self::getRequest()->get(self::CREATE_TO),
            self::UPDATE_FROM => self::getRequest()->get(self::UPDATE_FROM),
            self::UPDATE_TO => self::getRequest()->get(self::UPDATE_TO),
        ];

        $andFields = [];
        $fields[self::CREATE_FROM] ? $andFields[] =
            self::CREATE_AT . '>=' . $this->buildDate($fields[self::CREATE_FROM]) : null;
        $fields[self::CREATE_TO] ? $andFields[] =
            self::CREATE_AT . '<=' . $this->buildDate($fields[self::CREATE_TO]) : null;
        $fields[self::UPDATE_FROM] ? $andFields[] =
            self::UPDATE_AT . '>=' . $this->buildDate($fields[self::UPDATE_FROM]) : null;
        $fields[self::UPDATE_TO] ? $andFields[] =
            self::UPDATE_AT . '<=' . $this->buildDate($fields[self::UPDATE_TO]) : null;

        $glued = implode(self:: AND, $andFields);

        return $glued ? ' WHERE ' . $glued : null;
    }

    /**
     * @param string $date
     * @return string
     */
    private function buildDate(string $date): string
    {
        return 'DATE("' . \DateTime::createFromFormat(self::TPL_DATE_TIME, $date)->format('Y-m-d') . '")';
    }
}