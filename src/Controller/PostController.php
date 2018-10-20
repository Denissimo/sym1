<?php

namespace App\Controller;

use App\Exceptions\DefaultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Cfg\Config;
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

class PostController extends BaseController
{
    /**
     * @Route("changerole", name="changerole")
     * @return RedirectResponse
     */
    public function changeRole()
    {
//        var_dump(self::getRequest()->request); die;
        /** var string $query */
        $query = null;
        switch (self::getRequest()->get(\Roles::FIELD_ACTION)) {
            case \Roles::ACTION_ADD :
                $query = 'INSERT INTO users_roles SET user_id = :user_id, role_id = :role_id;';
            break;

            case \Roles::ACTION_DEL :
                $query = 'DELETE FROM users_roles WHERE user_id = :user_id AND role_id = :role_id;';
            break;
            default:
                return $this->redirect(
                    self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
                );
        }
//        echo $query; die;
        $sth = Proxy::init()->getConnecton()->prepare($query);
        $sth->bindValue(':user_id', (int)self::getRequest()->get('user_id'), \PDO::PARAM_INT);
        $sth->bindValue(':role_id', (int)self::getRequest()->get('role_id'), \PDO::PARAM_INT);
        $sth->execute();
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );
    }

    /**
     * @Route("addcomment", name="addcomment")
     * @return RedirectResponse
     */
    public function addComment()
    {
        $ctype = (int)self::getRequest()->get('ctype');
        $appId = (int)self::getRequest()->get('app_id');
        /** @var \CommentTypes $commentTypes */
        $commentTypes = Proxy::init()->getEntityManager()->getRepository(\CommentTypes::class)->find($ctype);
        /** @var \Apps $app */
        $app = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->find($appId);
        $inWork = $commentTypes->isInWork();
        $appStatus = $commentTypes->getAppStatus()->getId();
        $interval = $commentTypes->getDateInterval();

        /** @var \DateTime $reminderDt $app */
        if(self::getRequest()->get('reminder')) {
            $reminderTime = self::getRequest()->get('reminder_time') ?? '00:00';
            $reminderGet = self::getRequest()->get('reminder').'T'.$reminderTime;
            $reminderDt = \DateTime::createFromFormat('d.m.Y\TH:i', $reminderGet);
            $reminderStr = $reminderDt->format('YmdHis');

        } else {
            $reminderStr = null;

        }

//        var_dump($reminder); die;
        switch ($appStatus) {
            case 1:
                $updateTime = $reminderDt;
            break;

            case 2:
                $updateTime = $app->getUpdatedat();
            break;

            case 3:
                $updateTime = $app->getUpdatedat();
            break;

            default:
                $updateTime = $app->getUpdatedat();
            break;
        }

        $newUpdateTime = $updateTime->add(new \DateInterval($interval));

        $app->setUpdatedat($newUpdateTime)
            ->setStatus($appStatus)
            ->setInWork($inWork)
        ;
        Proxy::init()->getEntityManager()->flush();


        $query = 'INSERT INTO comments SET app_id = :app_id, comment = :comment, uid = :user_id, ts = now(), reminder = :reminder, ctype = :ctype;';
        $sth = Proxy::init()->getConnecton()->prepare($query);
        $sth->bindValue(':app_id', (int)self::getRequest()->get('app_id'), \PDO::PARAM_INT);
        $sth->bindValue(':user_id', (int)self::getRequest()->get('user_id'), \PDO::PARAM_INT);
        $sth->bindValue(':ctype', $ctype, \PDO::PARAM_INT);
        $sth->bindValue(':comment', self::getRequest()->get('comment'), \PDO::PARAM_STR);
        $sth->bindValue(':reminder', $reminderStr);
        $sth->execute();
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );

    }

    /**
     * @Route("adduser", name="adduser")
     * @return RedirectResponse
     */
    public function addUser()
    {
        $newUser = (new \Users())
            ->setName(self::getRequest()->get(\Users::NAME))
            ->setEmail(self::getRequest()->get(\Users::EMAIL))
            ->setPassword(
                sha1(
                    strtolower(
                        self::getRequest()->get(\Users::EMAIL) . self::getRequest()->get(\Users::PASSWORD)
                    )
                )
            )
            ->setEnabled(
                self::getRequest()->get(\Users::ENABLED) ? true : false
            )
            ->setPriority(
                self::getRequest()->get(\Users::PRIORITY)
            );
        Proxy::init()->getEntityManager()->persist($newUser);
        Proxy::init()->getEntityManager()->flush();
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );
    }

    /**
     * @Route("edituser", name="edituser")
     * @return RedirectResponse
     */
    public function editUser()
    {
        /** @var \Users $user */
        $user = Proxy::init()->getEntityManager()->getRepository(\Users::class)->find(
            self::getRequest()->get(\Users::ID)
        )

        ;
        $user->setName(self::getRequest()->get(\Users::NAME))
            ->setEmail(self::getRequest()->get(\Users::EMAIL))
            ->setEnabled(
                self::getRequest()->get(\Users::ENABLED) ? true : false
            )
            ->setPriority(
                self::getRequest()->get(\Users::PRIORITY)
            );
        if(self::getRequest()->get(\Users::PASSWORD)) {
            $user->setPassword(
                sha1(
                    strtolower(
                        self::getRequest()->get(\Users::EMAIL) . self::getRequest()->get(\Users::PASSWORD)
                    )
                )
            );
        }
//        var_dump($user->getName()); die;
//        Proxy::init()->getEntityManager()->persist($user);
        Proxy::init()->getEntityManager()->flush();
        return $this->redirect(
            $this->generateUrl('users')
        );
    }

    /**
     * @Route("autorize", name="autorize")
     * @return RedirectResponse
     */
    public function autorize()
    {
        (new Autorize())->autorize(self::getRequest());
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );

    }
}