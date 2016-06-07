<?php
/**
 * Article.php
 * Created by day5.
 * User: 苏小林
 * Date: 2016/5/13
 * Time: 10:30
 */

namespace app\controller\frontend;


use app\model\Category;
use app\model\IComment;
use core\Controller;
use app\model\Article as ArticleModel;
use vendor\Pager;

class Article extends Controller
{
    public function index()
    {
        var_dump($_POST);

        // $_GET, $_POST 都有q参数
        // $_REQUEST = $_GET + $_POST
        // $q = isset($_POST['q']) ? $_POST['q'] : '';
        // $q = isset($_GET['q']) ? $_GET['q'] : '';
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';

        $size = 2;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $where = "name like '%{$q}%'";
        $pager = new Pager(ArticleModel::model()->count($where), $size, $page, '', array(
            'p' => 'frontend',
            'a' => 'index',
            'c' => 'Article',
            'size' => $size,
            'q' => $q,
        ));
        $pagerButtons = $pager->showPage();
        // echo $pagerButtons;die;

        $start = ($page - 1) * $size;
        $articles = ArticleModel::model()->getList(0, 0, 0, $q, $start, $size);
        // var_dump($articles);die;
//        return $this->_loadHtml('article/index', array(
//            'articles' => $articles,
//        ));
        $categorys = Category::model()->noLimitCategory(Category::model()->findAll());
        $this->_smarty->assign('articles', $articles);
        $this->_smarty->assign('categorys', $categorys);
        $this->_smarty->assign('pagerButtons', $pagerButtons);
        // smarty里的html文件暂时必须写html结束
        $this->_smarty->display('article/index.html');
    }

    public function view()
    {
        // 增加阅读数
        $id = $_GET['id'];
        ArticleModel::model()->increaseRead($id);
        $article = ArticleModel::model()->getArticleById($id);
        // var_dump($article);
        // 查出文章id(icomment.article_id)为 $id 的所有评论
        $icomments = IComment::model()->getICommentsByArticleId($id);
//        echo '<pre>';
//        print_r($icomments);
        $icomments = IComment::model()->noLimitIComment($icomments);
        // print_r($icomments);die;
        $this->_smarty->assign('icomments', $icomments);
        $this->_smarty->assign('article', $article);
        $this->_smarty->display('article/view.html');
    }

    public function good()
    {
        // 增加赞
//        var_dump($_GET);
//        if (赞成功) {
//            提示成功，跳转到当前赞的博客的博客的详情页
//        } else {
//              提示失败，跳转到当前赞的博客的博客的详情页
//        }
          $id = $_GET['id'];
          // if (没有赞过) {
          //if (判断session里有没有赞过的标记) {
          if (!isset($_SESSION['good_' . $id])) {
              if (ArticleModel::model()->increaseGood($id)) {
                  //提示成功，跳转到当前赞的博客的博客的详情页
                  // 在session里放一个赞过的标记
                  $_SESSION['good_' . $id] = true;
                  return $this->_redirect('点赞成功', '?p=frontend&c=Article&a=view&id=' . $id);
              } else {
                  // 提示失败，跳转到当前赞的博客的博客的详情页
                  return $this->_redirect('点赞失败', '?p=frontend&c=Article&a=view&id=' . $id);
              }
          } else {
              // 提示已赞，不能重复点赞，跳转到当前赞的博客的博客的详情页
              return $this->_redirect('已赞，不能重复点赞', '?p=frontend&c=Article&a=view&id=' . $id);
          }
    }
}