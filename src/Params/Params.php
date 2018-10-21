<?php

namespace App\Params;

use App\Proxy;

class Params
{
    const NAME = 'name';

    /**
     * @param string $name
     * @return string
     */
    public function get(string $name){
        /** @var \Options[] $params */
        $params = Proxy::init()->getEntityManager()->getRepository(\Options::class)
            ->findBy([self::NAME => $name]);
        return $params[0]->getValue();
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function set(string $name, string $value){
        /** @var \Options[] $params */
        $params = Proxy::init()->getEntityManager()->getRepository(\Options::class)
            ->findBy([self::NAME => $name]);
        $params[0]->setValue($value);
        Proxy::init()->getEntityManager()->flush();
        return $this;
    }

}

