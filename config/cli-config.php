<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use App\Cfg\Config;

return ConsoleRunner::createHelperSet(
    EntityManager::create(
        Config::getDoctrineParams(),
        Setup::createAnnotationMetadataConfiguration(
            [__DIR__ .'\..'. Config::getDoctrineOptions()[Config::FIELD_PATH]],
            Config::isProd(),
            null,
            null,
            false
        )
    )
);
