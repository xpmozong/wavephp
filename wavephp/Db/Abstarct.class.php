<?php
/**
 * PHP 5.0 以上
 * 
 * @package         Wavephp
 * @author          许萍
 * @copyright       Copyright (c) 2013
 * @link            https://github.com/xpmozong/wavephp
 * @since           Version 1.0
 *
 */

/**
 * Wavephp Application Abstarct Class
 *
 * 数据库接口类
 *
 * @package         Wavephp
 * @subpackage      Db
 * @author          许萍
 *
 */
abstract class Abstarct{

    /**
     * 初始化
     *
     * @param array $dbConfig
     *
     */
    public function __construct($dbConfig)
    {
        $this->_connect($dbConfig);
    }

    /**
     * 数据库执行语句
     *
     * @return blooean
     *
     */
    public function query($sql, $die_msg = 1)
    {
        return $this->_query($sql, $die_msg);
    }

    /**
     * 插入数据
     *
     * @param string $table         表名
     * @param array  $array         数据数组
     *
     * @return boolean 
     *
     */
    public function insertdb($table, $array)
    {
        return $this->_insertdb($table, $array);
    }

    /**
     * 获得刚插入数据的id
     *
     * @return int id
     *
     */
    public function insertId() 
    {
        return $this->_insertId();
    }

    /**
     * 更新数据
     *
     * @param string $table         表名
     * @param array  $array         数据数组
     * @param string $conditions    条件
     *
     * @return boolean
     *
     */
    public function updatedb($table, $array, $conditions) 
    {
        return $this->_updatedb($table, $array, $conditions);
    }

    /**
     * 获得刚执行完的条数
     *
     * @return int num
     *
     */
    public function affectedRows() {
        return $this->_affectedRows();
    }

    /**
     * 获得查询语句单条结果
     *
     * @return array
     *
     */
    public function getOne()
    {
        return $this->_getOne();
    }

    /**
     * 获得查询语句多条结果
     *
     * @return array
     *
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * 删除数据
     *
     * @param string $table         表名
     * @param string $fields        条件
     *
     * @return boolean
     *
     */
    public function delete($table, $fields)
    {
        return $this->_delete($table, $fields);
    }

    /**
     * 关闭数据库连接，当您使用持续连接时该功能失效
     *
     * @return blooean
     *
     */
    public function close()
    {
        return $this->_close();
    }
    
    /**
     * 解析过滤
     *
     * @param string $str       条件数组
     *
     * @return bool
     *
     */
    public function _parse($str) {
        $str = trim($str);
        if (!preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str)) {
            return false;
        }

        return true;
    }

    /**
     * 查询条数
     *
     * @param int $offset       第几条
     * @param int $limit        多少条数据
     * 
     * @return $this
     *
     */
    public function limit($offset, $limit) {
        return $this->_limit($offset, $limit);
    }

    /**
     * 字符串转义
     *
     * @param string $str       字符串
     *
     */
    public function escape($str) {
        switch (gettype($str)) {
            case 'string'   :   $str = "'".$this->_escape_str($str)."'";
                break;
            case 'boolean'  :   $str = ($str === FALSE) ? 0 : 1;
                break;
            default         :   $str = ($str === NULL) ? 'NULL' : $str;
                break;
        }

        return $str;
    }

}


?>