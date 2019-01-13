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
use App\Controller\Criteria\Builder;


class ReportController extends BaseController
{
    const
        TPL_DATE_TIME = 'd.m.Y',
        QTY = 'qty',
        LABEL = 'label',
        ID = 'stat_id',
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
        $data['request'] = self::getRequest()->query->all();
        $data['partnerStat'] = $this->partnerStat('p', 'title');
        $data['userStat'] = $this->partnerStat('u', 'name');
        $data['statList'] = [
            self::ALL => [self::LABEL => self::ALL, \AppStatus::PICTURE => 'Все&nbsp;<img src="/images/color_labels/color_all.png" class="color_label">'],
            self::NEW => [self::LABEL => self::NEW, \AppStatus::PICTURE => 'Новые&nbsp;<img src="/images/color_labels/color_white.png" class="color_label">'],
            \Apps::IN_WORK => [self::LABEL => \Apps::IN_WORK, \AppStatus::PICTURE => 'В&nbsp;работе&nbsp;<img src="/images/color_labels/color_cyan.png" class="color_label">'],
            self::READY => [self::LABEL => self::READY, \AppStatus::PICTURE => 'Готовые&nbsp;<img src="/images/color_labels/color_green.png" class="color_label">'],
            \Apps::TRASH => [self::LABEL => \Apps::TRASH, \AppStatus::PICTURE => 'Корзина&nbsp;<div class="emoji emoji1f4a9" style="margin: 0 0 8px 0;"></div>'],
        ];

        return (new Render())->render($data, 'statreport.html.twig');
    }

    /**
     * @param string $tableAlias
     * @param string $field
     * @return array
     */
    private function partnerStat(string $tableAlias, string $field)
    {
        $query = 'SELECT ' . $tableAlias . '.id AS ' . self::ID . ', ' . $tableAlias . '.' . $field . ' AS ' . self::NAME .
            ', a.in_work, a.status, `as`.picture, a.trash,
COUNT(a.id) AS qty FROM 
  (SELECT * FROM apps ' . $this->buildPeriod() . ') a 
LEFT JOIN partners p ON a.partner_id = p.id
LEFT JOIN app_status `as` ON a.status=`as`.id 
LEFT JOIN users u ON a.user_id = u.id
GROUP BY ' . self::ID . ', a.status, a.in_work, a.trash';
//var_dump($query); die;
        $statReport = Proxy::init()->getConnecton()->query($query)->fetchAll();
        $statTable = [];
        $summ[\Apps::TRASH][self::QTY] = 0;
        $summ[\Apps::IN_WORK][self::QTY] = 0;
        $summ[self::READY][self::QTY] = 0;
        $summ[self::NEW][self::QTY] = 0;
        $summ[self::ALL][self::QTY] = 0;
        foreach ($statReport as $stat) {
            $status = $stat[\Apps::STATUS];
            $id = $stat[self::ID];
            $name = $this->buildShortName($stat[self::NAME]);
            $trash = $stat[\Apps::TRASH];
            $inWork = $stat[\Apps::IN_WORK];
            $qty = $stat[self::QTY];
            //При более простом синтаксисе - notice
            $statTable[$id][\Apps::TRASH][self::QTY] = $statTable[$id][\Apps::TRASH][self::QTY] ?? 0;
            $statTable[$id][\Apps::IN_WORK][self::QTY] = $statTable[$id][\Apps::IN_WORK][self::QTY] ?? 0;
            $statTable[$id][self::READY][self::QTY] = $statTable[$id][$status][self::QTY] ?? 0;
            $statTable[$id][self::NEW][self::QTY] = $statTable[$id][self::NEW][self::QTY] ?? 0;
            $statTable[$id][self::ALL][self::QTY] = $statTable[$id][self::ALL][self::QTY] ?? 0;
            $statTable[$id][\Apps::TRASH][self::NAME] = $name;
            $statTable[$id][\Apps::IN_WORK][self::NAME] = $name;
            $statTable[$id][self::READY][self::NAME] = $name;
            $statTable[$id][self::NEW][self::NAME] = $name;
            $statTable[$id][self::ALL][self::NAME] = $name;
            $summ[\Apps::TRASH][self::NAME] = $summ[self::NEW][self::NAME] = $summ[self::READY][self::NAME] =
            $summ[\Apps::IN_WORK][self::NAME] = $summ[self::ALL][self::NAME] = self::SUMM_LABEL;
            if ($trash) {
                $statTable[$id][\Apps::TRASH][self::QTY] += $qty;
                $summ[\Apps::TRASH][self::QTY] += $qty;
            } elseif (!$inWork) {
                $statTable[$id][self::NEW][self::QTY] += $qty;
                $summ[self::NEW][self::QTY] += $qty;
            } elseif ($status == \AppStatus::GREEN) {
                $statTable[$id][self::READY][self::QTY] += $qty;
                $summ[self::READY][self::QTY] += $qty;
            } else {
                $statTable[$id][\Apps::IN_WORK][self::QTY] += $qty;
                $summ[\Apps::IN_WORK][self::QTY] += $qty;
            }
            $statTable[$id][self::ALL][self::QTY] += $qty;
            $summ[self::ALL][self::QTY] += $qty;
        }
        $statTable[self::SUMM] = $summ;
        return $statTable;
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
            self::CREATE_AT . '>= "' . $this->buildDate($fields[self::CREATE_FROM]) . Builder::TIME_ZERO .'"' : null;
        $fields[self::CREATE_TO] ? $andFields[] =
            self::CREATE_AT . '<= "' . $this->buildDate($fields[self::CREATE_TO]) . Builder::TIME_NIGHT .'"' : null;
        $fields[self::UPDATE_FROM] ? $andFields[] =
            self::UPDATE_AT . '>= "' . $this->buildDate($fields[self::UPDATE_FROM]) . Builder::TIME_ZERO .'"' : null;
        $fields[self::UPDATE_TO] ? $andFields[] =
            self::UPDATE_AT . '<= "' . $this->buildDate($fields[self::UPDATE_TO]) . Builder::TIME_NIGHT .'"' : null;

        $glued = implode(self:: AND, $andFields);

        return $glued ? ' WHERE ' . $glued : null;
    }

    /**
     * @param string $date
     * @return string
     */
    private function buildDate(string $date): string
    {
        return  \DateTime::createFromFormat(self::TPL_DATE_TIME, $date)->format('Y-m-d');
    }

    /**
     * @param string $name
     * @return string
     */
    private function buildShortName(string $name)
    {
        $nameArray = explode(' ', $name);
        $lastName = $nameArray[0] . ' ' ?? $name;
        $firstName = isset($nameArray[1]) ? mb_substr($nameArray[1], 0, 1) . '. ' : null;
        $middleName = isset($nameArray[2]) ? mb_substr($nameArray[2], 0, 1) . '. ' : null;

        return $lastName . $firstName . $middleName;
    }
}