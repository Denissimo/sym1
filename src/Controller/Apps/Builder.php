<?php

namespace App\Controller\Apps;

use Doctrine\Common\Collections\Collection;

class Builder
{
    /**
     * @param Collection $apps
     * @return array
     */
    public function getArrayById(Collection $apps) : array
    {
        /** @var array $res */
        /** @var \Apps $item */
        foreach ($apps->toArray() as $item)
        {
            $res[$item->getId()] = $item;
        }
        return $res;
    }

    /**
     * @param Collection $comments
     * @return array
     */
    public function getArrayByAppId(Collection $comments) : array
    {
        /** @var array $res */
        /** @var \Comments $item */
        foreach ($comments->toArray() as $item)
        {
            $res[$item->getId()] = $item;
        }
        return $res;
    }
}