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
use App\Params\Params;
use Doctrine\Common\Collections\Criteria;
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
        if (self::getRequest()->get('reminder')) {
            $reminderTime = self::getRequest()->get('reminder_time') ?? '00:00';
            $reminderGet = self::getRequest()->get('reminder') . 'T' . $reminderTime;
            $reminderDt = \DateTime::createFromFormat('d.m.Y\TH:i', $reminderGet);
            $reminderStr = $reminderDt->format('YmdHis');
            $updateTime = $reminderDt;

        } else {
            $reminderStr = null;
            $updateTime = new \DateTime();

        }

//        var_dump($reminder); die;
        /*
                switch ($ctype) {
                    case 1:
                        $updateTime = $reminderDt;
                    break;

                    case 2:
                        $updateTime = new \DateTime();
                    break;

                    case 3:
                        $updateTime = $app->getUpdatedat();
                    break;

                    case 4:
                        $updateTime = $app->getUpdatedat();
                    break;

                    case 5:
                        $updateTime = $app->getUpdatedat();
                    break;

                    case 6:
                        $updateTime = $app->getUpdatedat();
                    break;

                    default:
                        $updateTime = $app->getUpdatedat();
                    break;
                }
        */
        $newUpdateTime = $updateTime->add(new \DateInterval($interval));

        $app->setUpdatedat($newUpdateTime)
            ->setStatus($appStatus)
            ->setInWork($inWork);
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
     * @Route("updclientdata", name="updclientdata")
     * @return RedirectResponse
     */
    public function updClientData()
    {
        $appId = self::getRequest()->get(\FieldValues::APP_ID);
        self::getRequest()->request->remove(\FieldValues::APP_ID);
        $ready = self::getRequest()->get(\FieldValues::READY);
        self::getRequest()->request->remove(\FieldValues::READY);
        $idArray = [];
//        foreach (self::getRequest()->request->all() as $fieldId => $fielfValue) {
//            $idArray[$fieldId] = $fieldId;
//        }
        foreach (self::getRequest()->request->all() as $fieldId => $fielfValue) {
            preg_match('/field_(\d{1,2})/', $fieldId, $id);
            $idArray[(int)$id[1]] = (int)$id[1];
        }

//        var_dump($idArray); die;
        /** @var \Apps $app */
        $app = current(
            Proxy::init()->getEntityManager()->getRepository(\Apps::class)->findBy(
                [\Apps::ID => $appId]
            )
        );

        /** @var \FieldValues[] $fieldValues */
        $fieldValues = Proxy::init()->getEntityManager()->getRepository(\FieldValues::class)->matching(
            (Criteria::create())
                ->where(
                    Criteria::expr()->eq('app', $app)
                )
                ->andWhere(
                    Criteria::expr()->in(\FieldValues::FIELD, $idArray)
                )
        )
            ->toArray();

        foreach ($fieldValues as $fv) {
            unset($idArray[$fv->getField()->getId()]);
            $fv->setValueText(
                self::getRequest()->get(AppController::FIELD_PREFIX . $fv->getField()->getId())
            );
        }

        /** @var \Fields[] $fields */
        $fields = Proxy::init()->getEntityManager()->getRepository(\Fields::class)->matching(
            (Criteria::create())
                ->where(
                    Criteria::expr()->in(\FieldValues::ID, $idArray)
                )
            )
            ->toArray();

        /** @var \Fields[] $fieldList */
        $fieldList = [];
        foreach ($fields as $field) {
            $fieldList[$field->getId()] = $field;
        }

        unset($fields);

        foreach ($idArray as $id) {
            if(self::getRequest()->get(AppController::FIELD_PREFIX . $id)) {
                $newFieldValue = (new \FieldValues())
                    ->setValueText(self::getRequest()->get(AppController::FIELD_PREFIX . $id))
                    ->setApp($app)
                    ->setField($fieldList[$id]);
                Proxy::init()->getEntityManager()->persist($newFieldValue);
            }
        }


        if ($ready) {
            $app->setStatus(\AppStatus::GREEN);
        }

        Proxy::init()->getEntityManager()->flush();

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
        );
        $user->setName(self::getRequest()->get(\Users::NAME))
            ->setEmail(self::getRequest()->get(\Users::EMAIL))
            ->setEnabled(
                self::getRequest()->get(\Users::ENABLED) ? true : false
            )
            ->setPriority(
                self::getRequest()->get(\Users::PRIORITY)
            );
        if (self::getRequest()->get(\Users::PASSWORD)) {
            $user->setPassword(
                sha1(
                    strtolower(
                        self::getRequest()->get(\Users::EMAIL) . self::getRequest()->get(\Users::PASSWORD)
                    )
                )
            );
        }

        Proxy::init()->getEntityManager()->flush();
        return $this->redirect(
            $this->generateUrl('users')
        );
    }

    /**
     * @Route("changeopts", name="changeopts")
     * @return RedirectResponse
     */
    public function changeopts()
    {
        (new Params())
            ->set(OptionsController::DISTR, self::getRequest()->get(OptionsController::DISTR))
            ->set(OptionsController::ROWS, self::getRequest()->get(OptionsController::ROWS));
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
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