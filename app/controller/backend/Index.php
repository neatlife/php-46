<?php

namespace app\controller\backend;

use core\Controller;

class Index extends Controller
{
    // 后台首页，后台首页-骨架.html
    public function index()
    {
        // var_dump($_SESSION['user']);
        // session_start();
        //if ($loginFlag) {// 判断有没有登录
        //    return $this->_redirect("必须登录", '?c=User&p=backend&a=login')
        //}
        if (!isset($_SESSION['loginFlag'])) {// 如果session里的loginFlag不存在，即是未登录
            $_SESSION['loginFlag'] = false;
        }
        if ($_SESSION['loginFlag'] == false) {// 判断有没有登录
            return $this->_redirect("必须登录", '?c=User&p=backend&a=login');
        }
        return $this->_loadHtml('index/index');
    }

    // 顶部
    public function top()
    {
        return $this->_loadHtml('index/top');
    }

    // 左侧菜单
    public function menu()
    {
        return $this->_loadHtml('index/menu');
    }

    // 着陆页
    public function content()
    {
        return $this->_loadHtml('index/content');
    }
}