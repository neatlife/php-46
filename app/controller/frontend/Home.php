<?php
namespace app\controller\frontend;

// 导入core\Controller类到当前名字空间内
use core\Controller;
use core\Model;
use app\model\User;

class Home extends Controller
{
    public function index()
    {
        // echo 'Hello World.';
        //include './../app/view/frontend/index.html';
        $word = "友谊的小船说翻就翻2!";
        $word2 = "流星花园";
        //$word3 = "流星花园";
        // 函数的作用域
        //$this->_loadHtml('index');
        // 下面一行写法可以，但是非常不灵活
        // $this->_loadHtml('index', $word, $word2);
        // $this->_loadHtml('index', $word, $word2);
        $this->_loadHtml('index', array(// 效果和require别无二致
            'icword' => $word,
            'icword2' => $word2,
            'itcast' => '键盘打烂,月薪过万。',
        ));
        // 错误写法：require '../../view/frontend/index.html';
        // require不是函数
        // require '../app/view/frontend/index.html';
    }

    public function fish()
    {
        //include './../app/view/frontend/index.html';
        $this->_loadHtml('index');
        $this->_redirect('你今天吃药了吗？', 'index.php?c=Home&p=frontend&a=index');
    }

    public function pdotest()
    {
//        $model = new Model();
//        $users = $model->getAll("SELECT * FROM user WHERE 2 > 1");
//        //$users = $model->getXxx("2 > 1");
//        var_dump($users);
//
        $userModel = new User();
//        var_dump($userModel->insert(array(
//            'username' => '关羽',
//            'nickname' => '云长',
//            'email' => 'yc@qq.com',
//        )));
//        $userModel->updateById(3, array(
//            '字段名' => '字段值..',
//            '字段名' => '字段值..',
//        ));
        var_dump($userModel->updateById(3, array(
            'username' => '关羽2',
            'nickname' => '云长2',
            'email' => 'yc@qq.com2',
        )));
//        $users = $userModel->findAll('id in (1)');
//        var_dump($users);

//        insert()
//        array(
//            '字段名' => '值',
//            '字段名2' => '值',
//            '字段名3' => '值',
//            '字段名4' => '值',
//            '字段名5' => '值',
//        );
    }

    public function test()
    {
        for ($i = 0; $i < 100000000; $i ++) {

        }
        echo '111' . $i;
    }

    public function info()
    {
        //1462765785
        echo date('Y-m-d H:i:s', 1462765785) . '<br />';
        // phpinfo();
        echo max(1000, 200, 3, 4000, 50000);
    }
}