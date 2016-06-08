<?php

namespace app\controller\frontend;


use core\Controller;
use app\model\IComment as ICommentModel;

class IComment extends Controller
{
    // 添加评论
    public function add()
    {
        $this->denyAccess();

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















