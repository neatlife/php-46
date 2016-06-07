<?php
namespace core;

use Exception;
/**
 * Class Model 核心模型
 * @package core
 */
class Model extends PDOWrapper
{
    public function __construct()
    {
        parent::__construct(App::$config['database']);
    }

    // static function model($model){
    /**
     * @param null $model
     * @return Model
     */
    static function model($model = null){
        static $obj = array();
        // 获取到当前调用的类名
        if ($model === null) {
            $model = get_called_class();
        }
        if(empty($obj[$model])){
            $obj[$model] = new $model();
        }
        return $obj[$model];
    }

    /**
     * 查询出所有的数据
     */
    public function findAll($where = '2 > 1')
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE {$where}";
        return $this->getAll($sql);
    }

    /**
     * 根据条件查出一行数据
     * @param string $where
     */
    public function find($where = '2 > 1')
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE {$where} LIMIT 1";
        //echo $sql;die;
        return $this->getOne($sql);
    }

    /**
     * 根据id查出一行数据
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id='{$id}'";
        return $this->getOne($sql);
    }

    /**
     * 插入一行数据
     *
     array(
    '字段名' => '值',
    '字段名2' => '值',
    '字段名3' => '值',
    '字段名4' => '值',
    '字段名5' => '值',
    );
     */
    public function insert($row)
    {
        $fields = '';
        $values = '';
        foreach ($row as $filedName => $filedValue) {
            // id, username, nickname, email, last_login_time, last_login_ip
            $fields .= $filedName . ',';
            // null, '{$_POST['Name']}', '{$_POST['Alias']}', '{$_POST['Email']}', 0, ''
            $values .= "'{$filedValue}',";
        }
        $fields = rtrim($fields, ',');
        $values = rtrim($values, ',');
//        $sql = "INSERT INTO {$this->getTableName()}
//                (id, username, nickname, email, last_login_time, last_login_ip)
//                VALUES
//                (null, '{$_POST['Name']}', '{$_POST['Alias']}', '{$_POST['Email']}', 0, '')";
        $sql = "INSERT INTO `{$this->getTableName()}`
                ({$fields})
                VALUES
                ({$values})";
        return $this->exec($sql);
    }

    /**
     * 通过id去删除一行数据
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function deleteById($id)
    {
        $sql = "DELETE FROM `{$this->getTableName()}` WHERE id='$id'";
        return $this->exec($sql);
    }

    /**
     * 通过id作为查询条件修改一行数据
     * $row
     * array(
        '字段名' => '字段值..',
        '字段名' => '字段值..',
        )
     */
    public function updateById($id, $row)
    {
        $sets = '';
        foreach ($row as $fieldName => $fieldValue) {
            // username='{$_POST['Name']}', nickname='{$_POST['Alias']}', email='{$_POST['Email']}'
            $sets .= "{$fieldName}='{$fieldValue}',";
        }
        $sets = rtrim($sets, ',');
//        $sql = "UPDATE `{$this->getTableName()}` SET
//                  username='{$_POST['Name']}', nickname='{$_POST['Alias']}', email='{$_POST['Email']}'
//                WHERE id='{$id}'";
        $sql = "UPDATE `{$this->getTableName()}` SET
                  {$sets}
                WHERE id='{$id}'";
        return $this->exec($sql);
    }

    // 统计count(*)
    public function count($where = '2 > 1')
    {
        $sql = "SELECT count(*) as count FROM `{$this->getTableName()}` WHERE {$where}";
        $row = $this->getOne($sql);
        // var_dump($row);die;
        return $row['count'];
    }

    /**
     * 当前模型的表名,占位
     */
    public function getTableName()
    {
        throw new Exception("具体模型必须重写 getTableName() 方法。");
    }
}