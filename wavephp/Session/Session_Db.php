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
 * Wavephp Application Session_Db Class
 *
 * SESSION DB类
 *
 * @package         Wavephp
 * @subpackage      Session
 * @author          许萍
 *
 */

class Session_Db extends Model
{
    protected $lifeTime     = 86400;    // 生存周期
    protected $sess_id;

    protected function init() 
    {
        $option = Wave::app()->config['session'];
        $this->lifeTime = $option['timeout'];
        $this->_tableName = 'w_sessions';
    }

    /**
     * 设置SESSION
     *  
     * @param string $key       session关键字
     * @param string $val       session值
     *
     */
    public function setState($key, $val, $expire = 0)
    {
        if(!isset($_SESSION)) {
            session_start(); 
        }
        if ($expire > 0) {
            $_SESSION[$this->sess_id.$key.'_expire'] = time() + $expire;
        }
        
        $_SESSION[$this->sess_id.$key] = $val;
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

        $txt = '';
        if(isset($_SESSION[$this->sess_id.$key])){
            if (isset($_SESSION[$this->sess_id.$key.'_expire'])) {
                $expire = $_SESSION[$this->sess_id.$key.'_expire'];
                // 如果当前时间大于过期时间 清session
                if (time() > $expire) {
                    $_SESSION[$this->sess_id.$key.'_expire'] = 0;
                    $_SESSION[$this->sess_id.$key] = '';
                }else{
                    $txt = $_SESSION[$this->sess_id.$key];
                }
            }else{
                $txt = $_SESSION[$this->sess_id.$key];
            }
        }

        return $txt;
    }

    /**
     * 清除SESSION
     */
    public function logout($key)
    {
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION[$this->sess_id.$key] = '';
        unset($_SESSION[$this->sess_id.$key]);
        
        session_destroy();
    }

    function open($savePath, $sessName) 
    {
        $dbName = Wave::app()->config['database']['master']['dbname'];
        $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='$dbName' and TABLE_NAME='".$this->_tableName."'";
        $res = $this->queryOne($sql);
        if (empty($res['TABLE_NAME'])) {
            $sql = "CREATE TABLE `".$this->_tableName."` (
                `session_id` varchar(255) CHARACTER 
                SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
                `session_expires` int(10) unsigned NOT NULL DEFAULT '0',
                `session_data` text,
                PRIMARY KEY (`session_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $this->sqlQuery($sql);
        }
        
        return true; 
    }

    function close() 
    { 
        $this->gc(ini_get('session.gc_maxlifetime')); 
        return true; 
    }

    function read($sessID) 
    {
        $this->sess_id = $sessID;
        $where = array('session_id'=>$sessID, 'session_expires>'=> time());
        $row = $this->where($where)
                    ->getOne('session_data');
        if ($row) {
            return $row['session_data'];
        }else{
            return '';
        }
   }

   function write($sessID, $sessData) 
   {
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

    function destroy($sessID) 
    { 
        // delete session-data 
        $where = array('session_id'=>$sessID);
        return $this->delete($where);
    } 

    function gc($sessMaxLifeTime) 
    {
        $where = array('session_expires<'=>time());
        // delete old sessions
        return $this->delete($where);
    }
}
?>