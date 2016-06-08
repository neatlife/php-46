<?php

namespace core;

class App
{
    public static $config;

    public static function run()
    {
        // 打开session
        self::_openSession();
        // 定义路径常量
        self::_defineDirConst();
        // 设置网站全局的字符集
        self::_initialCharset();
        // 自定义php引擎的行为（改配置）
        self::_adaterSystem();
        // 加载配置文件
        self::_loadConfig();
        // 自动加载
        self::_registerAutoloader();
        // 解析url(解析路由)
        self::_defineRouteConst();
        // 分发
        self::_dispatchRoute();
    }

    // protected function _openSession() E_Strict级别的错误
    protected static function _openSession()
    {
        session_start();
    }

    protected static function _defineDirConst()
    {
        //DIRECTORY_SEPARATOR是系统通常，代表“目录分隔符”，可能是“/”，或“\”，跟操作系统有关！
        define("DS", DIRECTORY_SEPARATOR);
        define("ROOT",  __DIR__ . DS . '..');	//当前项目的开始路径
        define('CONFIG_PATH', ROOT . DS. 'app' . DS . 'config');
    }

    protected static function _loadConfig()
    {
        // 将app/config/config.php加载进来
        require CONFIG_PATH . DS . 'config.php';

        self::$config = $config;
    }

    protected static function _adaterSystem()
    {
        error_reporting(E_ALL); // 0表示不报告任何错误 1024报告任何错误
        ini_set('display_errors', 'On');// 是否显示报告的错误， on显示，off是不现实
    }

    protected static function _initialCharset()
    {
        header('Content-type: text/html;charset=utf-8');
    }

    /**
     * 定义路由常量
     */
    protected static function _defineRouteConst()
    {
        $p = isset($_GET['p']) ? $_GET['p'] :"frontend";// 平台
        $c = isset($_GET['c']) ? $_GET['c'] :"Article"; // 控制器
        $a = isset($_GET['a']) ? $_GET['a'] :"index"; // 动过
        define("PLATFORM", $p);	//平台 platform
        define("CONTROLLER", $c);	// 控制器 controller
        define("ACTION", $a);
    }

    protected static function _registerAutoloader()
    {
        // spl_autoload_register函数可以将任意函数变成自动加载函数(包括匿名函数)
//        function __autoload($className)
//        {
//            echo $className;die(111);
//            require ROOT . DS . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
//        }
        /**
         * @param String $className 带有名字空间的类名 '\app\controller\frontend\Home' ===> app\controller\frontend\User
         */
        spl_autoload_register(function($className)
        {
            // app\controller\frontend\User 带有名字空间的类名
            //var_dump($className);
            // app\controller\frontend\User.php 加.php
            //var_dump($className . '.php');
            // ROOT . DS . 'app\controller\frontend\User.php' 加ROOT . DS
            //var_dump(ROOT);
            //var_dump(ROOT . DS . $className . '.php');
            // C:\wamp\www\day5\core\..\app\controller\frontend\User.php 结果1
            // C:\wamp\www\day5\app\controller\frontend\User.php 效果
            // die('end...2');
            $file = ROOT . DS . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
            if (is_file($file)) {
                require $file;
            }
        });
    }

    /**
     * 路由分发
     */
    protected static function _dispatchRoute()
    {
//        var_dump(new \app\controller\frontend\Home());
//        var_dump('\\app\\controller\\frontend\\Home');
//        var_dump('\\app\\controller\\' . PLATFORM . '\\Home');
//        var_dump('\\app\\controller\\' . PLATFORM . '\\' . CONTROLLER);
//        die('end...');
        //构建出来一个“控制器类名”
        $ctrl_name = '\\app\\controller\\' . PLATFORM . '\\' . CONTROLLER;
        $ctrl = new $ctrl_name();	//可变类，new完，得到对象
        $a = ACTION;
        $ctrl->$a();	//可变方法（函数）
    }
}
