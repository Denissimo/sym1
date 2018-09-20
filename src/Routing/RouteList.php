<?php

namespace App\Routing;


use App\Proxy;

class RouteList
{
    const MODEL = 'SysUrls';

    /**
     * @var array
     */
    private $urls;

    public function __construct()
    {
        $this->urls = Proxy::init()->getEntityManager()->getRepository(self::MODEL)->findAll();
    }

    /**
     * @return array
     */
    public function getUrls(): array
    {
        return $this->urls;
    }


}