<?php
if (!session_id()) @session_start();

require '../vendor/autoload.php';

use DI\ContainerBuilder;
use League\Plates\Engine;
use Delight\Auth\Auth;
use App\Db;
use PDO;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Engine::class => function () {
        return new Engine(__DIR__ . '/../app/views');
    },
    
    Auth::class => function ($container) {
        return new Auth($container->get(Db::getInstance()->pdo));
    },
    
    \PDO::class => function () {
        return Db::getInstance()->pdo;
    },
]);
$container = $containerBuilder->build();


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\controllers\HomeController', 'index']);
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/read/{id:\d+}', ['App\controllers\HomeController', 'read']);
    $r->addRoute('GET', '/edit/{id:\d+}', ['App\controllers\HomeController', 'edit']);
    $r->addRoute('POST', '/edit/edit-post', ['App\controllers\HomeController', 'editPost']);
    $r->addRoute('GET', '/create', ['App\controllers\HomeController', 'create']);
    $r->addRoute('POST', '/create-post', ['App\controllers\HomeController', 'createPost']);
    $r->addRoute('GET', '/delete/{id:\d+}', ['App\controllers\HomeController', 'delete']);
    $r->addRoute('GET', '/register', ['App\controllers\UserController', 'register']);
    $r->addRoute('POST', '/create-user', ['App\controllers\UserController', 'createUser']);
    $r->addRoute('GET', '/confirm', ['App\controllers\UserController', 'confirm']);
    $r->addRoute('GET', '/login', ['App\controllers\UserController', 'login']);
    $r->addRoute('POST', '/login-user', ['App\controllers\UserController', 'loginUser']);
    $r->addRoute('GET', '/logout', ['App\controllers\UserController', 'logout']);
    
    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        include __DIR__ . '/../app/views/404.php';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        include __DIR__ . '/../app/views/405.php';
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        //$class = new $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];
        //d($container); die;
        //call_user_func([$class, $method], $vars);
        $container->call($routeInfo[1], [$routeInfo[2], $vars]);
        break;
}


