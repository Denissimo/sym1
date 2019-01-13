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
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    const
        RETURN = 'return',
        FIAS = 'field_fias',
        FIAS1 = 'field_fias1',
        TIME_ZONE = 'field_timezone',
        TIME_ZONE1 = 'field_timezone1',
        TIME_ZONE_DEFAULT = 3;

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

        $newUpdateTime = $updateTime->add(new \DateInterval($interval));

        $app->setUpdatedat($newUpdateTime)
            ->setInWork(true)
            ->setStatus($appStatus)
            ->setTrash($inWork);
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
        $request = self::getRequest()->request->all();
//        var_dump(self::getRequest()->request->all()); die;
        $appId = $request[\FieldValues::APP_ID];
        unset($request[\FieldValues::APP_ID]);
        $ready = $request[\FieldValues::READY] ?? null;
        unset($request[\FieldValues::READY]);
        $rerutn = $request[self::RETURN] ?? null;
        unset($request[self::RETURN]);
        $fias = $request[self::FIAS1] ?? null;
        unset($request[self::FIAS]);
        unset($request[self::FIAS1]);
//        var_dump($fias); die;
        $idArray = [];
        $fiasArray = [];
        foreach ($request as $fieldId => $fielfValue) {
            preg_match('/field_(\d{1,2})/', $fieldId, $id);
            $idArray[(int)$id[1]] = (int)$id[1];
            $fiasArray[(int)$id[1]] = null;
        }
        $fiasArray[\Fields::CITY] = $fias;

        if ($fias) {
            $request[AppController::FIELD_PREFIX . \Fields::TIME_ZONE] = $this->getTimeZone($fias);
            $idArray[\Fields::TIME_ZONE] = \Fields::TIME_ZONE;
            $fiasArray[\Fields::TIME_ZONE] = null;
        }
//        var_dump($fiasArray); die;
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
            $fv
                ->setValueText(
                    $request [AppController::FIELD_PREFIX . $fv->getField()->getId()]
                )
                ->setValue($fiasArray[$fv->getField()->getId()]);
//            echo "<br />" . $fv->getField()->getId() . ">>>" . $request [AppController::FIELD_PREFIX . $fv->getField()->getId()];
        }


