<?php

use Swoole\Http\Server;

$server = new Server("127.0.0.1", 9501);

$server->set(array(
  'timeout' => 1,  //select and epoll_wait timeout.
  'poll_thread_num' => 1, //reactor thread num
  'worker_num' => 1, //reactor thread num
  'backlog' => 128,   //listen backlog
   // 'max_conn' => 10000,
  'dispatch_mode' => 2,
   //'open_tcp_keepalive' => 1,
  //  'daemonize' => true,
  'log_file' => __DIR__ . '/storage/logs/swoole.log', //swoole error log
));

$app = require_once("bootstrap/app.php");

$server->on('request', function ($request, $response) use ($app){
  $app['req'] = $request;
  $app['res'] = $response;
  $_GET['_url'] = $request->server['request_uri'];

  $app->handle();
});

$server->start();
