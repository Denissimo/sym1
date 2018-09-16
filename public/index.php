<?php

use App\Kernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use App\Testf\Test;
use App\Proxy;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


require __DIR__.'/../vendor/autoload.php';
//require __DIR__.'/../config/cli-config.php';

// The check is to ensure we don't use .env in production
if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
    }
    (new Dotenv())->load(__DIR__.'/../.env');
}

$env = $_SERVER['APP_ENV'] ?? 'dev';
$debug = (bool) ($_SERVER['APP_DEBUG'] ?? ('prod' !== $env));

if ($debug) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts(explode(',', $trustedHosts));
}




//$f = file(__DIR__."/../models/SysUrls.php");
//var_dump($f);
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array( __DIR__."/../models"), $isDevMode, null, null, false);
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'kznew',
    'charset'  => 'UTF8',
);
$em = EntityManager::create($dbParams, $config);
$pdo = $em->getConnection();
$param = array("template" => "bscwarn");
$list = $em->find('SysUrls', 1);
//$urls = $em->getRepository('SysUrls')->findBy($param);









//var_dump((new Test())->test);
$conn = Proxy::init()->initDoctrine()->getPdo();
$em = Proxy::init()->initDoctrine()->getDoctrine();
//$q = $conn->prepare("SELECT * FROM sys_urls");
//$q->execute();
//$r = $q->fetchAll();
//var_dump($r);
$param = array("template" => "bscwarn");
//$list = $em->find('SysUrls', 1);
//$urls = $em->getRepository('SysUrls')->findBy($param);
//var_dump($urls);
//var_dump($list);
$app = new Silex\Application();

$app->get('/blog', function () {
    return 'Zxzs';
});

$app->run();

//$kernel = new Kernel($env, $debug);
//$request = Request::createFromGlobals();
//var_dump($request->getPathInfo());
//var_dump((new Loader())->test);
//$response = $kernel->handle($request);
//$response->send();
//$kernel->terminate($request, $response);
