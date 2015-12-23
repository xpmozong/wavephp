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
 * Wavephp Application Session_Memcached Class
 *
 * SESSION Memcached类
 *
 * @package         Wavephp
 * @subpackage      Session
 * @author          许萍
 *
 */

class Session_Memcached
{
    protected $lifeTime     = 86400;    // 生存周期
    protected $sess_id;
    protected $cache;

    public function __construct() {
        $option = Wave::app()->config['session'];
        $this->lifeTime = $option['timeout'];
        
        if (isset($option['memcached'])) {
            $this->cache = new Cache_Memcached($option['memcached']);
        }else{
            $this->cache = Wave::app()->memcached;
        }
    }

    /**
     * 设置SESSION
     *  
     * @param string $key       session关键字
     * @param string $val       session值
     *
     */
    public function setState($key, $val)
    {
        if(!isset($_SESSION)) {
            session_start(); 
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
            $txt = $_SESSION[$this->sess_id.$key];
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

    function open($savePath, $sessName) {
        return true; 
    }

    function close() { 
        $this->gc(ini_get('session.gc_maxlifetime')); 
        return true; 
    }

    function read($sessID) {
        $this->sess_id = $sessID;
        $sessData = $this->cache->get($this->sess_id);
        if (!empty($sessData)) {
            return $sessData;
        }else{
            return '';
        }
    }

    function write($sessID, $sessData) {
        $this->cache->set($this->sess_id, $sessData, $this->lifeTime);
        return true;
    }

    function destroy($sessID) { 
        // delete session-data
        $this->cache->delete($this->sess_id);
        return true;
    } 

    function gc($sessMaxLifeTime) {
        // delete old sessions
        return true;
    } 

}

?>