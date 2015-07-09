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
 * Wavephp Application Model Class
 *
 * 数据模型基类
 *
 * @package         Wavephp
 * @author          许萍
 *
 */
class Model
{
    protected static $db;
    protected $_select              = array();
    protected $_from                = '';
    protected $_join                = array();
    protected $_distinct            = false;
    protected $_where               = array();
    protected $_like                = array();
    protected $_instr               = array();
    protected $_offset              = '';
    protected $_limit               = '';
    protected $_group               = array();
    protected $_order               = array();

    /**
     * 查询字段
     *
     * @param string $field 字段
     *
     * @return $this 
     *
     */
    public function select($field = '*')
    {
        if( !is_array( $field ) ){
            $field = explode(',', $field);
        }
        foreach( $field as $v ){
            $val = $v;
            $this->_select[] = $val;
        }

        return $this;
    }

    /**
     * 查询某表
     *
     * @param string $tableName 表名
     *
     * @return $this 
     *
     */
    public function from($tableName)
    {
        if ($tableName) {
            $this->_from = $tableName;
        }else{
            exit('no table name');
        }

        return $this;
    }


    /**
     * 连表查询
     *
     * @param string $table         表
     * @param string $conditions    条件
     *
     * @return $this 
     *
     */
    public function join($table, $conditions, $type = 'LEFT')
    {
        $type = strtoupper($type);
        $this->_join[] = $type.' JOIN '.$table.' ON '.$conditions;

        return $this;
    }

    /**
     * 是否过滤重复记录
     *
     * @return $this
     *
     */
    public function distinct($val = true)
    {
        $this->_distinct = (is_bool($val)) ? $val : true;
        
        return $this;
    }

    /**
     * IN
     *
     * @param string $conditions 条件
     *
     * @return $this
     *
     */
    public function in($conditions = null)
    {
        if ($conditions) {
            $this->_where[] = $conditions;
        }

        return $this;
    }

    /**
     * NOT IN
     *
     * @param string $conditions 条件
     *
     * @return $this
     *
     */
    public function notin($conditions = null)
    {
        if ($conditions) {
            $this->_where[] = $conditions;
        }

        return $this;
    }

    /**
     * 条件查询
     *
     * @param string $conditions 条件 
     *
     * @return $this
     *
     */
    public function where($conditions = null)
    {
        if ($conditions) {
            $this->_where[] = $conditions;
        }

        return $this;
    }

    /**
     * 模糊查询
     *
     * @param array $where      条件数组
     * @param bool $not         是否NOT
     * @param string $type      AND或OR
     * @param string $like      相似范围  
     *
     * @return $this
     *
     */
    public function like($where, $not = false, $type = 'AND', $like = 'all')
    {
        foreach ( $where as $k => $v ) {
            $prefix = (count($this->_like) == 0) ? '' : $type.' ';
            $not = ($not) ? ' NOT' : '';
            $arr = array();
            $v = str_replace("+", " ", $v);
            $values = explode( ' ', $v );
            foreach ( $values as $value ) {
                if ( $like == 'left' ) {
                    $keyword = "'%{$value}'";
                }else if ( $like == 'right' ) {
                    $keyword = "'{$value}%'";
                }else {
                    $keyword = "'%{$value}%'";
                }
                $arr[] =  $k . $not.' LIKE '.$keyword;
            }
            $this->_like[] = $prefix .'('.  implode(" OR ", $arr) . ') ';
        }

        return $this;
    }

