<?php

namespace app\controller\backend;


use core\Controller;
use app\model\IComment as ICommentModel;

class IComment extends Controller
{
    public function index()
    {
        $this->denyAccess();
        $icomments = ICommentModel::model()->limitlessLevel(
            ICommentModel::model()->getList()
        );
        // var_dump($icomments);die;

        return $this->_loadHtml('icomment/index', array(
            'icomments' => $icomments,
        ));
    }

    public function delete()
    {
        $this->denyAccess();
        $id = $_GET['id'];
        if (ICommentModel::model()->deleteById($id)) {
            // 删除成功
            return $this->_redirect('删除成功', '?c=IComment&p=backend&a=index');
        } else {
            // 删除失败
            return $this->_redirect('删除失败', '?c=IComment&p=backend&a=index');
        }
    }
}