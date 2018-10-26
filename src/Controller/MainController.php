<?php

namespace App\Controller;

use App\Exceptions\DefaultException;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Actions\Autorize;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Twig\Render;
use App\Cfg\Config;
use App\Validator;
use App\Controller\Criteria\Builder;
use Doctrine\Common\Collections\Criteria;
use App\Controller\Apps\Builder as AppBuilder;
use App\Controller\Query\Builder as Qb;
use App\Params\Params;
use Monolog\Logger;


class MainController extends BaseController
{

    /**
     * @var \Apps
     */
    private $unit;

    private $s;

    /**
     * LuckyController constructor.
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @Route("/", name="main")
     * @return Response
     */
    public function main()
    {
        $data['login'] = self::getRequest()->headers->get('referer');
        $data['number'] = random_int(0, 100);
        $data['post'] = self::getRequest()->getMethod();
        return (new Render())->render($data);
    }


    /**
     * @Route("apps", name="apps")
     * @return Response
     */
    public function apps()
    {

        $data['login'] = self::getRequest()->get('_route');
        $data['number'] = 'docs';
        $data['request'] = self::getRequest()->query->all();
        $data['post'] = self::getRequest()->getMethod();
        $data['uid'] = (new Autorize())->getUserId();

//        $params = (new Params())->get('distribution');
//        var_dump($params); die;

//        /** @var \Apps $apps */
//        $apps = Proxy::init()->getEntityManager()->getRepository('Apps')->matching(
//            (new Builder())->appsCommon(self::getRequest())
//        )->getValues();


        $criteria = (new Builder())->appsCommon(self::getRequest());
        //$criteria->andWhere(Criteria::expr()->eq('status', 2));
        /** @var \Apps[] $allApps */
        $allApps = [];
        $apps = [];
        $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
            (new Builder())->appsCommon(self::getRequest())
                ->andWhere(Criteria::expr()->eq(\Apps::STATUS, \AppStatus::RED))
                ->andWhere(Criteria::expr()->lt(
                    \Apps::UPDATED,
                    (new \DateTime())
                ))
        )->toArray();
        /** @var \Apps $app */
//        $app = $apps[0][0];
        /** @var Collection $fv */
//        $fv = $app->getFieldValues();
        /** @var \FieldValues $f1 */
//        $f1 = $fv->toArray()[0];
//        var_dump($f1->getField()); die;

        $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
            (new Builder())->appsCommon(self::getRequest())
                ->andWhere(Criteria::expr()->eq(\Apps::STATUS, \AppStatus::YELLOW))
                ->andWhere(Criteria::expr()->lt(
                    \Apps::UPDATED,
                    new \DateTime()
                ))
        )->toArray();

        $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
            (new Builder())->appsCommon(self::getRequest())
                ->andWhere(Criteria::expr()->eq(\Apps::STATUS, \AppStatus::WHITE))
        )->toArray();

        $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
            (new Builder())->appsCommon(self::getRequest())
                ->andWhere(Criteria::expr()->eq(\Apps::STATUS, \AppStatus::RED))
                ->andWhere(Criteria::expr()->gte(
                    \Apps::UPDATED,
                    (new \DateTime())
                ))
        )->toArray();

        $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
            (new Builder())->appsCommon(self::getRequest())
                ->andWhere(Criteria::expr()->eq(\Apps::STATUS, \AppStatus::YELLOW))
                ->andWhere(Criteria::expr()->gte(
                    \Apps::UPDATED,
                    new \DateTime()
                ))
        )->toArray();

        $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
            (new Builder())->appsCommon(self::getRequest())
                ->andWhere(Criteria::expr()->notIn(\Apps::STATUS, [\AppStatus::WHITE, \AppStatus::YELLOW, \AppStatus::RED]))
        )->toArray();


        foreach ($apps as $a) {
            $allApps = array_merge($allApps, $a);
        }
//        $allApps = array_merge($apps[0], $apps[1]);

        $appStatus = Proxy::init()->getEntityManager()->getRepository(\AppStatus::class)->findAll();
        $appStatusArray = (new AppBuilder())->buildAppStatus($appStatus);
//        var_dump($allApps[1]->getUpdatedat());die;

        /*
                $appsArray = (new AppBuilder())->getArrayById($apps);
                $ids = array_keys($appsArray);

                $comments = Proxy::init()->getEntityManager()->getRepository(\Comments::class)->matching(
                    (new Builder())->commentsCommon($ids)
                )->toArray();

                $data['comments'] = $comments;
        */
        /** @var \Apps[] $appArr */
//        $appArr = $apps->toArray();
//        var_dump($appArr[0]->getLastComment()->getId()); die;
        $data['appstatus'] = $appStatusArray;
        $data['apps'] = $allApps;
        $data['time_picker'] = (new AppBuilder())->buildTimePicker();
        $data[self::ADD_COMMENT] = $this->generateUrl(self::ADD_COMMENT);
        $data['ctype'] = Proxy::init()->getEntityManager()->getRepository(\CommentTypes::class)->findAll();

        /** @var \Comments $comment */
//        $comment = $comments->toArray()[0];
        //var_dump($comment->getApp()); die;

//        $commetsArray = (new AppBuilder())->getArrayByAppId($comments);
//        var_dump((new AppBuilder())->getArrayById($apps));


//        echo "<pre>";
//        try {
//            var_dump((new Qb())->queryApps());
//        } catch (\Exception $e) {
//            var_dump($e->getMessage());
//        }
//        var_dump($apps->getUserId());
//        echo "<pre>";
//        die;


//        $param = array("id" => "1");
//        $urls = Proxy::init()->getEntityManager()->getRepository('Users')->findBy($param);
        /** @var \Users $user */
//        $user = $urls[0];
//        echo "<pre>";
//        var_dump($user->getRole()->getKeys());
//        var_dump($this->s);
//        var_dump(get_class($apps));

//        /** @var \Apps $app */
//        $app = $apps->toArray()[0];

        /** @var \Comments $comment */
//        $comment = $comments->toArray()[0];
//        var_dump(($comment));
//        echo "<pre>";
//        var_dump($app->getComments()[0]->getId());
//        echo "</pre>";
//        die;
//        Proxy::init()->getLogger()->addWarning(
//            \GuzzleHttp\json_encode(
//                $app->getUser()->getName()
//            )
//        );

        return (new Render())->render($data, 'appstable.html.twig');
    }
}