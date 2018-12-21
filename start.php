<?php
/**
 * run with command
 * php start.php start
 * @author Peak Xin <xinyflove@sina.com>
 */

ini_set("display_errors","On");// 显示报错信息
error_reporting(E_ALL);// 错误级别
use Workerman\Worker;

if(strpos(strtolower(PHP_OS), 'win') === 0)
{
    exit("Dot support Windows, please use in Linux.");
}

// 检查扩展
if(!extension_loaded('pcntl'))
{
    exit("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html");
}
if(!extension_loaded('posix'))
{
    exit("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html");
}

// 标记是全局启动
define('GLOBAL_START', 1);

require_once __DIR__ . '/vendor/autoload.php';

// 加载所有Applications/*/start.php，以便启动所有服务
foreach(glob(__DIR__.'/Applications/*/start*.php') as $start_file)
{
    require_once $start_file;
}
// 运行所有服务
Worker::runAll();