<?php
namespace app\controller\backend;

use core\Controller;
//use app\model\User;
use app\model\User as UserModel;// 和我们控制器名字冲突，我们给导入的类重命名
use vendor\Captcha;
use vendor\Pager;

class User extends Controller
{
    public function index()
    {
        $this->denyAccess();
        // 用户列表 控制器 => 用户控制器里的列表

        // 连接数据库
        // mysql_connect('127.0.0.1', 'root', 'hahaha');
// 设置字符集 保持和mysql服务器字符集的一致性
        // $sql = "SET NAMES utf8";
        //mysql_query($sql);// 将我们的sql语句传送到mysql服务器上面
// 选择数据库
        // mysql_select_db('userlist2');
        $userModel = UserModel::model();

        // 分页
        $size = isset($_GET['size']) ? $_GET['size'] : 2;// 一页显示几条数据。
        $page = isset($_GET['page']) ? $_GET['page'] : 1;// 当前第几页
        $start = ($page - 1)* $size;

        // 生成分页的按钮
        $pager = new Pager(UserModel::model()->count(), $size, $page, '', array(
            'p' => 'backend',
            'c' => 'User',
            'a' => 'index',
            'size' => $size,
        ));

        // 拿出用户表的所有数据
        // $sql = "SELECT * FROM user WHERE 2 > 1;";
        // $resultResource = mysql_query($sql);
        // $user = mysql_fetch_assoc($resultResource);
        // mysql_fetch_assoc 一次调用只会拿去一条记录
        // $users = array();
        //while ($user = mysql_fetch_assoc($resultResource)) {
        //    $users[] = $user;
        //}
        // $users = $userModel->findAll('2 > 1');
        $users = $userModel->findAll('2 > 1', $size, $start);
        //var_dump($users);

        // 包含文件：require require_once include include_once
        // require 'userlist.html';
        $this->_loadHtml('user/userlist', array(
            //'users1' => $users,
            'users' => $users,
            'pagerHtml' => $pager->showPage(),
        ));
    }

    public function delete()
    {
        $this->denyAccess();
        // 用户删除 动作(原始的控制器？)

        // 链接数据库
        // mysql_connect('127.0.0.1', 'root', 'hahaha');
        // mysql_query('SET NAMES utf8');
        // mysql_select_db('userlist2');
        $userModel = UserModel::model();

        $id = $_GET['id'];

        //$sql = "delete from user where id='$id'";
        //if (mysql_query($sql) === true) {
        //    echo "<script>alert('{$id}　删除成功')</script>";
        //} else {
            // addslashes：转义单引号(双引号也可以)
        //    $errorno = addslashes(mysql_error());
        //    echo "<script>alert('{$id}　添加失败, 错误代码: {$errorno}')</script>";
        //}
        //header('location: userlist.php');
        if ($userModel->deleteById($id)) {
            return $this->_redirect("{$id}　删除成功", '?c=User&p=backend&a=index');
        } else {
            return $this->_redirect("{$id}　删除失败", '?c=User&p=backend&a=index');
        }
    }

    public function add()
    {
        $this->denyAccess();
        // 添加用户的控制器
        // root

        var_dump($_POST);

        if (!empty($_POST)) {
            // 链接数据库
            // mysql_connect('127.0.0.1', 'root', 'hahaha');
            // mysql_query('SET NAMES utf8');
            // mysql_select_db('userlist2');
            $userModel = UserModel::model();
            // $sql = "INSERT INTO user VALUES (null, '{$_POST['Name']}', '{$_POST['Alias']}', '{$_POST['Email']}', 0, '')";
            /**
             * mysql_query会在成功时返回true， 失败时返回false
             */
            // if (mysql_query($sql) === true) {
            //    echo "<script>alert('{$_POST['Name']}　添加成功')</script>";
             //   header('location: userlist.php');
            //} else {
                // addslashes：转义单引号(双引号也可以)
            //    $errorno = addslashes(mysql_error());
            //    echo "<script>alert('{$_POST['Name']}　添加失败, 错误代码: {$errorno}')</script>";
            //}
            if ($userModel->insert(array(
                'username' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'email' => $_POST['Email'],
                'password' => md5(md5($_POST['Password'])),
            ))) {
                // userlist.php => ?c=User&p=backend&a=index
                return $this->_redirect("{$_POST['Name']}　添加成功", '?c=User&p=backend&a=index');
            } else {
                // 添加失败留在添加页面
                return $this->_redirect("{$_POST['Name']}　添加失败", '?c=User&p=backend&a=add');
            }
        }

        // require 'useradd.html';
        $this->_loadHtml('user/useradd');
    }

