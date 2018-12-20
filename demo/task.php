<?php

// 不执行任何监听的Worker容器，用来处理一些定时任务

use Workerman\Worker;
use Workerman\Lib\Timer;
require_once '../vendor/workerman/workerman/Autoloader.php';

$task = new Worker();
$task->onWorkerStart = function($task)
{
    // 每2.5秒执行一次
    $time_interval = 2.5;
    Timer::add($time_interval, function()
    {
        echo "task run\n";
    });
};

// 运行worker
Worker::runAll();