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
use App\Controller\Apps\Sorter;
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
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        return (new Render())->render($data);
    }

    /**
     * @Route("find", name="find")
     * @return Response
     */
    public function find()
    {
        $data['login'] = self::getRequest()->get('_route');
        $data['number'] = 'docs';
        $data['request'] = self::getRequest()->query->all();
        $search =  $data['request']['find'] ?? '';
        $data['post'] = self::getRequest()->getMethod();
        $data['uid'] = (new Autorize())->getUserId();
        $data['user_pick'] = (new Autorize())->getUserPic();
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        if($search) {
            $sql = 'SELECT a.id, a.user_id, a.status, f39.value_text AS city, f4.value_text AS surname, f5.value_text  AS firstname, f6.value_text  AS middlename, f8.value_text  AS phone FROM apps a 
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 39) f39 ON a.id = f39.app_id
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 4) f4 ON a.id = f4.app_id
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 5) f5 ON a.id = f5.app_id
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 6) f6 ON a.id = f6.app_id
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 8) f8 ON a.id = f8.app_id
  WHERE 
  a.id  REGEXP "' . $search . '" OR
  f39.value_text  REGEXP "' . $search . '" OR
  f4.value_text  REGEXP "' . $search . '" OR
  f5.value_text  REGEXP "' . $search . '" OR
  f5.value_text  REGEXP "' . $search . '" OR
  f8.value_text  REGEXP "' . $search . '"';
            $search = Proxy::init()->getEntityManager()->getConnection()->query($sql)->fetchAll();
            $searchId = [];
            foreach ($search as $app) {
                $searchId[] = $app['id'];
            }


//        var_dump($searchId); die;
    }
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        return (new Render())->render($data,'appstable.html.twig');
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
        $data['user_pick'] = (new Autorize())->getUserPic();
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        $search =  $data['request']['find'] ?? '';
        $search = mb_strtolower($search);

//        $params = (new Params())->get('distribution');
//        var_dump($params); die;

//        /** @var \Apps $apps */
//        $apps = Proxy::init()->getEntityManager()->getRepository('Apps')->matching(
//            (new Builder())->appsCommon(self::getRequest())
//        )->getValues();


        $filter = self::getRequest()->get('filter');

        //$criteria->andWhere(Criteria::expr()->eq('status', 2));
        /** @var \Apps[] $allApps */


        /*
        if ($filter == 'ready') {
            $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
                $criteria
                    ->andWhere(Criteria::expr()->eq(\Apps::STATUS, \AppStatus::WHITE))
            )->toArray();
        }
*/
        $allApps = [];
        $apps = [];
        if($search) {
            $sql = 'SELECT a.id, a.user_id, a.status, f39.value_text AS city, f4.value_text AS surname, f5.value_text  AS firstname, f6.value_text  AS middlename, f8.value_text  AS phone FROM apps a 
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 39) f39 ON a.id = f39.app_id
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 4) f4 ON a.id = f4.app_id
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 5) f5 ON a.id = f5.app_id
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 6) f6 ON a.id = f6.app_id
  LEFT JOIN (SELECT * FROM field_values WHERE field_id = 8) f8 ON a.id = f8.app_id
  WHERE 
  a.id  REGEXP "' . $search . '" OR
  LOWER(f39.value_text)  REGEXP "' . $search . '" OR
  LOWER(f4.value_text)  REGEXP "' . $search . '" OR
  LOWER(f5.value_text)  REGEXP "' . $search . '" OR
  LOWER(f6.value_text)  REGEXP "' . $search . '" OR
  f8.value_text  REGEXP "' . $search . '" 
  LIMIT 500';
            $search = Proxy::init()->getEntityManager()->getConnection()->query($sql)->fetchAll();
            $searchId = [];
            foreach ($search as $app) {
                $searchId[] = $app['id'];
            }
            $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
                Criteria::create()->where(
                    Criteria::expr()->in('id', $searchId)
                )
            )->toArray();
        }elseif (!$filter) {
            $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
                (new Builder())->appsCommon(self::getRequest())
                    ->andWhere(Criteria::expr()->eq(\Apps::STATUS, \AppStatus::RED))
                    ->andWhere(Criteria::expr()->lt(
                        \Apps::UPDATED,
                        (new \DateTime())
                    ))
            )
                ->toArray();

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
        } elseif ($filter != 'ready') {
            $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
                (new Builder())->appsCommon(self::getRequest())
            )->toArray();
        } else {
            $apps[] = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->matching(
                (new Builder())->appsCommon(self::getRequest())
                    ->andWhere(Criteria::expr()->eq(\Apps::STATUS, \AppStatus::GREEN))
            )->toArray();
        }

        $appsSortedByTimeZone = (new Sorter())->sortAll($apps);

        foreach ($appsSortedByTimeZone as $a) {
            $allApps = array_merge($allApps, $a);
        }

        $idArray = [];
        foreach ($allApps as $app) {
            $idArray[] = $app->getId();
        }
        $idList = implode(',', $idArray);
//        $allApps = array_merge($apps[0], $apps[1]);
//        var_dump($allApps[6]->getComments()); die;

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
//        var_dump($allApps[0]->getComments()); die;
//        $data['type'] = get_class($allApps[0]->getComments());

        $data['idList'] = $idList;
        $data[\Users::class] = Proxy::init()->getEntityManager()->getRepository(\Users::class)->findBy(['enabled' => 1]);
        $data[\Partners::class] = Proxy::init()->getEntityManager()->getRepository(\Partners::class)->findAll();
        $data['request'] = self::getRequest()->query->all();
        $data['appstatus'] = $appStatusArray;
        $data['apps'] = $allApps;
        $data['time_picker'] = (new AppBuilder())->buildTimePicker();
        $data[self::ADD_COMMENT] = $this->generateUrl(self::ADD_COMMENT);
        $data['ctype'] = Proxy::init()->getEntityManager()->getRepository(\CommentTypes::class)->findAll();
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];

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