    public function edit()
    {
        $this->denyAccess();
        // 修改用户的控制器

        var_dump($_POST);

        // 链接数据库
        // mysql_connect('127.0.0.1', 'root', 'hahaha');
        // mysql_query('SET NAMES utf8');
        // mysql_select_db('userlist2');
        $userModel = UserModel::model();

        $id = $_GET['id'];
        if (!empty($_POST)) {
            // UPDATE user SET 字段名=字段值，字段名2=字段值2 。。。。。WHERE 条件字段=条件值
            //$sql = "UPDATE user SET username='{$_POST['Name']}', nickname='{$_POST['Alias']}', email='{$_POST['Email']}' WHERE id='{$id}'";
            /**
             * mysql_query会在成功时返回true， 失败时返回false
             */
            //if (mysql_query($sql) === true) {
            //    echo "<script>alert('{$_POST['Name']}　修改成功')</script>";
            //    header('location: userlist.php');
            //} else {
            //    // addslashes：转义单引号(双引号也可以)
            //    $errorno = addslashes(mysql_error());
            //    echo "<script>alert('{$_POST['Name']} 修改失败, 错误代码: {$errorno}')</script>";
            //}
            // 啥也没改 if (0) {
            if ($userModel->updateById($id, array(
                'username' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'email' => $_POST['Email'],
            ))) {
                return $this->_redirect("{$_POST['Name']}　修改成功", '?c=User&p=backend&a=index');
            } else {
                return $this->_redirect("{$_POST['Name']} 修改失败", '?c=User&p=backend&a=edit&id=' . $id);
            }
        }

        // $sql = "SELECT * FROM user WHERE id='{$id}'";
        // $resultResource = mysql_query($sql);
        // var_dump($resultResource);
        // $user = mysql_fetch_assoc($resultResource);
        $user = $userModel->findById($id);
        var_dump($user);

        // require 'useredit.html';
        $this->_loadHtml('user/useredit', array(
            'user' => $user,
        ));
    }

    public function login()
    {
        return $this->_loadHtml('user/login');
    }

    public function loginCheck()
    {
        //var_dump($_POST);die;
        // 检查验证码
//        if (验证码错误) {
//            return $this->_redirect('验证码错误。', '?c=User&p=backend&a=login');
//        }
        if ($_POST['edtCaptcha'] != $_SESSION['captchaCode']) {
            return $this->_redirect('验证码错误。', '?c=User&p=backend&a=login');
        }

        // session_start();
        //var_dump($_POST);
        $userModel = UserModel::model();
        // 转义单引号
        $_POST['username'] = addslashes($_POST['username']);
        $user = $userModel->find("password='{$_POST['password']}' AND username='{$_POST['username']}'");
        //var_dump($user);die;
        if ($user != false) {// 找到了用户，登录成功
            // 由于普通变量不能跨请求保存，所以我们使用SESSION保存登录成功的标记
            // $loginFlag = true;
            $_SESSION['loginFlag'] = true;
            $_SESSION['user'] = $user;
            // 更新用户的last_login_time字段
            $userModel->updateById($user['id'], array(
                'last_login_time' => time(),
                'last_login_ip' => $_SERVER['REMOTE_ADDR'],
            ));
            return $this->_redirect("登录成功", '?c=Index&p=backend&a=index');
        } else {// 没找到用户,登录失败
            //$loginFlag = false;
            $_SESSION['loginFlag'] = false;
            return $this->_redirect("登录失败", '?c=User&p=backend&a=login');
        }
    }

    // 用户退出登录
    public function logout()
    {
        $this->denyAccess();
        // echo 'hahaha';
        // 登录是因为$_SESSION['loginFlag'] 等于 true;
        // 退出就回到没有登录的状态，是因为$_SESSION['loginFlag'] 等于 false
        $_SESSION['loginFlag'] = false;
        // 直接销毁session，loginFlag也会消失
        // session_destroy();

        // 跳转到登录页
        return $this->_redirect('今天没吃药，感觉自己萌萌哒。', '?c=User&p=backend&a=login');
    }

    // 动态的生成验证码图片
    public function captcha()
    {
        // 生成图片
        $captcha = new Captcha();
        $captcha->generateCode();
        // 获取真正的验证码的小写的字符串
        $_SESSION['captchaCode'] = $captcha->getCode();
    }
}