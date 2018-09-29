<?php

namespace App\Controller\Query;

use App\Controller\MainController as Controller;
use Doctrine\ORM\Query\Exec;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use App\Proxy;


class Builder
{


    public function queryApps()
    {
        return Proxy::init()->getEntityManager()->createQueryBuilder()
            ->select('*')
            ->from('Apps', 'a')
            ->where('userId=9')
            ->setMaxResults(50)->getQuery()->getSQL();
    }
}