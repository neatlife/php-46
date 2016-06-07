<?php

namespace app\controller\frontend;


use core\Controller;
use app\model\IComment as ICommentModel;

class IComment extends Controller
{
    // 添加评论
    public function add()
    {
        if (!isset($_SESSION['loginFlag'])) {// 如果session里的loginFlag不存在，即是未登录
            $_SESSION['loginFlag'] = false;
        }
        if ($_SESSION['loginFlag'] == false) {// 判断有没有登录
            return $this->_redirect("必须登录后评论", '?c=User&p=backend&a=login');
        }

        if (ICommentModel::model()->insert(array(
            'user_id' => $_SESSION['user']['id'],
            'publish_time' => time(),
            // 'content' => $_POST['txaArticle'],
            'content' => htmlspecialchars(addslashes($_POST['txaArticle'])),
            'reply_id' => $_POST['inpRevID'],
            'article_id' => $_POST['a_id'],
        ))) {
            return $this->_redirect('评论成功。', '?p=frontend&c=Article&a=view&id=' . $_POST['a_id']);
        } else {
            return $this->_redirect('评论失败', '?p=frontend&c=Article&a=view&id=' . $_POST['a_id']);
        }
    }
}















