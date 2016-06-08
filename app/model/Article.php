<?php

namespace app\model;

use core\Model;

class Article extends Model
{
    public function getTableName()
    {
        return 'article';
    }

    // 查询所有的文章
    // 1. 同时查询出分类的名称
    // 默认值为0的参数表示不添加这个条件
    // public function getList($status = 2, $categoryId = 0)
    public function getList($status = 0, $categoryId = 0, $isTop = 0, $name = '', $start = 0, $size = 10)
    {
//        $sql = "SELECT article.*, category.name as category_name
//                  FROM article
//                  LEFT JOIN category
//                    ON article.category_id=category.id";
        // 错误原因：下面的sql语句因为连接了第二张表，但是where条件中的字段没有表明
        //  SELECT article.*, category.name as category_name
        //  FROM article LEFT JOIN category
        //  ON article.category_id=category.id
        //  WHERE status=2 AND category_id=5 AND is_top=1 AND name LIKE '%PHP%'

        // 下面的才是正确的
        //  SELECT article.*, category.name as category_name
        //      FROM article
        //      LEFT JOIN category ON article.category_id=category.id
        //      WHERE article.status=2 AND article.category_id=19 AND article.is_top=1 AND article.name LIKE '%PHP%'\G
        $sql = "SELECT article.*, category.name as category_name, user.username
                FROM article
                LEFT JOIN category ON article.category_id=category.id
                LEFT JOIN user ON article.user_id=user.id
                WHERE 2 > 1";
        // article.status={$status} AND article.category_id={$categoryId} AND article.is_top={$isTop} AND article.name LIKE '%{$name}%'
        if ($status != 0) {
            $sql .= " AND article.status={$status}";
        }
        if ($categoryId != 0) {
            $sql .= " AND article.category_id={$categoryId}";
        }
        if ($isTop != 0) {
            $sql .= " AND article.is_top={$isTop}";
        }
        if ($name != '') {
            $sql .= " AND article.name LIKE '%{$name}%'";
        }
        if ($size != 0) {
            $sql .= " limit {$start}, {$size}";
        }
        //echo $sql;
        return $this->getAll($sql);
    }

    public function getArticleById($id)
    {
        $sql = "SELECT article.*, user.username, category.name AS category_name, count(icomment.id) AS icomment_count
                  FROM article
                    LEFT JOIN  user ON article.user_id=user.id
                    LEFT JOIN category ON article.category_id=category.id
                    LEFT JOIN icomment ON article.id=icomment.article_id
                       WHERE article.id={$id} GROUP BY article.id";
        return $this->getOne($sql);
    }

    // 增加一个阅读数
    public function increaseRead($id)
    {
        $sql = "UPDATE `article` SET `read`=`read`+1 WHERE id={$id};";
        return $this->exec($sql);
    }

    // 增加一个赞
    public function increaseGood($id)
    {
        $sql = "UPDATE `article` SET `good`=`good`+1 WHERE id={$id}";
        return $this->exec($sql);
    }
}