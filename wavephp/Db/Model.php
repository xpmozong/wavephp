<?php
/**
 * PHP 5.0 以上
 * 
 * @package         Wavephp
 * @author          许萍
 * @copyright       Copyright (c) 2016
 * @link            https://github.com/xpmozong/wavephp2
 * @since           Version 2.0
 *
 */

/**
 * Wavephp Application Model Class
 *
 * 数据模型基类
 *
 * @package         Wavephp
 * @subpackage      db
 * @author          许萍
 *
 */
class Model
{
    public $cache;
    protected $dbname               = '';   // 数据库
    protected $dbArray              = array();
    protected $tablePrefixArray     = array();
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
    protected $_tableName           = '';
    protected $_having              = array();

    /**
     * 构造函数
     */
    public function __construct() {
        $this->minit();
    }

    /**
     * 初始化
     *
     * @param string $db 数据库名称
     *
     */
    public function minit($db = '') {
        // 表前缀
        $this->dbname = 'database';
        if (!empty($db)) {
            $this->dbname = $db;
        }
        if (empty($this->tablePrefixArray[$this->dbname])) {
            $configs = Wave::app()->config[$this->dbname];
            $this->tablePrefixArray[$this->dbname] = $configs['master']['table_prefix'];
        }
        if(empty($this->dbArray[$this->dbname])){
            $this->dbArray[$this->dbname] = Database::factory($this->dbname);
        }
        $this->init();
    }

    /**
     * 子模型方法
     */
    protected function init(){}

    /**
     * 选择是哪个数据库
     *
     * @return object
     *
     */
    public function getDb() {
        return $this->dbArray[$this->dbname];
    }

    /**
     * 选择是哪个前缀
     *
     * @return string
     *
     */
    public function getTablePrefix() {
        return $this->tablePrefixArray[$this->dbname];
    }

    /**
     * 获取最后一条sql语句
     *
     * @return string
     *
     */
    public function lastSql()
    {
        return $this->getDb()->getLastSql();
    }

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
     * 取得某个字段的最大值
     *
     * @param string $field  字段名
     * @param string $alias  别名
     *
     * @return $this
     *
     */
    public function max($field, $alias = 'max')
    {
        $alias = ($alias != '') ? $alias : $field;
        $sql = 'MAX('.$field.') AS '.$alias;
        $this->_select[] = $sql;

        return $this;
    }

    /**
     * 取得某个字段的最小值
     *
     * @param string $field  字段名
     * @param string $alias  别名
     *
     * @return $this
     *
     */
    public function min($field, $alias = 'min')
    {
        $alias = ($alias != '') ? $alias : $field;
        $sql = 'MIN('.$field.') AS '.$alias;
        $this->_select[] = $sql;

        return $this;
    }

    /**
     * 统计某个字段的平均值
     *
     * @param string $field  字段名
     * @param string $alias  别名
     *
     * @return $this
     *
     */
    public function avg($field, $alias = 'avg')
    {
        $alias = ($alias != '') ? $alias : $field;
        $sql = 'AVG('.$field.') AS '.$alias;
        $this->_select[] = $sql;

        return $this;
    }

    /**
     * 统计某个字段的总和
     *
     * @param string $field  字段名
     * @param string $alias  别名
     *
     * @return $this
     *
     */
    public function sum($field, $alias = 'sum')
    {
        $alias = ($alias != '') ? $alias : $field;
        $sql = 'SUM('.$field.') AS '.$alias;
        $this->_select[] = $sql;

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
            $this->_from = $this->_tableName;
        }

