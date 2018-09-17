<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use App\Config\Config;



$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/models"), Config::isProd(), null, null, false);
$dbParams = Config::getDoctrineParams();
$entityManager = EntityManager::create($dbParams, $config);

return ConsoleRunner::createHelperSet($entityManager);
