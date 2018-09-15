<?php

namespace App;

use Silex\Application as Silex;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Proxy
{

    /**
     * @var Silex
     */
    private $silex;


    private $doctrine;

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
     * @return mixed
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }


    public function setDoctrine()
    {
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/models"), $isDevMode, null, null, false);
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'host'     => 'localhost',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'kznew',
            'charset'  => 'UTF8',
        );
        $entityManager = EntityManager::create($dbParams, $config);
        $em = $entityManager->getConnection();
        $this->doctrine = $em;
    }



}