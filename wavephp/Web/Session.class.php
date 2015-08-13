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
 * Wavephp Application Session Class
 *
 * SESSION类
 *
 * @package         Wavephp
 * @subpackage      Web
 * @author          许萍
 *
 */

class Session extends Model
{
    protected $prefix       = '';       // session前缀
    protected $lifeTime     = 86400;    // 生存周期
    protected $isread       = false;
    
    public function __construct($pre, $timeout)
    {
        $this->prefix = $pre;
        $this->lifeTime = $timeout;
        $this->_tableName = 'w_sessions';
        if (empty(self::$db)) {
            if (Wave::app()->database) {
                self::$db = Wave::app()->database->db;
            }
        }
    }

    /**
     * 设置SESSION
     *  
     * @param string $key       session关键字
     * @param string $val       session值
     *
     */
    public function setState($key, $val, $timeout = null)
    {
        if(!isset($_SESSION)) {
            session_start(); 
        }

        if(!empty($timeout)) {
            $_SESSION[$this->prefix.$key.'_timeout'] = time()+$timeout;
        }else{
            $_SESSION[$this->prefix.$key.'_timeout'] = time()+$this->lifeTime;
        }

        $_SESSION[$this->prefix.$key] = $val;
    }

    /**
     * 得到SESSION
     * 
     * @param string $key       session关键字
     *
     * @return string
     *
     */
    public function getState($key)
    {
        if(!isset($_SESSION)) {
            session_start();
        }

        if(isset($_SESSION[$this->prefix.$key])){
            if(time() > $_SESSION[$this->prefix.$key.'_timeout']) {
                unset($_SESSION[$this->prefix.$key.'_timeout']);
                unset($_SESSION[$this->prefix.$key]);
                $txt = '';
            }else {
                $txt = $_SESSION[$this->prefix.$key];
            }
        }else{
            $txt = '';
        }
        return $txt;
    }

    /**
     * 清除SESSION
     */
    public function logout()
    {
        if(!isset($_SESSION)) {
            session_start();
        }
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$this->prefix.$key.'_timeout']);
            unset($_SESSION[$this->prefix.$key]);
        }
        session_destroy();
    }

    function open($savePath, $sessName) {
        if (empty(self::$db)){
            die('未配置数据库连接');
        }else{
            $tables = $this->queryAll('show tables');
            $tablesList = array();
            $dbName = Wave::app()->config['database']['db']['dbname'];
            foreach ($tables as $key => $value) {
                $tablesList[] = $value['Tables_in_'.$dbName];
            }
            if (!in_array($this->_tableName, $tablesList)) {
                $sql = "CREATE TABLE `".$this->_tableName."` (
                    `session_id` varchar(255) CHARACTER 
                    SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
                    `session_expires` int(10) unsigned NOT NULL DEFAULT '0',
                    `session_data` text,
                    PRIMARY KEY (`session_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                $this->sqlQuery($sql);
            }

            $this->isread = true;
        }
        
        return true; 
    }

    function close() { 
        $this->gc(ini_get('session.gc_maxlifetime')); 
        return true; 
    }

    function read($sessID) {
        if ($this->isread) {
            $where = array('session_id'=>$sessID, 'session_expires>'=> time());
            $row = $this->where($where)
                        ->getOne('session_data');
            if ($row) {
                return $row['session_data'];
            }else{
                return '';
            }
        }else{
            return '';
        }
   }

   function write($sessID, $sessData) {
        // new session-expire-time 
        $newExp = time() + $this->lifeTime; 
        // is a session with this id in the database? 
        $where = array('session_id'=>$sessID);
        $row = $this->where($where)
                    ->getOne('session_data');
        if ($row) {

            $data = array('session_expires' =>$newExp, 
                            'session_data'  =>$sessData);
            return $this->update($data, $where);

        }else{
            $data = array('session_id'=>$sessID,
                     'session_expires'=>$newExp, 
                        'session_data'=>$sessData);
            return $this->insert($data);
        }
   }

    function destroy($sessID) { 
        // delete session-data 
        $where = array('session_id'=>$sessID);
        return $this->delete($where);
    } 

    function gc($sessMaxLifeTime) {
        $where = array('session_expires<'=>time());
        // delete old sessions
        return $this->delete($where);
    } 

}

?>