//        var_dump($request[AppController::FIELD_PREFIX . \Fields::TIME_ZONE]); die;

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
            if ($request[AppController::FIELD_PREFIX . $id]) {
                $newFieldValue = (new \FieldValues())
                    ->setValueText($request[AppController::FIELD_PREFIX . $id])
                    ->setValue($fiasArray[$id])
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
            $rerutn ? $this->generateUrl('apps') : self::getRequest()->headers->get('referer')
        );
    }

    /**
     * @param string $fias
     * @return string | null
     */
    private function getTimeZone(string $fias)
    {
        $query = 'SELECT * FROM addrobj a LEFT JOIN region2offset r ON a.regioncode=r.region WHERE a.aoguid ="' . $fias . '"';
        $timeZone = current(Proxy::init()->getEntityManager()->getConnection()->query($query)->fetchAll())['offset'];
//        return $timeZone ? (string)($timeZone - self::TIME_ZONE_DEFAULT) : null;
        return $timeZone ?? null;
    }

    /**
     * @Route("ajaxcode", name="ajaxcode")
     * @return Response
     */
    public function ajaxCode()
    {
        /** @var \Passportcode2who $passCode */
        $passCode = Proxy::init()->getEntityManager()
            ->getRepository(\Passportcode2who::class)
            ->findOneBy(
                [\Passportcode2who::CODE => self::getRequest()->get(\Passportcode2who::CODE)]
            );
//        $data[\Passportcode2who::NAME] = \GuzzleHttp\json_encode($passCode->getW());
        $data[\Passportcode2who::NAME] = $passCode ? $passCode->getW() : null;
//        var_dump($data); die;
        return (new Render())->simpleRender($data, 'ajax.html.twig');
    }

    /**
     * @Route("addapp", name="addapp")
     * @return RedirectResponse
     */
    public function addApp()
    {
        $query = 'INSERT INTO apps SET partner_id = '.\Partners::DEFAULT_ID.', foreign_id = 1, user_id = 1, status = 3, createdAt = now(), updatedAt = now(), ip = 0, `check` = 0;';
        Proxy::init()->getEntityManager()->getConnection()->query($query);
        $id = Proxy::init()->getConnecton()->lastInsertId();

        return $this->redirect(
            $this->generateUrl('app', ['app_id' => $id])
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
     * @Route("addupic", name="addupic")
     * @return RedirectResponse
     */
    public function addUpic()
    {
        /** @var UploadedFile $file */
        $file = current(self::getRequest()->files->all());

        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        try {
            $file->move($this->get('kernel')->getProjectDir() .
                Config::getDefaults()[Config::FIELD_USERPIC][Config::FIELD_UPLOAD], $fileName
            );
//            $a = $file->move('\images\userpics', $fileName);
        } catch (\Exception $e) {
            return $this->redirect(
                self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
            );
        }

        /** @var \Users $user */
        $user = Proxy::init()->getEntityManager()->getRepository(\Users::class)->find(
            (new Autorize())->getUserId()
        );
        $user->setUserPick($fileName);
        Proxy::init()->getEntityManager()->flush();
        (new Autorize())->setUserPick($user->getUserPick());

        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );
    }


    /**
     * @Route("addschedule", name="addschedule")
     * @return RedirectResponse
     */
    public function addSchedule()
    {
        if (!self::getRequest()->get('date_from')) {
            return $this->redirect(
                self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
            );
        }
        $type = self::getRequest()->get('type');
        if ($type) {
            $fromDate = self::getRequest()->get('date_from');
        } else {
            $day = self::getRequest()->get('date_from');
            $fromDate = date('d.m.Y', strtotime('next ' . $day));
        }
        $fromTime = self::getRequest()->get('time_from') ?? '00:00';
        $fromGet = $fromDate . 'T' . $fromTime;
        $fromDt = \DateTime::createFromFormat('d.m.Y\TH:i', $fromGet);

        $toTime = self::getRequest()->get('time_to') ?? '00:00';
        $dateTo = self::getRequest()->get('date_to') ?? $fromDate;
        $toGet = $dateTo . 'T' . $toTime;
        $toDt = \DateTime::createFromFormat('d.m.Y\TH:i', $toGet);

        /** @var \Users $user */
        $user = Proxy::init()->getEntityManager()->getRepository(\Users::class)
            ->findOneBy(['id' => self::getRequest()->get('user_id')]);
//        var_dump($fromGet); die;
        $newSchedule = (new \UsersSchedule())
            ->setEnabled(true)
            ->setType(self::getRequest()->get('type'))
            ->setUser($user)
            ->setDateFrom($fromDt)
            ->setDateTo($toDt);

        Proxy::init()->getEntityManager()->persist($newSchedule);
        Proxy::init()->getEntityManager()->flush();
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );
    }

    /**
     * @Route("editschedule", name="editschedule")
     * @return RedirectResponse
     */
    public function editSchedule()
    {
        $id = self::getRequest()->get('id');
        /** @var \UsersSchedule $schedule */
        $schedule = Proxy::init()->getEntityManager()->getRepository(\UsersSchedule::class)->find($id);
        $enabled = $schedule->getEnabled();
        $enabledNew = $enabled ? false : true;
        $schedule->setEnabled($enabledNew);
        Proxy::init()->getEntityManager()->flush();
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );
    }

    /**
     * @Route("delschedule", name="delschedule")
     * @return RedirectResponse
     */
    public function delSchedule()
    {
        $id = self::getRequest()->get('id');
        /** @var \UsersSchedule $schedule */
        $schedule = Proxy::init()->getEntityManager()->getRepository(\UsersSchedule::class)->find($id);
        Proxy::init()->getEntityManager()->remove($schedule);
        Proxy::init()->getEntityManager()->flush();
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );
    }

    /**
     * @Route("trash", name="trash")
     * @return RedirectResponse
     */
    public function trash()
    {
        /** @var \Apps $app */
        $app = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->find(
            (int)self::getRequest()->get(self::APP_ID)
        );
        $app->setTrash(true);
        Proxy::init()->getEntityManager()->flush();
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );
    }

    /**
     * @Route("transfer", name="transfer")
     * @return RedirectResponse
     */
    public function transfer()
    {
        /** @var \Apps $app */
        $app = Proxy::init()->getEntityManager()->getRepository(\Apps::class)->find(
            (int)self::getRequest()->get(self::APP_ID)
        );
        $userTo = (int)self::getRequest()->get('userTo') ? (int)self::getRequest()->get('userTo') : 1;
        $app->setUserId($userTo);
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
            ->set(OptionsController::LIMIT, self::getRequest()->get(OptionsController::LIMIT))
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