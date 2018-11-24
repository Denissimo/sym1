<?php

namespace App\Controller\Apps;

use App\Proxy;
use Doctrine\Common\Collections\Collection;

class Builder
{
    const DEFAULT_ID = 3;

    /**
     * @param Collection $apps
     * @return array
     */
    public function getArrayById(Collection $apps): array
    {
        /** @var array $res */
        /** @var \Apps $item */
        foreach ($apps->toArray() as $item) {
            $res[$item->getId()] = $item;
        }
        return $res;
    }

    /**
     * @param Collection $comments
     * @return array
     */
    public function getArrayByAppId(Collection $comments): array
    {
        /** @var array $res */
        /** @var \Comments $item */
        foreach ($comments->toArray() as $item) {
            $res[$item->getId()] = $item;
        }
        return $res;
    }


    /**
     * @return array
     */
    public function buildTimePicker(): array
    {
        $time = [];
        for ($i = 0; $i < 24; $i++) {
            $time[] = ['value' => $i * 24, 'text' => $i . ':00'];
            $time[] = ['value' => $i * 24 + 30, 'text' => $i . ':30'];
        }
        $time[] = ['value' => 23 * 24 + 59, 'text' =>  '23:59'];
//        var_dump($time); die;
        return $time;
    }

    /**
     * @param \Roles[] $roles
     * @param \Roles[] $userRoles
     * @return array
     */
    public function buildRoles($roles, $userRoles): array
    {
        $granted = [];
        foreach ($userRoles as $uRole) {
            $granted[$uRole->getId()] = true;
        }
        $listRoles = [];
        foreach ($roles as $role) {
            $listRoles[$role->getId()] = [
                'id' => $role->getId(),
                'name' => $role->getName(),
                'access' => $granted[$role->getId()] ?? false
            ];
        }

        return $listRoles;
    }

    /**
     * @param \AppStatus[] $appStatus
     * @return array
     */
    public function buildAppStatus($appStatus): array
    {
        $appstatusArray = [0 => $appStatus[self::DEFAULT_ID]];
        foreach ($appStatus as $as) {
            $appstatusArray[$as->getId()] = $as;
        }
        return $appstatusArray;
    }

    /**
     * @param \Fields[] $fields
     * @param \FieldValues[] $fieldValues
     * @return \FieldValues[][]
     */
    public function fieldValuesAll($fields, $fieldValues)
    {
        /** @var \FieldValues[] $fieldVal */
        $fieldVal = [];

        /** @var \FieldValues[][] $fieldValuesAll */
        $fieldValuesAll = [];

        foreach ($fieldValues as $fv) {
            $fieldVal[$fv->getField()->getId()] = $fv;
        }

        foreach ($fields as $field) {
            $fieldValuesAll[$field->getGroup()->getName()][$field->getId()] = $fieldVal[$field->getId()] ?? (new \FieldValues())->setField($field);
        }

        return $fieldValuesAll;
    }
}