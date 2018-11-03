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
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;

class AppController extends BaseController
{
    const
        FIELD_PREFIX = 'field_';
    /**
     * @Route("app", name="app")
     * @return Response
     */
    public function app()
    {
        $appId = self::getRequest()->get(self::APP_ID);
        /** @var \Apps $app */
        $app = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->findBy(
            [\Users::ID => $appId]
        )[0];

        /** @var \Fields[] $fields */
//        $fields = Proxy::init()->getEntityManager()->getRepository(\Fields::class)->findAll();

        $fields = Proxy::init()->getEntityManager()->getRepository(\Fields::class)
            ->matching(
                Criteria::create()->where(
                    Criteria::expr()->eq('enabled', true)
                )->orderBy(
                    [ 'group' => Criteria::ASC, 'orderid'  => Criteria::ASC ]
                )
            )
            ->toArray();

//        usort($fields, array(__CLASS__, '_compareGroupSort'));


//        $query = 'select f.*, fg.name as gname, fg.type as gtype from fields as f left join field_groups fg on fg.id=f.group_id where f.enabled=1 order by fg.orderNum asc, f.orderid asc';
//        $fields = Proxy::init()->getConnecton()->query($query)->fetchAll();
        /*
                $qb = Proxy::init()->getEntityManager()->createQueryBuilder();
                $fields = $qb
                    ->select('f.id, fg.id')
                    ->from('fields', 'f')
                    ->leftJoin('fieldGroups', 'fg')
        //            ->setMaxResults(60)
                    ->getQuery()
        //            ->useQueryCache(false)
        //            ->useResultCache(false)
                    ->execute()
                    ;
        */
//        echo "<pre>";
//        var_dump($fields[25]);
//        echo "</pre>";
//        die;
        /** @var \FieldValues[] $fieldValues */
        $fieldValues = Proxy::init()->getEntityManager()->getRepository(\FieldValues::class)->matching(
            (new Builder())->fieldValuesByAppId($app)
        )->toArray();

//        var_dump($fieldValues[0]);die;
//        var_dump($fieldValues[0]->getField()->getName());die;
//        var_dump($fieldValues[0]->getField()->getDescription());die;
//        var_dump($fields[9]->getDescription());die;
//        var_dump($app->getUser()->getName());die;


        $data[\FieldGroups::class] = (new AppBuilder())->fieldValuesAll($fields, $fieldValues);
        $data[self::APP_ID] = $appId;
        $data[self::APP] = $app;
        return (new Render())->render($data, 'application.html.twig');
    }

    private static function _compareGroupSort(\Fields $a, \Fields  $b) {

        if ($a->getOrderid() == $b->getOrderid()) {
            return 0;
        }
        return ($a->getOrderid() < $b->getOrderid()) ? 1 : -1;
    }
}