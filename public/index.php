<?php

use App\Kernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use App\Testf\Test;
use App\Proxy;
//use App\Routing\Init;
use GuzzleHttp\Client;
//use Symfony\Component\Routing\Matcher\UrlMatcher;
//use Symfony\Component\Routing\RequestContext;
//use Symfony\Component\Routing\RouteCollection;
//use Symfony\Component\Routing\Route;




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

$kernel = new Kernel($env, $debug);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

//var_dump((new Test())->test);
//$conn = Proxy::init()->initDoctrine()->getConnecton();
//$em = Proxy::init()->initDoctrine()->getEntityManager();
//$q = $conn->prepare("SELECT * FROM sys_urls");
//$q->execute();
//$r = $q->fetchAll();
//var_dump($r);
//$param = array("template" => "bscwarn");
//$list = $em->find('SysUrls', 1);
//$urls = $em->getRepository('SysUrls')->findBy($param);
//var_dump($urls);
//var_dump($list);
//(new Init())->run();

/*
$route = new Route('/foo', array('_controller' => 'MyController'));
$routes = new RouteCollection();
$routes->add('route_name', $route);
$context = new RequestContext('/');
$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match('/foo');
*/
/*
$app = new Silex\Application();
$app->before(function (Request $request, Application $app) {
    return $app;
});
$app->get('/blog', function () {
    return 'Zxzs';
});
$app->get('', function () {
    return 'MAIN';
});
$app->run();
*/
