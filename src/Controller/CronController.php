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
        PRIORITY = 'priority',
        PART = 'part';

    /**
     * @Route("distrib", name="distrib")
     * @return Response
     */
    public function distrib()
    {
        try {
            $params = [
                OptionsController::DISTR => (new Params())->get(OptionsController::DISTR),
                OptionsController::ROWS => (new Params())->get(OptionsController::ROWS)
            ];
            $users = Proxy::init()->getEntityManager()
                ->getRepository(\Users::class)
                ->matching(
                    Criteria::create()
                        ->where(
                            Criteria::expr()->neq('priority', 0)
                        )
                        ->setMaxResults($params[OptionsController::ROWS])
                )->toArray();
            $priorities = $this->priorities($users);

            $apps = Proxy::init()->getEntityManager()
                ->getRepository(\Apps::class)
                ->matching(
                    Criteria::create()
                        ->where(
                            Criteria::expr()->eq('userId', 0)
                        )
                        ->orderBy(['createdat' => 'ASC'])
                        ->setMaxResults($params[OptionsController::ROWS])
                )->toArray();

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
        $userIds = array_keys($priorities);
        $num = 0;
        foreach ($apps as $app) {
            if(isset($userIds[$num])) {
                $id = $userIds[$num];
                $num++;
            } else {
                $id = $userIds[0];
                $num = 0;
            }
            $app->setUserId($id);
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