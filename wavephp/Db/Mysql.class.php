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
include 'Abstarct.class.php';

class Mysql extends Abstarct
{
    private $dbhost;            //数据库地址
    private $dbport;            //数据库端口
    private $dbuser;            //数据库用户名
    private $dbpasswd;          //数据库密码
    private $dbpconnect = 0;    //数据库长连接
    private $dbname;            //数据库名称
    private $dbchart;           //数据库链接编码
    private $dblink;            //数据库连接对象
    public  $sql;               //sql语句
    private $errno;             //错误信息
     
    public function __construct($dbConfig)
    {
        $this->dbhost       = $dbConfig['dbhost'];
        $this->dbport       = isset($dbConfig['dbport']) ? $dbConfig['dbport'] : 3306;
        $this->dbuser       = $dbConfig['dbuser'];
        $this->dbpasswd     = $dbConfig['dbpasswd'];
        $this->dbpconnect   = isset($dbConfig['dbpconnect']) ? $dbConfig['dbpconnect'] : 0;
        $this->dbname       = $dbConfig['dbname'];
        $this->dbchart      = isset($dbConfig['dbchart']) ? $dbConfig['dbchart'] : 'utf8';
        if($this->dbpconnect) {
            $this->dblink = mysql_pconnect($this->dbhost.':'.$this->dbport,$this->dbuser,$this->dbpasswd,1) 
            or die('can not connect to mysql database!');
        } else {
            $this->dblink = mysql_connect($this->dbhost.':'.$this->dbport,$this->dbuser,$this->dbpasswd,1) 
            or die('can not connect to mysql database!');
        }
        mysql_query('set names '.$this->dbchart, $this->dblink);
        mysql_select_db($this->dbname, $this->dblink);
        unset($dbConfig);
    }
 
    /**
     * 数据库执行语句
     *
     * @return blooean
     *
     */
    public function query($sql, $die_msg = 1)
    {
        $result = @mysql_query($sql, $this->dblink);
        // 可以用自定义错误信息的方法，就要压制本身的错误信息
        if($result == true) {
            return $result;
        }else{
            // 有错误发生
            $this->errno = mysql_error($this->dblink);
            if($die_msg == 1) {
                // 强制报错并且die
                $this->msg();
            }else{
                return false;
            }
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
    public function insertdb($table, $array)
    {
        $tbcolumn = $tbvalue = '';
        foreach($array  as $key=>$value){
            $tbcolumn .= '`'.$key.'`'.",";
            $tbvalue  .= "'".$value."',";
        }
        $tbcolumn = "(".trim($tbcolumn,',').")";
        $tbvalue = "(".trim($tbvalue,',').")";
        $sql = "INSERT INTO `".$table."` ".$tbcolumn." VALUES ".$tbvalue;
        
        return $this->query($sql);
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
        $update = array();
        foreach ($array as $key => $value){
            $update[] = '`'.$key.'` = '."'".$value."'";
        }
        $update = implode(",", $update);
        $sql = 'UPDATE `'.$table.'` SET '.$update.' WHERE '.$conditions;
        
        return $this->query($sql);
    }

    /**
     * 获得查询语句单条结果
     *
     * @return array
     *
     */
    public function getOne() 
    {
        $res = $this->query($this->sql);
        return mysql_fetch_assoc($res);
    }
 
    /**
     * 获得查询语句多条结果
     *
     * @return array
     *
     */
    public function getAll() 
    {
        $res = $this->query($this->sql);
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
    public function delete($table, $fields)
    {
        $sql = "DELETE FROM $table WHERE $fields";
        
        return $this->query($sql);
    }

    /**
     * 取得结果数据
     *
     * @param resource $query
     *
     * @return string
     *
     */
    public function result($query, $row) 
    {
        $query = @mysql_result($query, $row);
        return $query;
    }
 
    /**
     * 获得刚插入数据的id
     *
     * @return int id
     *
     */
    public function getInsertID()
    {
        return ($id = mysql_insert_id($this->dblink)) >= 0 ? $id : 
            $this->result($this->query('SELECT last_insert_id()'), 0);
    }
 
    /**
     * 关闭数据库连接，当您使用持续连接时该功能失效
     *
     * @return blooean
     *
     */
    public function close() 
    {
        return mysql_close($this->dblink);
    }
 
    /**
     * 显示自定义错误
     */
    public function msg() 
    {
        if($this->errno) {
            $errMsg = mysql_error();
            echo "<div style='color:red;'>\n";
                echo "<h4>数据库操作错误</h4>\n";
                echo "<h5>错误代码：".$this->errno."</h5>\n";
                echo "<h5>错误信息：".$errMsg."</h5>\n";
            echo "</div>";
            unset($msgArr);
            die;
        }
    }
    

    public function limit($offset, $limit) {
        if ($offset == 0) {
            $offset = '';
        } else {
            $offset .= ", ";
        }

        return " LIMIT ".$offset.$limit;
    }

    public function escape_str($str) {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = $this->escape_str($val);
            }

            return $str;
        }

        if (function_exists('mysql_real_escape_string')) {
            return mysql_real_escape_string($str);
        } else {
            return addslashes($str);
        }
    }
}

?>
