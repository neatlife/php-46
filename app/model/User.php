<?php
namespace app\model;

use core\Model;

/**
 * 用户模型
 */
class User extends Model
{
    public function getTableName()
    {
        return 'user';
    }
}