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
 * Wavephp Application Db_Abstract Class
 *
 * 数据库抽象类
 *
 * @package         Wavephp
 * @subpackage      Db
 * @author          许萍
 *
 */
abstract class Db_Abstract
{
    public $config      = array();
    public $conn        = array();
    public $is_single   = true;
    protected $lastSql  = '';  

    /**
     * 选数据库
     */
    public function init($tag) {
        if (isset($this->conn[$tag])) {
            return true;
        }
        $this->conn[$tag] = $this->_connect($tag);
        if (!$this->conn[$tag]) {
            die('Can not connect to MySQL server:'.$this->config[$tag]['dbhost']);
        }

        if (!$this->db_set_charset($tag)) {
            die('Unable to set database connection charset:'.$this->config[$tag]['charset']);
        }

        if (!$this->db_select($tag)) {
            die('Cannot use database:'.$this->config[$tag]['dbname']);
        }
    }

    /**
     * 数据库执行语句
     *
     * @return blooean
     *
     */
    public function query($sql)
    {
        $this->lastSql = $sql;
        if($this->is_single || $this->is_write($sql)) {
            $this->init('master');
            return $this->_query($sql, $this->conn['master']);
        } else {
            $this->init('slave');
            return $this->_query($sql, $this->conn['slave']);
        }
    }

    /**
     * 获取最后一条sql语句
     *
     * @return string
     *
     */
    public function getLastSql()
    {
        return $this->lastSql;
    }

    /**
     * 判断是不是写语句
     *
     * @return bool
     *
     */
    public function is_write($sql) 
    {
        if (!preg_match('/^\s*"?(SET|INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|LOAD DATA|COPY|ALTER|GRANT|REVOKE|LOCK|UNLOCK)\s+/i', $sql)) {
            return false;
        }

        return true;
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
        return $this->_insertId($this->conn['master']);
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
    public function getOne($sql)
    {
        return $this->_getOne($sql);
    }

    /**
     * 获得查询语句多条结果
     *
     * @return array
     *
     */
    public function getAll($sql)
    {
        return $this->_getAll($sql);
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
     * table list
     */
    public function list_tables() {
        return $this->_list_tables();
    }

    /**
     * table columns
     */
    public function list_columns($table) {
        return $this->_list_columns($table);
    }

    /**
     * 清空表
     */
    public function truncate($table) {
        return $this->_truncate($table);
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
     * 字符串转义
     *
     * @param string $str       字符串
     *
     */
    public function escape($str) {
        switch (gettype($str)) {
            case 'string'   :   $str = "'".$str."'";
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