<?php

namespace App;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;
use App\Cfg\Config;

class Proxy
{


    /**
     * @var EntityManager
     */
    private static $entityManager;

    /**
     * @var Connection
     */
    private static $connection;

    /**
     * @var \Twig_Environment
     */
    private static $twigEnvironment;


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
        self::$entityManager = EntityManager::create(
            Config::getDoctrineParams(),
            Setup::createAnnotationMetadataConfiguration(
                [".." . Config::getDoctrineOptions()[Config::FIELD_PATH]],
                Config::isProd(),
                null,
                null,
                false
            )
        );
        self::$connection = self::$entityManager->getConnection();
        return $this;
    }

    public function initTwig()
    {
        self::$twigEnvironment = new \Twig_Environment(
            new \Twig_Loader_Filesystem(".." . Config::getTwigPath()),
            Config::getTwigOptions()
        );
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwigEnvironment(): \Twig_Environment
    {
        return self::$twigEnvironment;
    }


}