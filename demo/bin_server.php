<?php

use Workerman\Worker;
require_once '/vendor/workerman/workerman/Autoloader.php';

$worker = new Worker('BinaryTransfer://0.0.0.0:8333');
// 保存文件到tmp下
$worker->onMessage = function($connection, $data)
{
    $save_path = 'tmp/'.$data['file_name'];
    $l = file_put_contents($save_path, $data['file_data']);
    if($l)
    {
    	$connection->send("upload success. save path $save_path");
    }
    else
    {
		$connection->send("upload failure.");
    }
};

Worker::runAll();