        return $this;
    }


    /**
     * 连表查询
     *
     * @param string $table         表
     * @param string $conditions    条件
     * @param string $type          连接类型
     *
     * @return $this 
     *
     */
    public function join($table, $conditions, $type = 'LEFT')
    {
        $type = strtoupper($type);
        $con = explode('=', $conditions);
        $this->_join[] = $type.' JOIN '.$table.' ON '.$con[0].'='.$con[1];

        return $this;
    }

    /**
     * 是否过滤重复记录
     *
     * @param bool $val 是否
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
     * @param array $where  条件
     * @param bool $not     是否not
     * @param string $type  AND或OR
     *
     * @return $this
     *
     */
    public function in($where, $not = false, $type = 'AND')
    {
        if (!empty($where) && is_array($where)) {
            foreach ($where as $k => $v) {
                $prefix = (count($this->_where) == 0) ? '' : $type.' ';
                $not = $not ? ' NOT' : '';
                $arr = array();
                $values = explode(',', $v);
                foreach ($values as $value) {
                    $arr[] = $this->getDb()->escape($value);
                }

                $this->_where[] = $prefix . $k . $not . " IN (" . implode(", ", $arr) . ") ";
            }
        }
        
        return $this;
    }

    /**
     * NOT IN
     *
     * @param array $where 条件
     * @param string $type  类型
     *
     * @return $this
     *
     */
    public function notin($where, $type = 'AND')
    {
        return $this->in($where, true, $type);
    }

    /**
     * 条件查询
     *
     * @param array $where      条件
     * @param string $type      AND或OR
     * @param string $type2     类型
     *
     * @return $this
     *
     */
    public function where($where, $type = 'AND', $type2 = '')
    {
        if (!empty($where) && is_array($where)) {
            foreach ($where as $k => $v) {
                $prefix = (count($this->_where) == 0) ? '' : $type.' ';
                if ( !$this->getDb()->_parse($k) && is_null($v) ) {
                    $k .= ' IS NULL';
                }
                if ( !$this->getDb()->_parse($k)) {
                    $k .= ' =';
                }
                if (!is_null($v)) {
                    $v = $this->getDb()->escape($v);
                }
                if ( !empty($type2) ){
                    $_where[] = $k.' '.$v;
                }else{
                    $this->_where[] = $prefix.$k.' '.$v;
                }
            }
            if ( !empty($type2) && !empty($_where)){
                $this->_where[] = $prefix .'('.  implode(" $type2 ", $_where) . ') ';
            }
        }

        return $this;
    }

    /**
     * having
     *
     * @param array $where      条件
     * @param string $type      AND或OR
     * @param string $type2     类型
     *
     * @return $this
     *
     */
    public function having($where, $type = 'AND', $type2 = '')
    {
        if (!empty($where) && is_array($where)) {
            foreach ($where as $k => $v) {
                $prefix = (count($this->_having) == 0) ? '' : $type.' ';
                if ( !$this->getDb()->_parse($k) && is_null($v) ) {
                    $k .= ' IS NULL';
                }
                if ( !$this->getDb()->_parse($k)) {
                    $k .= ' =';
                }
                if (!is_null($v)) {
                    $v = $this->getDb()->escape($v);
                }
                if ( !empty($type2) ){
                    $_having[] = $k.' '.$v;
                }else{
                    $this->_having[] = $prefix.$k.' '.$v;
                }
            }
            if ( !empty($type2) && !empty($_having)){
                $this->_having[] = $prefix .'('.  implode(" $type2 ", $_having) . ') ';
            }
        }

        return $this;
    }

    /**
     * 过滤
     *
     * @param string $string    过滤内容
     *
     * @return string $string
     *
     */
    public function safe_replace($string) 
    {
        $string = str_replace('%20','',$string);
        $string = str_replace('%27','',$string);
        $string = str_replace('%2527','',$string);
        $string = str_replace('*','',$string);
        $string = str_replace('"','"',$string);
        $string = str_replace("'",'',$string);
        $string = str_replace('"','',$string);
        $string = str_replace(';','',$string);
        $string = str_replace('<','<',$string);
        $string = str_replace('>','>',$string);
        $string = str_replace("{",'',$string);
        $string = str_replace('}','',$string);
        $string = str_replace('\\','',$string);
        
        return $string;
    }

    /**
     * orlike
     *
     * @param array $where      条件
     * @param bool $not         是否NOT
     * @param string $like      相似范围
     *
     * @return $this
     *
     */
    public function orlike($where, $not = false, $like = 'all') {
        return $this->like($where, $not, 'OR', $like);
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
        if (!empty($where) && is_array($where)) {
            foreach ( $where as $k => $v ) {
                $v = $this->safe_replace($v);
                $prefix = (count($this->_like) == 0) ? '' : ' '.$type.' ';
                $not = ($not) ? ' NOT' : '';
                $arr = array();
                if ( $like == 'left' ) {
                    $keyword = "'%{$v}'";
                }else if ( $like == 'right' ) {
                    $keyword = "'{$v}%'";
                }else {
                    $keyword = "'%{$v}%'";
                }
                $arr[] =  $k . $not.' LIKE '.$keyword;
                $this->_like[] = $prefix .'('.  implode(" OR ", $arr) . ') ';
            }
        }

        return $this;
    }

    /**
     * OR INSTR(字段名, 字符串)
     * 返回字符串在某一个字段的内容中的位置,
     * 没有找到字符串返回0，否则返回位置（从1开始）
     *
     * @param array $where      条件数组
     *
     * @return $this
     *
     */
    public function orinstr($where) {
        return $this->instr($where, 'OR');
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
        if (!empty($where) && is_array($where)) {
            foreach ( $where as $k => $v )
            {
                $prefix = (count($this->_instr) == 0) ? '' : $type.' ';
                $arr = array();
                $v = str_replace("+", " ", $v);
                $values = explode( ' ', $v );
                foreach ( $values as $value ) {
                    $arr[] =  'INSTR('.$k.', '.$this->getDb()->escape($value).')';
                }
                $this->_instr[] = $prefix .'('.  implode(" OR ", $arr) . ') ';
            }
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
        if ($offset) {
            $this->_offset = $offset;
        }
        if ($limit) {
            $this->_limit = $limit;
        }

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
        if (!empty($field)) {
            if (is_string($field)) {
                $field = explode(',', $field);
            }
            foreach ( $field as $v ) {
                $this->_group[] = $v;
            }
        }
        
        return $this;
    }

    /**
     * 排序
     *
     * @param string $orderStr      字段排序
     * @param string $direction     排序类型，默认降序，也可RAND随机
     *
     * @return $this
     *
     */
    public function order($orderStr, $direction = "desc")
    {
        if (!empty($orderStr)) {
            $direction = strtoupper($direction);

            if ($direction == "RAND") {
                $direction = "RAND()";
            }

            $this->_order[] = $orderStr.' '.$direction;
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
        if (empty($this->_from)) {
            $sql .= $this->_tableName;
        }else{
            $sql .= $this->_from;
        }
        $sql .= ' ';
        $sql .= implode(' ', $this->_join);
        if (count($this->_where) > 0 
            OR count($this->_like) > 0 
            OR count($this->_instr) > 0) {
            $sql .= ' WHERE ';
        }
        $sql .= implode(' ', $this->_where);

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

        if (count($this->_having) > 0) {
            $sql .= ' HAVING ';
            $sql .= implode(' ', $this->_having);
        }

        if (count($this->_order) > 0) {
            $sql .= ' ORDER BY ';
            $sql .= implode(', ', $this->_order);
        }

        if (is_numeric($this->_limit) && $this->_limit > 0) {
            $sql .= $this->getDb()->limit($this->_offset, $this->_limit);
        }

        //echo $sql."<br>";

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
            '_offset'   => false,
            '_having'   => array()
        );

        $this->resetRun($vars);
    }

    /**
     * 重置查询数组 执行
     *
     * @param array $vars   需要清空的数组
     *
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
        return $this->getDb()->query($sql);
    }

    /**
     * 根据条件获得全部数据
     *
     * @param string $field     查询字段
     * @param array $where      条件
     * @param string $cache_key 缓存key
     * @param int $exp          缓存时间
     *
     * @return array 
     *
     */
    public function getAll($field = '*', $where = array(), $cache_key = '', $exp = 0)
    {
        if (!empty($cache_key) && is_object($this->cache)) {
            if ($rs = $this->cache->get($cache_key)) {
                $res = json_decode($rs, true);
                $this->resetSelect();
                return $res;
            }
        }

        $sql = '';
        if (count($this->_select)) {
            $sql = $this->where($where)->compileSelect();
        }else{
            $sql = $this->select($field)->where($where)->compileSelect();
        }
        $rs = $this->getDb()->getAll($sql);
        $this->resetSelect();

        if (!empty($cache_key) && is_object($this->cache)) {
            $res = json_encode($rs);
            $this->cache->set($cache_key, $res, $exp);
        }

        return $rs;
    }

    /**
     * 根据sql获得全部数据
     *
     * @param string $sql       sql语句
     *
     * @return array
     *
     */
    public function queryAll($sql)
    {
        return $this->getDb()->getAll($sql);
    }

    /**
     * 根据条件获得单条数据
     *
     * @param string $field     查询字段
     * @param array $where      条件
     * @param string $cache_key 缓存key
     * @param int $exp          缓存时间
     *
     * @return array 
     *
     */
    public function getOne($field = '*', $where = null, $cache_key = '', $exp = 0)
    {
        if (!empty($cache_key) && is_object($this->cache)) {
            if ($rs = $this->cache->get($cache_key)) {
                $res = json_decode($rs, true);
                $this->resetSelect();
                return $res;
            }
        }

        $sql = '';
        if (count($this->_select)) {
            $sql = $this->where($where)->compileSelect();
        }else{
            $sql = $this->select($field)->where($where)->compileSelect();
        }
        $rs = $this->getDb()->getOne($sql);
        $this->resetSelect();

        if (!empty($cache_key) && is_object($this->cache)) {
            $res = json_encode($rs);
            $this->cache->set($cache_key, $res, $exp);
        }

        return $rs;
    }

    /**
     * 根据sql获得单条数据
     *
     * @param string $sql       sql语句
     *
     * @return array
     *
     */
    public function queryOne($sql)
    {
        return $this->getDb()->getOne($sql);
    }

    /**
     * 获得表名
     *
     * @return string
     *
     */
    public function getTableName(){
        if (empty($this->_from)) {
            return $this->_tableName;
        }else{
            return $this->_from;
        }
    }

    /**
     * 插入数据
     *
     * @param array $data           数据
     * @param string $cache_key     缓存key
     *
     * @return bool
     *
     */
    public function insert($data, $cache_key = '')
    {
        if (!empty($cache_key) && is_object($this->cache)){
            $this->cache->delete($cache_key);
        }

        $tableName = $this->getTableName();
        $res = $this->getDb()->insertdb($tableName, $data);
        $this->resetSelect();
        if($res){
            return $this->getDb()->insertId();
        }else{
            return false;
        }
    }

    /**
     * 更新数据
     *
     * @param array $data           数据
     * @param array $where          条件
     * @param string $cache_key     缓存key
     *
     * @return bool
     *
     */
    public function update($data, $where, $cache_key = '')
    {
        if(!isset($where) || !is_array($where) ) exit('参数错误');
        if (!empty($cache_key) && is_object($this->cache)){
            $this->cache->delete($cache_key);
        }

        $tableName = $this->getTableName();
        $this->where($where);
        $conditions = implode(' ', $this->_where);

        $this->getDb()->updatedb($tableName, $data, $conditions);
        $this->resetSelect();

        return $this->getDb()->affectedRows();
    }

    /**
     * 获得刚插入数据id
     *
     * @return int
     *
     */
    public function insertId()
    {
        return $this->getDb()->insertId();
    }

    /**
     * 删除数据
     *
     * @param string $cache_key     缓存key
     *
     * @return nums
     *
     */
    public function delete($where, $cache_key = '')
    {
        if(!isset($where) || !is_array($where) ) exit('参数错误');
        if (!empty($cache_key) && is_object($this->cache)){
            $this->cache->delete($cache_key);
        }

        $tableName = $this->getTableName();
        $this->where($where);
        $conditions = implode(' ', $this->_where);
        $this->getDb()->delete($tableName, $conditions);
        $this->resetSelect();

        return $this->getDb()->affectedRows();
    }

    /**
     * 统计满足条件的记录个数
     *
     * @param string $field     字段名
     * @param string $alias     别名
     * @param bool $distinct    是否去重
     *
     * @return $this
     *
     */
    public function count($field = '*', $alias = 'count', $distinct = false)
    {
        $alias = ($alias != '') ? $alias : $field;
        $field = $field == '*' ? $field : ($distinct ? 'DISTINCT '.$field : $field);
        $sql = 'COUNT('.$field.') AS '.$alias;
        $this->_select[] = $sql;

        return $this;
    }

    /**
     * 统计
     *
     * @param string $field         字段名
     * @param array $where          条件
     * @param string $cache_key     缓存key
     * @param int $exp              缓存时间
     *
     * @return int                  数量
     *
     */
    public function getCount($field = '*', $where = array(), $cache_key = '', $exp = 3600)
    {
        if (!empty($cache_key) && is_object($this->cache)) {
            $res = $this->cache->get($cache_key);
            if (!empty($res)) {
                $this->resetSelect();
                return $res;
            }
        }
        
        $sql = $this->count($field)->where($where)->compileSelect();
        $arr = $this->getDb()->getOne($sql);
        $res = $arr['count'];
        if (!empty($cache_key) && is_object($this->cache)) {
            $this->cache->set($cache_key, $res, $exp);
        }
        $this->resetSelect();

        return $res;
    }

    /**
     * 获得表列表
     *
     * @return array
     *
     */
    public function listTables()
    {
        return $this->getDb()->list_tables();
    }

    /**
     * 获得表结构
     *
     * @return array
     *
     */
    public function listColumns($table)
    {
        return $this->getDb()->list_columns($table);
    }

    /**
     * 清空表
     *
     * @return bool
     *
     */
    public function truncate($table)
    {
        return $this->getDb()->truncate($table);
    }

}
?>