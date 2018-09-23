<?php

namespace App\Controller\Actions;

use App\Proxy;
use App\Cfg\Config;
use Symfony\Component\HttpFoundation\Request;

class Autorize
{
    /**
     * @var \Users
     */
    private $user;

    public function login(Request $request)
    {
        $config = Config::getAutorizeParams();
        $users = (array)Proxy::init()
            ->getEntityManager()
            ->getRepository($config[Config::FIELD_TABLE])
            ->findBy(
                [
                    $config[Config::FIELD_USER] => $request->get($config[Config::REQUEST_USER]),
                    $config[Config::FIELD_PASS] => sha1(
                        strtolower(
                            $request->get($config[Config::REQUEST_USER]) . $request->get($config[Config::REQUEST_PASS])
                        )
                    )
                ]
            );

        if(count($users)) {
            $this->user = $users[0];
            Proxy::init()->getSession()->set(Config::FIELD_LOGGED, true);
            Proxy::init()->getSession()->set(Config::FIELD_USER, $this->user->getEmail());
            Proxy::init()->getSession()->set(Config::FIELD_UID, $this->user->getId());
            return true;
        } else {
            return false;
        }
    }
}