<?php

namespace App\Controller;

use App\Api\Config;

use App\Exceptions\DefaultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Twig\Render;
use App\Api\RequestAPI\RequestAPI;
use App\Params\Params;
use Doctrine\Common\Collections\Criteria;


class CronController extends BaseController
{
    const
        APP_LIMIT = 3,
        PRIORITY = 'priority',
        PART = 'part';

    /**
     * @Route("distrib", name="distrib")
     * @return Response
     */
    public function distrib()
    {
        try {
            $day3 = (new \DateTime('today'))->sub(new \DateInterval('P3D'))->format('Y-m-d');
            $query = '
                  SELECT u.id, u.name, ry.ry_qty, unpoc.unpoc_qty, u.enabled, u.priority, sc.user_id, sc.num FROM users u LEFT JOIN (
                  SELECT a.user_id, COUNT(a.id) AS ry_qty FROM 
                  (SELECT user_id, id, a.updatedAt FROM apps a WHERE a.status IN (1, 2)  AND DATE(a.updatedAt) > "' . $day3 . '" AND a.updatedAt < NOW()) a 
                  GROUP BY a.user_id
                 ) ry ON ry.user_id = u.id LEFT JOIN (
                 SELECT a.user_id, COUNT(a.id) AS unpoc_qty FROM apps a LEFT JOIN comments c ON a.id = c.app_id WHERE c.id IS NULL GROUP BY a.user_id
                  ) unpoc ON u.id = unpoc.user_id
                    LEFT JOIN
                  (SELECT schedule.user_id, COUNT(schedule.id) AS num FROM ( 
                SELECT * FROM users_schedule us WHERE us.type = 0 AND WEEKDAY(us.date_from) = WEEKDAY(NOW()) AND (TIME(NOW()) BETWEEN TIME(us.date_from) AND time(us.date_to))
                  UNION
                SELECT * FROM users_schedule us WHERE us.type = 1 AND (DATE(NOW()) BETWEEN DATE(us.date_from) AND DATE(us.date_to)) AND (TIME(NOW()) BETWEEN TIME(us.date_from) AND time(us.date_to))
                  ) schedule GROUP BY schedule.user_id) sc ON sc.user_id = u.id
                
                  WHERE 
                  (ry.ry_qty IS NULL OR ry.ry_qty = 0)
                  AND
                (unpoc.unpoc_qty IS NULL OR unpoc.unpoc_qty = 0)
                  AND u.enabled = 1
                AND sc.user_id IS NOT NULL
            ';
//            Proxy::init()->getLogger()->addWarning($query);
            $usersReady = Proxy::init()->getEntityManager()->getConnection()->query($query)->fetchAll();
            $userIdArray = array_column($usersReady, 'id');
            $prioriyArray = array_column($usersReady, 'priority');
            $prioriySum = array_sum($prioriyArray);
//            echo '<pre>'; var_dump($prioriySum); die;
//            echo '<pre>'; var_dump($usersReady); die;


            $params = [
                OptionsController::DISTR => (new Params())->get(OptionsController::DISTR),
                OptionsController::ROWS => (new Params())->get(OptionsController::ROWS)
            ];
            $users = Proxy::init()->getEntityManager()
                ->getRepository(\Users::class)
                ->matching(
                    Criteria::create()
                        ->where(
                            Criteria::expr()->neq('enabled', 0)
                        )
                        ->andWhere(
                            Criteria::expr()->in('id', $userIdArray)
                        )
                        ->orderBy(
                            ['priority' => Criteria::DESC]
                        )
//                        ->setMaxResults($params[OptionsController::ROWS])
                )
                ->toArray();
            if(!count($users)) {
                return (new Render())->simpleRender(['data' => 'no users available'], 'test.html.twig');
            }
//
            $priorities = $this->priorities($users);

            $apps = Proxy::init()->getEntityManager()
                ->getRepository(\Apps::class)
                ->matching(
                    Criteria::create()
//                        ->where(Criteria::expr()->eq('in_work', 0))
                        ->where(
                            Criteria::expr()->eq(
                                'user',
                                Proxy::init()->getEntityManager()->getRepository(\Users::class)->find(1)
                            )
                        )
                        ->orderBy(['createdat' => 'ASC'])
                        ->setMaxResults($params[OptionsController::ROWS])
                )->toArray();
//            echo '<pre>'; var_dump($priorities); die;
            $this->userSet($apps, $priorities);
//            var_dump($users); die;
            return (new Render())->simpleRender([], 'test.html.twig');

        } catch (\Exception $e) {
            Proxy::init()->getLogger()->addWarning(
                $e->getMessage()
            );
            $res = $e->getMessage();
            return (new Render())->simpleRender(['data' => $e->getMessage()], 'test.html.twig');
        }
    }

    /**
     * @param \Apps[] $apps
     * @param array $priorities
     * @return $this
     */
    private function userSet($apps, $priorities)
    {
//        var_dump($priorities); die;

        $appsLimit = (new Params())->get('apps_limit_for_user');
        $userIds = array_keys($priorities);

        $num = 0;
        $qty = 0;
        foreach ($apps as $app) {
            $qty++;
            if (isset($userIds[$num])) {
                $id = $userIds[$num];
                $app->setUserId($id);
//                var_dump($userIds[$num]);
            } else {
                break;
            }

            if ($qty >= $appsLimit) {
                $num++;
                $qty = 0;
            }


        }
        Proxy::init()->getEntityManager()->flush();
        return $this;
    }

    /**
     * @param \Users[] $users
     * @return array
     */
    private function priorities($users): array
    {
        $priorSum = 0;
        $priorities = [];
        foreach ($users as $user) {
            $priorities[$user->getId()][self::PRIORITY] = $user->getPriority();
            $priorSum += $user->getPriority();
        }

        foreach ($priorities as $key => $prior) {
            $priorities[$key][self::PART] = $prior[self::PRIORITY] / $priorSum;
        }

        return $priorities;
    }

}