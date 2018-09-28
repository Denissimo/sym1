<?php

namespace App\Controller\Criteria;

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;

class Builder
{

    const
        CREATE_FROM = 'created_from',
        CREATE_TO = 'created_from',
        UPDATE_FROM = 'updated_from',
        UPDATE_TO = 'updated_to',
        USER_ID = 'user_id',
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

    public function appsCommon(Request $request): Criteria
    {
        $criteria = Criteria::create();
        $criteria->where(
            Criteria::expr()->eq('in_work', 1)
        );

        //$criteria = $this->addWhere($criteria, $request);
        foreach ($this->initExpressions($request) as $expression)
        {
            if($expression) {
                $criteria->andWhere($expression);
            }
        }

        return $criteria;
    }

    private function initExpressions(Request $request) : array
    {
        return [
            self::CREATE_FROM => 
                $request->get(self::CREATE_FROM) ? 
                    Criteria::expr()->gte(self::CREATE_FROM, $request->get(self::CREATE_FROM)) : null,
            self::CREATE_TO =>
                $request->get(self::CREATE_TO) ?
                    Criteria::expr()->gte(self::CREATE_TO, $request->get(self::CREATE_TO)) : null,
            self::UPDATE_FROM =>
                $request->get(self::UPDATE_FROM) ?
                    Criteria::expr()->gte(self::UPDATE_FROM, $request->get(self::UPDATE_FROM)) : null,
            self::UPDATE_TO =>
                $request->get(self::UPDATE_TO) ?
                    Criteria::expr()->lte(self::UPDATE_TO, $request->get(self::UPDATE_TO)) : null,
            self::USER_ID =>
                $request->get(self::USER_ID) ?
                    Criteria::expr()->eq(self::USER_ID, $request->get(self::USER_ID)) : null,
        ];
        
    }

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
}