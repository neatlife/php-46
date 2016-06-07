<?php

namespace app\model;


use core\Model;

class Category extends Model
{
    public function getTableName()
    {
        return 'category';
    }

    // 只查出了parent_id=0的顶级分类
//    public function noLimitCategory($categorys)
//    {
//        static $noLimitCategory = array();
//
//        foreach($categorys as $category) {
//            if ($category['parent_id'] == 0) {
//                $category['level'] = 0;
//                $noLimitCategory[] = $category;
//            }
//        }
//        return $noLimitCategory;
//    }
    public function noLimitCategory($categorys, $parentId=0, $level = 0)
    {
        static $noLimitCategory = array();

        foreach($categorys as $category) {
            if ($category['parent_id'] == $parentId) {
                $category['level'] = $level;
                $noLimitCategory[] = $category;
                // 可能有儿子分类, 先把儿子分类找完, 儿子分类的parent_id等于当前这个category的id
                // $this->noLimitCategory($categorys, $category['id'], $level + 1);
                $this->noLimitCategory($categorys, $category['id'], $level + 1);
            }
        }
        return $noLimitCategory;
    }

    // 获取带有文章数的分类数据
    public function getList()
    {
        $sql = "SELECT category.*, count(article.id) AS article_count
                  FROM category
                  LEFT JOIN article
                  ON category.id=article.category_id
                  GROUP BY category.id, article.category_id";
        return $this->getAll($sql);
    }
}