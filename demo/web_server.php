<?php

// WebServer

require_once __DIR__ . '/vendor/autoload.php';
use Workerman\WebServer;
use Workerman\Worker;

// WebServer
$web = new WebServer("http://0.0.0.0:80");

// 4 processes
$web->count = 4;

// Set the root of domains
$web->addRoot('test1.com', '/demo/www/web1');
$web->addRoot('test2.com', '/demo/www/web2');
// run all workers
Worker::runAll();