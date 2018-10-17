<?php

namespace App\Controller\Actions;

use App\Proxy;
use App\Cfg\Config;
use Symfony\Component\HttpFoundation\Request;

class Autorize
{
    const
        POST = 'POST',
        LOGOUT = 'logout',
        FIELD_LOGGED = 'logged',
        FIELD_USER_NAME = 'name',
        FIELD_UID = 'uid';

    /**
     * @var \Users
     */
    private $user;

    /**
     * @param Request $request
     * @return bool
     */
    public function login(Request $request)
    {
        $config = Config::getAutorizeParams();
        $users = (array)Proxy::init()
            ->getEntityManager()
            ->getRepository($config[Config::FIELD_TABLE])
            ->findBy(
                [
                    Config::getDbUserField() => $request->get(Config::getRequestUserField()),
                    Config::getDbPassField() => sha1(
                        strtolower(
                            $request->get(Config::getRequestUserField()) . $request->get(Config::getRequestPassField())
                        )
                    )
                ]
            );
        /*
        Proxy::init()->getLogger()->addWarning(
            sha1(
                strtolower(
                    $request->get(Config::getRequestUserField()) . $request->get(Config::getRequestPassField())
                )
            )
        );
        */
        if(count($users)) {
            $this->user = $users[0];
            Proxy::init()->getSession()->set(Config::FIELD_LOGIN, true);
            Proxy::init()->getSession()->set(Config::FIELD_USER, $this->user->getEmail());
            Proxy::init()->getSession()->set(Config::FIELD_NAME, $this->user->getName());
            Proxy::init()->getSession()->set(Config::FIELD_UID, $this->user->getId());
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function logout()
    {
        Proxy::init()->getSession()->set(Config::FIELD_LOGIN, false);
        Proxy::init()->getSession()->set(Config::FIELD_USER, null);
        Proxy::init()->getSession()->set(Config::FIELD_NAME, null);
        Proxy::init()->getSession()->set(Config::FIELD_UID, null);
        return true;
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        return Proxy::init()->getSession()->get(Config::FIELD_LOGIN);
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return Proxy::init()->getSession()->get(Config::FIELD_NAME);
    }


    /**
     * @return int
     */
    public function getUserId()
    {
        return Proxy::init()->getSession()->get(Config::FIELD_UID);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isUriGranted(Request $request){
        return in_array(
            $request->getRequestUri(),
            Config::getGrantedUris()
        );
    }

    /**
     * @param Request $request
     */
    public function autorize(Request $request)
    {
        if($request->getMethod() == self::POST && $request->get(Config::getRequestUserField())) {
            (new Autorize())->login($request);
        }

        if($request->getMethod() == self::POST && $request->get(self::LOGOUT)) {
            (new Autorize())->logout();
        }
    }
}