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

class Session
{
    protected $prefix       = '';       // session前缀
    protected $lifeTime     = 86400;    // 生存周期
    protected $isread       = false;
    protected $cache;
    
    public function __construct($pre, $timeout, $che)
    {
        $this->prefix = $pre;
        $this->lifeTime = $timeout;
        if ($che == 'redis') {
            $this->cache = Wave::app()->redis;
        }else{
            $this->cache = Wave::app()->memcache;
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
        if ($this->cache){
            $this->isread = true;
        }else{
            die('no cache');
        }
        
        return true; 
    }

    function close() { 
        $this->gc(ini_get('session.gc_maxlifetime')); 
        return true; 
    }

    function read($sessID) {
        if ($this->isread) {
            return $this->cache->get($this->prefix.$sessID);
        }else{
            return '';
        }
   }

   function write($sessID, $sessData) {
        return $this->cache->set($this->prefix.$sessID, $sessData, $this->lifeTime);
   }

    function destroy($sessID) { 
        // delete session-data
        return $this->cache->delete($this->prefix.$sessID);
    } 

    function gc($sessMaxLifeTime) {
        // delete old sessions
        return true;
    } 

}

?>