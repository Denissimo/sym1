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
use AppStatus;

class UsersController extends BaseController
{

    /**
     * @Route("users", name="users")
     * @return Response
     */
    public function users()
    {

        /** @var \Users[] $users */
        $users = Proxy::init()->getEntityManager()->getRepository(\Users::class)->findAll();

        $data[self::USERS] = $users;
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        return (new Render())->render($data, 'userstable.html.twig');
    }

    /**
     * @Route("user", name="user")
     * @return Response
     */
    public function user()
    {

        /** @var \Users $user */
        $user = Proxy::init()->getEntityManager()->getRepository(\Users::class)->findBy(
            [\Users::ID => self::getRequest()->get('user_id')]
        )[0];

        /** @var \Roles[] $userRoles */
        $userRoles = $user->getRole()->toArray();



        /** @var \Roles[] $roles */
        $roles = Proxy::init()->getEntityManager()->getRepository(\Roles::class)->findAll();

        /** @var \UsersSchedule[] $scheduleDays */
        $scheduleDays = Proxy::init()->getEntityManager()->getRepository(\UsersSchedule::class)->findBy(
            [
                'user' => $user,
//                'enabled' => 1,
                'type' => 0
            ]
        );

        /** @var \UsersSchedule[] $scheduleDates */
        $scheduleDates = Proxy::init()->getEntityManager()->getRepository(\UsersSchedule::class)->findBy(
            [
                'user' => $user,
//                'enabled' => 1,
                'type' => 1
            ]
        );

        $schedules = array_merge($scheduleDays, $scheduleDates);

//        var_dump($schedules[0]->getId());die;
//        var_dump($roles[0]->getName());die;
        $listRoles = (new AppBuilder())->buildRoles($roles, $userRoles);
        $data[self::USER] = $user;
        $data[self::USER_ROLES] = $userRoles;
        $data[self::LIST_ROLES] = $listRoles;
        $data[self::ROLES] = $roles;
        $data['schedules'] = $schedules;
        $data['time_picker'] = (new AppBuilder())->buildTimePicker();
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        return (new Render())->render($data, 'user.html.twig');
    }

    /**
     * @Route("userstat", name="userstat")
     * @return Response
     */
    public function report()
    {

       /** @var \Users $user */
        $user = Proxy::init()->getEntityManager()->getRepository(\Users::class)->findBy(
            [\Users::ID => self::getRequest()->get('user_id')]
        )[0];
            $query = ' SELECT a.user_id, COUNT(a.id) AS qty FROM (
                       SELECT * FROM apps WHERE user_id = :user_id AND status = :status AND DATE(updatedAt) >= :date1
                     ) a GROUP BY a.user_id';
        $values = [
            \Apps::USER_ID => $user->getId(),
            \AppStatus::FIELD => \AppStatus::GREEN,
            'date1' => (new \DateTime('today'))->format('Y-m-d')
        ];
        $sth = Proxy::init()->getEntityManager()->getConnection()->prepare($query);
        $sth->execute($values);
        $dayStat = $sth->fetchAll()[0] ?? ['qty' => 0];
        $values['date1'] = (new \DateTime('first day of this month'))->format('Y-m-d');
        $sth->execute($values);
        $monthStat = $sth->fetchAll()[0] ?? ['qty' => 0];


//        var_dump($dayStat); die;
        $data['user'] = $user;
        $data['stat'] = ['today' => $dayStat['qty'], 'month' =>  $monthStat['qty']];
        return (new Render())->render($data, 'userstat.html.twig');
    }
}