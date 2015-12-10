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
 * Wavephp Application Mysql Class
 *
 * 数据库类
 *
 * @package         Wavephp
 * @subpackage      Db
 * @author          许萍
 *
 */
class Mysql extends Db_Abstract
{
    private     $errno;             // 错误信息
    
    public function __construct($config) {
        if (!isset($config['slave'])) {
            $this->is_single = true;
        }
        $this->config = $config;
    }

    /**
     * 初始化
     *
     * @param array $dbConfig
     *
     */
    protected function _connect($tag)
    {
        if ($this->config[$tag]['pconnect']) {
            return @mysql_pconnect( $this->config[$tag]['dbhost'], 
                                    $this->config[$tag]['username'], 
                                    $this->config[$tag]['password']);
        } else {
            return @mysql_connect(  $this->config[$tag]['dbhost'], 
                                    $this->config[$tag]['username'], 
                                    $this->config[$tag]['password']);
        }
    }

    protected function db_select($tag) {
        return @mysql_select_db($this->config[$tag]['dbname'], $this->conn[$tag]);
    }

    protected function db_set_charset($tag) {
        return @mysql_query("SET character_set_connection=".$this->config[$tag]['charset'].", character_set_results=".$this->config[$tag]['charset'].", character_set_client=".$this->config[$tag]['charset']."", $this->conn[$tag]);
    }
 
    /**
     * 数据库执行语句
     *
     * @return blooean
     *
     */
    protected function _query($sql, $conn_id)
    {
        if (Wave::app()->config['debuger']) {
            $start_time = microtime(TRUE);
        }
        
        $result = @mysql_query($sql, $conn_id);
        // 可以用自定义错误信息的方法，就要压制本身的错误信息
        if($result == true) {
            if (Wave::app()->config['debuger']) {
                Wave::debug_log('database', (microtime(TRUE) - $start_time), $sql);
            }
            return $result;
        }else{
            // 有错误发生
            $this->errno = mysql_error($conn_id);
            // 强制报错并且die
            $this->msg();
        }
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
    protected function _insertdb($table, $array)
    {
        $tbcolumn = $tbvalue = '';
        foreach($array  as $key=>$value){
            $value = $this->escape($value);
            $tbcolumn .= '`'.$key.'`'.",";
            $tbvalue  .= ''.$value.',';
        }
        $tbcolumn = "(".trim($tbcolumn,',').")";
        $tbvalue = "(".trim($tbvalue,',').")";
        $sql = "INSERT INTO `".$table."` ".$tbcolumn." VALUES ".$tbvalue;
        return $this->query($sql);
    }

    /**
     * 获得刚插入数据的id
     *
     * @return int id
     *
     */
    protected function _insertId($conn_id)
    {
        return mysql_insert_id($conn_id);
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
    protected function _updatedb($table, $array, $conditions)
    {
        $update = array();
        foreach ($array as $key => $value){
            $value = $this->escape($value);
            $update[] = "`$key`=$value";
        }
        $update = implode(",", $update);
        $sql = 'UPDATE `'.$table.'` SET '.$update.' WHERE '.$conditions;
        return $this->query($sql);
    }

    /**
     * 获得刚执行完的条数
     *
     * @return int num
     *
     */
    protected function _affectedRows()
    {
        return mysql_affected_rows();
    }

    /**
     * 获得查询语句单条结果
     *
     * @return array
     *
     */
    protected function _getOne($sql) 
    {
        $res = $this->query($sql);
        return mysql_fetch_assoc($res);
    }
 
    /**
     * 获得查询语句多条结果
     *
     * @return array
     *
     */
    protected function _getAll($sql)
    {
        $res = $this->query($sql);
        $arr = array();
        while($row = mysql_fetch_assoc($res)) {
            $arr[] = $row;
        }

        return $arr;
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
    protected function _delete($table, $fields)
    {
        $sql = "DELETE FROM $table WHERE $fields";
        
        return $this->query($sql);
    }

    /**
     * table 加 `
     */
    protected function _table($table) {
        return '`' .$table. '`';
    }

    /**
     * table list
     */
    protected function _list_tables() {
        $sql = 'SHOW TABLES FROM `'.$this->dbname.'`';

        return $this->_getAll($sql);
    }

    /**
     * table columns
     */
    protected function _list_columns($table) {
        $sql = 'SHOW COLUMNS FROM '.$this->_table($table);

        return $this->getAll($sql);
    }

    /**
     * 清空表
     */
    protected function _truncate($table) {
        $sql = 'TRUNCATE '.$this->_table($table);

        return $this->query($sql);
    }

    /**
     * mysql limit
     */
    protected function _limit($offset, $limit) {
        if ($offset == 0) {
            $offset = '';
        } else {
            $offset .= ", ";
        }

        return " LIMIT ".$offset.$limit;
    }

    /**
     * 关闭数据库连接，当您使用持续连接时该功能失效
     *
     * @return blooean
     *
     */
    protected function _close() 
    {
        return mysql_close($this->dblink);
    }

    /**
     * 显示自定义错误
     */
    protected function msg() 
    {
        if($this->errno && !empty(Wave::app()->config['crash_show_sql'])) {
            echo $this->getLastSql()."<br>";
            $errMsg = mysql_error();
            echo "<div style='color:red;'>\n";
                echo "<h4>数据库操作错误</h4>\n";
                echo "<h5>错误代码：".$this->errno."</h5>\n";
                echo "<h5>错误信息：".$errMsg."</h5>\n";
            echo "</div>";
            die;
        }else{
            exit('数据库操作错误');
        }
    }
}

?>
