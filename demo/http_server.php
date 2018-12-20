<?php

// 使用HTTP协议对外提供Web服务

//require_once __DIR__ . '/vendor/autoload.php';
use Workerman\Worker;
require_once '../vendor/workerman/workerman/Autoloader.php';

// #### http worker ####
// 创建一个Worker监听2345端口，使用http协议通讯
$http_worker = new Worker("http://0.0.0.0:2345");

// 4 processes
// 启动4个进程对外提供服务
$http_worker->count = 4;

// Emitted when data received
// 接收到浏览器发送的数据时回复hello world给浏览器
$http_worker->onMessage = function($connection, $data)
{
    // $_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER, $_FILES are available
    var_dump($_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER, $_FILES);
    // send data to client
    $connection->send("hello world \n");
};

// run all workers
Worker::runAll();