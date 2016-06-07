<?php
namespace core;

use vendor\Smarty;

/**
 * 核心控制器
 */
class Controller
{
    // smarty的对象
    protected $_smarty;

    public function __construct()
    {
        $this->_initSmarty();
    }

    public function _initSmarty()
    {
        // require 'libs/Smarty.class.php';

        $s = new Smarty();

        // 自定义定界符
        // 修改左定界符
        $s->left_delimiter = '<{';
        // 修改右定界符
        $s->right_delimiter = '}>';

        // templates --> view 修改默认的html文件夹目录
        $s->setTemplateDir(ROOT . DS . 'app' . DS . 'view' . DS . PLATFORM);
        // 修改templates_c文件夹的文件夹名
        // 放在系统的临时目录
        // 获取当前系统的临时目录 windows: C:\WINDOWS\TEMP linux: /tmp
        // echo sys_get_temp_dir();die;
        $s->setCompileDir(sys_get_temp_dir() . DS . 'view_c');
        // 别的目录能不能修改呢？
        $this->_smarty = $s;
    }

    //下面这个方法，用于在需要的时候进行“显示信息并跳转”
    protected function _redirect($msg, $url = '?', $time = 3, $type = 2)
    {
        //if ($type == 2) {
        //    include ROOT . DS . 'app' . DS . 'view' . DS . 'redirect.html';
        //} else {
            // header('refresh:2; url=userlist.php')
            echo "<h1>$msg</h1>";
            header("refresh:{$time}; url={$url}");
        //}
    }

    // protected function _loadHtml($file, $word, $word2)
    // protected function _loadHtml($file, $word, $word2, $word3)
    protected function _loadHtml($file, $data = array())
    {
        /*
         * array(
         *  "友谊的小船说翻就翻2!",
         *  "流星花园"
         * ),
         *
         * array(
         *  "word" => "友谊的小船说翻就翻2!",
         *  "word2" => "流星花园"
         * ),
         */
        // $word = $data['word'];
        // $word2 = $data['word2'];
        // foreach ($data as $key => $value) {
        //     // 解决重点，声明可变变量
        //    $$key = $value;
        // }
        extract($data);// 少写了2行代码,和上面3行代码效果一样。
        //include './../app/view/frontend/index.html';
        //include './../app/view/' . PLATFORM . '/index.html';
        // include './../app/view/' . PLATFORM . '/' . $file . '.html';
        // include 'c:\xxx\xxx\xxx\a\b\c./../app/view/' . PLATFORM . '/' . $file . '.html';
        include ROOT . '/app/view/' . PLATFORM . '/' . $file . '.html';
    }
}