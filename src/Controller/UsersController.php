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

//        var_dump($userRoles[0]->getId());die;
//        var_dump($roles[0]->getName());die;
        $listRoles = (new AppBuilder())->buildRoles($roles, $userRoles);
        $data[self::USER] = $user;
        $data[self::USER_ROLES] = $userRoles;
        $data[self::LIST_ROLES] = $listRoles;
        $data[self::ROLES] = $roles;
        return (new Render())->render($data, 'user.html.twig');
    }
}