    /**
     * INSTR(字段名, 字符串)
     * 返回字符串在某一个字段的内容中的位置,
     * 没有找到字符串返回0，否则返回位置（从1开始）
     *
     * @param array $where      条件数组
     * @param string $type      AND或OR
     *
     * @return $this
     *
     */
    public function instr($where, $type = 'AND')
    {
        foreach ( $where as $k => $v )
        {
            $prefix = (count($this->_instr) == 0) ? '' : $type.' ';
            $arr = array();
            $v = str_replace("+", " ", $v);
            $values = explode( ' ', $v );
            foreach ( $values as $value ) {
                $arr[] =  'INSTR('.$k.', '.self::$db->escape($value).')';
            }
            $this->_instr[] = $prefix .'('.  implode(" OR ", $arr) . ') ';
        }

        return $this;
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
    public function limit($offset = 0, $limit)
    {
        $this->_limit = $limit;
        $this->_offset = $offset;

        return $this;
    }

    /**
     * GROUP BY
     *
     * @param string $field     字段
     * 
     * @return $this
     *
     */
    public function group($field)
    {
        if (is_string($field)) {
            $field = explode(',', $field);
        }
        foreach ( $field as $v ) {
            $this->_group[] = $v;
        }

        return $this;
    }

    /**
     * 排序
     *
     * @param string $orderStr  字段排序
     *
     * @return $this
     *
     */
    public function order($orderStr = null)
    {
        if ($orderStr) {
            $this->_order[] = $orderStr;
        }

        return $this;
    }

    /**
     * 连接sql语句
     *
     * @return string $sql
     *
     */
    public function compileSelect()
    {
        $sql = ( !$this->_distinct) ? 'SELECT ' : 'SELECT DISTINCT ';
        $sql .= (count($this->_select) == 0) ? '*' 
                : implode(', ', $this->_select);
        $sql .= ' FROM ';
        $sql .= $this->_from;
        $sql .= ' ';
        $sql .= implode(' ', $this->_join);
        if (count($this->_where) > 0 
            OR count($this->_like) > 0 
            OR count($this->_instr) > 0) {
            $sql .= ' WHERE ';
        }
        $sql .= implode(' AND ', $this->_where);

        if (count($this->_like) > 0) {
            if (count($this->_where) > 0) {
                $sql .= ' AND ';
            }
            $sql .= implode(' ', $this->_like);
        }

        if (count($this->_instr) > 0) {
            if (count($this->_where) > 0 OR count($this->_like) > 0) {
                $sql .= ' AND ';
            }
            $sql .= implode(' ', $this->_instr);
        }

        if (count($this->_group) > 0) {
            $sql .= ' GROUP BY ';
            $sql .= implode(', ', $this->_group);
        }

        if (count($this->_order) > 0) {
            $sql .= ' ORDER BY ';
            $sql .= implode(', ', $this->_order);
        }

        if (is_numeric($this->_limit) && $this->_limit > 0) {
            $sql .= self::$db->limit($this->_offset, $this->_limit);
        }

        $this->resetSelect();

        return $sql;
    }

    /**
     * 重置查询数组
     */
    public function resetSelect()
    {
        $vars = array(
            '_select'   => array(),
            '_from'     => '',
            '_join'     => array(),
            '_where'    => array(),
            '_like'     => array(),
            '_instr'    => array(),
            '_group'    => array(),
            '_order'    => array(),
            '_distinct' => false,
            '_limit'    => false,
            '_offset'   => false
        );

        $this->resetRun($vars);
    }

    /**
     * 重置查询数组 执行
     */
    public function resetRun($vars)
    {
        foreach($vars as $item => $default_value) {
            $this->$item = $default_value;
        }
    }

    /**
     * sql语句执行
     *
     * @param string $sql       sql语句
     *
     * @return bool 
     *
     */
    public function sqlQuery($sql)
    {
        return self::$db->query($sql);
    }

    /**
     * 根据sql获得全部数据
     *
     * @param string $sql       sql语句
     *
     * @return array 
     *
     */
    public function getAll($sql = '')
    {
        if ($sql) {
            self::$db->sql = $sql;
        }else{
            self::$db->sql = $this->compileSelect();
        }
        return self::$db->getAll();
    }

    /**
     * 根据sql获得单条数据
     *
     * @param string $sql       sql语句
     *
     * @return array 
     *
     */
    public function getOne($sql = '')
    {
        if ($sql) {
            self::$db->sql = $sql;
        }else{
            self::$db->sql = $this->compileSelect();
        }
        
        return self::$db->getOne();
    }

    /**
     * 插入数据
     *
     * @param string $tableName     表名
     * @param array $data           数据
     *
     * @return bool
     *
     */
    public function insert($tableName, $data)
    {
        return self::$db->insertdb($tableName, $data);
    }

    /**
     * 更新数据
     *
     * @param string $tableName     表名
     * @param array $data           数据
     * @param string $conditions    条件
     *
     * @return bool
     *
     */
    public function update($tableName, $data, $conditions)
    {
        self::$db->updatedb($tableName, $data, $conditions);
        return self::$db->affectedRows();
    }

    /**
     * 获得刚插入数据id
     *
     * @return int
     *
     */
    public function insertId()
    {
        return self::$db->insertId();
    }

    /**
     * 删除数据
     *
     * @return bool
     *
     */
    public function delete($table, $fields)
    {
        self::$db->delete($table, $fields);
        return self::$db->affectedRows();
    }

}
?>