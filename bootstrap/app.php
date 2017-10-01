<?php

require "vendor/autoload.php";

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection as MicroCollection;
use App\Http\Controllers\UsersController;
use Phalcon\Di\FactoryDefault;

$app = new Micro();

$app['view'] = function() {
    $view = new \Phalcon\Mvc\View\Simple();
    $view->setViewsDir('views/');
    return $view;
};

$app['session'] = function () {
    $session = new Phalcon\Session\Adapter\Files();
    $session->start();
    return $session;
};

$app['db'] = function () {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(
        [
            'host'     => '127.0.0.1',
            'username' => 'root',
            'password' => 'root',
            'dbname'   => 'play',
        ]
    );
};

$app->get('/', function() use ($app){
  $app->res->end(
      $app->view->render("home")
  );
});

$app->get('/favicon.ico', function() use ($app){
  $app->res->end('');
  exit;// must add exit
});

$users = new MicroCollection();
$users->setHandler(UsersController::class, true);
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

$app->notFound(
    function () use ($app) {
        $app->response->setStatusCode(404, 'Not Found');
        $app->response->sendHeaders();

        $app->res->end('Nothing to see here. Move along....');
    }
);

return $app;
