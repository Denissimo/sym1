<?php

namespace App\Controller\Criteria;

use Doctrine\Common\Collections\Criteria;
use App\Controller\MainController as Controller;
use Symfony\Component\HttpFoundation\Request;

class Builder
{



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
        foreach ($this->initExpressions($request) as $expression)
        {
            if($expression) {
                $criteria->andWhere($expression);
            }
        }

        $criteria->setMaxResults(50);

        return $criteria;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function initExpressions(Request $request) : array
    {
        return [
            Controller::CREATE_FROM =>
                $request->get(Controller::CREATE_FROM) ?
                    Criteria::expr()->gte(Controller::CREATE_FROM, $request->get(Controller::CREATE_FROM)) : null,
            Controller::CREATE_TO =>
                $request->get(Controller::CREATE_TO) ?
                    Criteria::expr()->gte(Controller::CREATE_TO, $request->get(Controller::CREATE_TO)) : null,
            Controller::UPDATE_FROM =>
                $request->get(Controller::UPDATE_FROM) ?
                    Criteria::expr()->gte(Controller::UPDATE_FROM, $request->get(Controller::UPDATE_FROM)) : null,
            Controller::UPDATE_TO =>
                $request->get(Controller::UPDATE_TO) ?
                    Criteria::expr()->lte(Controller::UPDATE_TO, $request->get(Controller::UPDATE_TO)) : null,
            Controller::USER_ID =>
                $request->get(Controller::USER_ID) ?
                    Criteria::expr()->eq(Controller::USER_ID, $request->get(Controller::USER_ID)) : null,
        ];
        
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