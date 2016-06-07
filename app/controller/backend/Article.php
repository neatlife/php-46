<?php

namespace app\controller\backend;

use app\model\Category;
use core\Controller;
use app\model\Article as ArticleModel;
use vendor\Pager;

class Article extends Controller
{
    public function add()
    {
        var_dump($_SESSION['user']);
        // if (!empty($_POST)) {
        // if (isset($_POST['submit'])) {
        if ($_POST) {
            // var_dump($_POST);die;
            if (ArticleModel::model()->insert(array(
                'name' => $_POST['Title'],
                // 可能存在xss攻击 <script></script>被浏览器执行
                // <script></script>
                'content' => str_replace('</script>', '', str_replace('<script>', '', $_POST['Content'])),
                // 'content' => htmlspecialchars($_POST['Content']),// <script></script> ==> &lt;script&gt;&lt/script&gt;
                'category_id' => $_POST['CateID'],
                'status' => $_POST['Status'],
                // 'publish_date' => $_POST['PostTime'],
                'publish_date' => strtotime($_POST['PostTime']),
                // 'is_top' => isset($_POST['isTop']) ? $_POST['isTop'] : 2
                // 更加容易理解代码
                'is_top' => isset($_POST['isTop']) ? 1 : 2,
                // 'user_id' => 当前用户的id,
                'user_id' => $_SESSION['user']['id'],
            ))) {
                return $this->_redirect('添加成功', '?c=Article&p=backend&a=index');
            } else {
                return $this->_redirect('添加失败', '?c=Article&p=backend&a=add');
            }
        } else {
            $categorys = Category::model()->noLimitCategory(Category::model()->findAll());
            return $this->_loadHtml('article/add', array(
                'categorys' => $categorys,
            ));
        }
    }

    public function index()
    {
        var_dump($_POST);
        // 0表示不加这个条件，我们自己规定的。
        $status = isset($_POST['status']) ? $_POST['status'] : 0;
        $categoryId = isset($_POST['category']) ? $_POST['category'] : 0;
        // 没有istop表示（置顶+不置顶的文章）
        // sql语句条件：不置顶的条件和不加置顶条件谁优先？
        // $isTop = isset($_POST['istop'])? 1 : 2;
        // 不置顶: SELECT * FROM article WHERE is_top=2
        // 不加置顶条件： SELECT * FROM article
        $isTop = isset($_POST['istop'])? $_POST['istop'] : 0;
        $name = isset($_POST['search']) ? $_POST['search'] : '';

        // $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $size = isset($_GET['size']) ? $_GET['size'] : 10;// 一页显示几条数据。
        $page = isset($_GET['page']) ? $_GET['page'] : 1;// 当前第几页
        $start = ($page - 1)* $size;

        // 生成分页的按钮
        $pager = new Pager(ArticleModel::model()->count(), $size, $page, '', array(
            'p' => 'backend',
            'c' => 'Article',
            'a' => 'index',
            'size' => $size,
        ));

        $articles = ArticleModel::model()->getList($status, $categoryId, $isTop, $name, $start, $size);
        $categorys = Category::model()->noLimitCategory(Category::model()->findAll());
        return $this->_loadHtml('article/index', array(
            'articles' => $articles,
            'categorys' => $categorys,
            'pagerHtml' => $pager->showPage(),
        ));
    }
}