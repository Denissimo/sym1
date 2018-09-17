<?php

namespace App;

use Silex\Application as Silex;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;
use App\Config\Config;

class Proxy
{

    /**
     * @var Silex
     */
    private static $silex;

    /**
     * @var EntityManager
     */
    private static $entityManager;

    /**
     * @var Connection
     */
    private static $connection;

    private function __construct()
    {
        return $this;
    }

    /**
     * @return Proxy
     */
    public static function init()
    {
        return new self();
    }

    /**
     * @return Silex
     */
    public function getSilex(): Silex
    {
        return self::$silex;
    }

    /**
     * @param Silex $silex
     */
    public function initSilex(Silex $silex)
    {
        self::$silex = $silex;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return self::$entityManager;
    }

    /**
     * @return Connection
     */
    public function getConnecton()
    {
        return self::$connection;
    }


    public function initDoctrine()
    {
        $config = Setup::createAnnotationMetadataConfiguration(array("../models"), Config::isProd(), null, null, false);
        $dbParams = Config::getDoctrineParams();
        self::$entityManager = EntityManager::create($dbParams, $config);
        self::$connection = self::$entityManager->getConnection();
        return $this;
    }


}