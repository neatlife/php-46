<?php

namespace app\controller\backend;

use core\Controller;
use app\model\Category as CategoryModel;

class Category extends Controller
{
    // 分类的列表
    public function index()
    {
        // 1. 使用分类的模型查询出所有的分类
        $categoryModel = CategoryModel::model();
        // SELECT *, count(article.id) AS article_count
        //   FROM category
        //      LEFT JOIN article
        //   ON category.id=article.category_id
        // GROUP BY category.id, article.category_id
        $categorys = $categoryModel->getList();
        // 目标
        // 1. 重新按照级别排序, 2. 加上一个级别数 数字
        $categorys = $categoryModel->noLimitCategory($categorys, 0);
        // var_dump($categorys);die;
        // 2. 加载html页面
        return $this->_loadHtml('category/index', array(
            'categorys' => $categorys,
        ));
    }

    // 分类的删除
    public function delete()
    {
        // 1. 接收即将删除的分类的id
        $id = $_GET['id'];

        // 2. 调用数据库进行删除, 删除的时候，只能删除没有子分类的分类
        // (1 子分类数量是否等于0
        // $sql = "select count(*) from category where parent_id='{$id}';";
        // var_dump(CategoryModel::model()->count("parent_id='{$id}'"));
//        if (子分类数量==0) {
//            // 删除分类
//
//        } else {
//            // 由子分类，不能删除分类
//        }
        if (CategoryModel::model()->count("parent_id='{$id}'") == 0) {
            // 删除分类
            if (CategoryModel::model()->deleteById($id)) {
                // 删除成功
                return $this->_redirect('删除成功', '?c=Category&p=backend&a=index');
            } else {
                // 删除失败
                return $this->_redirect('删除失败', '?c=Category&p=backend&a=index');
            }
        } else {
            // 由子分类，不能删除分类
            return $this->_redirect('你想跑路吗？', '?c=Category&p=backend&a=index');
        }
    }

    public function add()
    {
        var_dump($_POST);

        // if (提交表单) {
        if ($_POST) {
            // 加入到数据库
            $category = array();
            $category['name'] = $_POST['Name'];
            $category['alias'] = $_POST['Alias'];
            $category['sort'] = $_POST['Order'];
            $category['parent_id'] = $_POST['ParentID'];

            // if (名称为空) {
            //     (1 提示名称不能为空
            //     (2 返回添加分类的页面
            // }
            if (!$_POST['Name']) {
                 // (1 提示名称不能为空
                // (2 返回添加分类的页面
                return $this->_redirect('名称不能为空', '?c=Category&p=backend&a=add');
            }

            if (CategoryModel::model()->insert($category)) {
                return $this->_redirect('添加分类成功', '?p=backend&c=Category&a=index');
            } else {
                return $this->_redirect('添加分类失败', '?p=backend&c=Category&a=add');
            }
        } else {
//        $categoryModel = new CategoryModel();
//        $categorys = $categoryModel->findAll();
//        $categorys = $categoryModel->noLimitCategory($categorys);
            $categorys = CategoryModel::model()->noLimitCategory(CategoryModel::model()->findAll());
            return $this->_loadHtml('category/add', array(
                'categorys' => $categorys,
            ));
        }
    }

    public function edit()
    {
        // $id = $_GET['id'];
        // $id = addslashes($_GET['id']);
        // $id = intval($_GET['id']);
        $id = (int) $_GET['id'];
        if ($_POST) {
            // var_dump($_POST);die;
            // 修改数据库
            if (CategoryModel::model()->updateById($id, array(
//                'name' => $_POST['Name'],
//                'alias' => $_POST['Alias'],
//                'sort' => $_POST['Order'],
//                'parent_id' => $_POST['ParentID'],
                'name' => addslashes($_POST['Name']),
                'alias' => addslashes($_POST['Alias']),
                'sort' => addslashes($_POST['Order']),
                'parent_id' => addslashes($_POST['ParentID']),
            ))) {
                return $this->_redirect('修改成功', '?c=Category&p=backend&a=index');
            } else {
                return $this->_redirect('修改失败', '?c=Category&p=backend&a=edit&id=' . $id);
            }
        } else {
            $category = CategoryModel::model()->findById($id);
            // var_dump($category);die;
            $categorys = CategoryModel::model()->noLimitCategory(CategoryModel::model()->findAll());
            return $this->_loadHtml('category/edit', array(
                'category' => $category,
                'categorys' => $categorys,
            ));
        }
    }
}