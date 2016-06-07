<?php

//namespace xxx {
//    class PDO
//    {
//
//    }
//}

// 在名字空间的根空间下面的__autoload
//function __autoload($className)
//{
//    echo str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
//}
//
//$a = new \core\App();
//
//
//die;
// 注释: ctrl + /

// 包含我们封装的类
require '../core/App.php';

// 将core空间里的App类导入到当前空间
use core\App;

// session_start(); 没有体现oop的封装思想
App::run();