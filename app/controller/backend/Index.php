<?php

namespace app\controller\backend;

use core\Controller;

class Index extends Controller
{
    public function __construct()
    {
        $this->denyAccess();
    }

    // 后台首页，后台首页-骨架.html
    public function index()
    {
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