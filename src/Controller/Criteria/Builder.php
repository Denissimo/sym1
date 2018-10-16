<?php

namespace App\Controller\Criteria;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\Expr\Comparison;
use App\Controller\MainController as Controller;
use Symfony\Component\HttpFoundation\Request;


class Builder
{

    private $orderFields = [
        'id1' => ['id' => 'ASC'],
        'id2' => ['id' => 'DESC'],
        'createdAt1' => ['createdat' => 'ASC'],
        'createdAt2' => ['createdat' => 'DESC'],
        'updatedAt1' => ['updatedat' => 'ASC'],
        'updatedAt2' => ['updatedat' => 'DESC'],
    ];

    /**
     * @param Request $request
     * @return Criteria
     */
    public function appsCommon(Request $request): Criteria
    {
        $criteria = Criteria::create();
        $criteria->where(
            Criteria::expr()->eq('inWork', 1)
        );

        //$criteria = $this->addWhere($criteria, $request);
//        var_dump(\DateTime::createFromFormat('Ymd', '20180104')); die;
//        echo "<pre>";var_dump($this->initExpressions($request)); echo "</pre>"; die;
        foreach ($this->initExpressions($request) as $expression) {
            if ($expression) {
                $criteria->andWhere($expression);
            }
        }
/*
        $criteria->andWhere(
            Criteria::expr()->gte(
                'createdat',
                \DateTime::createFromFormat('Ymdhis', '20180103055050')
            )
        );
*/
        $criteria->orderBy(
            $this->orderFields[$request->get(Controller::SORT)] ?? ['id' => 'DESC']);

        $criteria->setMaxResults((int)$request->get(Controller::LIMIT) ?? Controller::DEFAULT_LIMIT);

        return $criteria;
    }

    /**
     * @param array $ids
     * @return Criteria
     */
    public function commentsCommon(array $ids): Criteria
    {
        $criteria = Criteria::create();
        $criteria->where(
            Criteria::expr()->in('appId', $ids)
        );
        return $criteria;
    }

    /**
     * @param \Apps $id
     * @return Criteria
     */
    public function fieldValuesByAppId(\Apps $id): Criteria
    {
        $criteria = Criteria::create();
        $criteria->where(
            Criteria::expr()->eq('app', $id)
        )->orderBy(
            ['field' => Criteria::ASC]
        );
        return $criteria;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function initExpressions(Request $request): array
    {
        return [
            Controller::CREATE_AT => $this->buildPeriod($request, Controller::CREATE_AT),
            Controller::UPDATE_AT => $this->buildPeriod($request, Controller::UPDATE_AT),
            Controller::USER_ID =>
                $request->get(Controller::USER_ID) ?
                    Criteria::expr()->eq(Controller::USER_ID, $request->get(Controller::USER_ID)) : null,
        ];

    }

    /**
     * @param Request $request
     * @param string $field
     * @return CompositeExpression | Comparison | null
     */
    private function buildPeriod(Request $request, string $field)
    {
        $from = $request->get(Controller::$fields[$field][Controller::FROM]);
        $to = $request->get(Controller::$fields[$field][Controller::TO]);
//        var_dump(Controller::$fields[$field]);
        if ($from && $to) {
//            var_dump($from); var_dump($to);die;
            return Criteria::expr()->andX(
                Criteria::expr()->gte(
                    $field,
                    \DateTime::createFromFormat('YmdHis', $from)
                ),
                Criteria::expr()->lte(
                    $field,
                    \DateTime::createFromFormat('YmdHis', $to)
                )
            );
        } elseif ($from) {
            return Criteria::expr()->gte(
                $field,
                \DateTime::createFromFormat('YmdHis', $from)
            );
        } elseif ($to) {
            return Criteria::expr()->lte(
                $field,
                \DateTime::createFromFormat('YmdHis', $to)
            );
        } else {
            return null;
        }
    }


    /*
        private function addWhere(Criteria $criteria, Request $request) : Criteria
        {
            foreach ($this->gte as $field) {
                if($request->get($field)) {
                    $criteria->andWhere(
                        Criteria::expr()->gte($field, $request->get($field))
                    );
                }
            }

            foreach ($this->lte as $field) {
                if($request->get($field)) {
                    $criteria->andWhere(
                        Criteria::expr()->lte($field, $request->get($field))
                    );
                }
            }

            foreach ($this->eq as $field) {
                if($request->get($field)) {
                    $criteria->andWhere(
                        Criteria::expr()->eq($field, $request->get($field))
                    );
                }
            }
            return $criteria;
        }
    */
}