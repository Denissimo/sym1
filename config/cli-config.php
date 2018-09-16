<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Mapping\Driver;
use Doctrine\Common\Persistence\Mapping;
use App\Config\Config;


$isDevMode = true;
// Настройки будут браться из аннотаций, на мой взгляд, это удобнее
// Заметьте, что здесь я передаю путь до каталога, который будет содержать в себе классы сущностей, проецируемые на БД

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

return ConsoleRunner::createHelperSet($entityManager);
