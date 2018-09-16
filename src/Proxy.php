<?php

namespace App;

use Silex\Application as Silex;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;

class Proxy
{

    /**
     * @var Silex
     */
    private $silex;

    /**
     * @var EntityManager
     */
    private $doctrine;

    /**
     * @var Connection
     */
    private $pdo;

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
        return $this->silex;
    }

    /**
     * @param Silex $silex
     */
    public function setSilex(Silex $silex)
    {
        $this->silex = $silex;
    }

    /**
     * @return EntityManager
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @return Connection
     */
    public function getPdo()
    {
        return $this->pdo;
    }


    public function initDoctrine()
    {
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array( "../models"), $isDevMode, null, null, false);
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'host'     => 'localhost',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'kznew',
            'charset'  => 'UTF8',
        );
        $this->doctrine = EntityManager::create($dbParams, $config);
        $this->pdo = $this->doctrine->getConnection();
        return $this;
    }



}