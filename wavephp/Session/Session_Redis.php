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
 * Wavephp Application Session_Redis Class
 *
 * SESSION Redis类
 *
 * @package         Wavephp
 * @subpackage      Session
 * @author          许萍
 *
 */

class Session_Redis
{
    protected $lifeTime     = 86400;    // 生存周期
    protected $isread       = false;
    protected $sess_id;
    protected $cache;
    
    public function __construct($option)
    {
        $this->lifeTime = $option['timeout'];
        @session_start();
        $this->sess_id = session_id();
        $this->cache = Wave::app()->redis;
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
        $this->cache->set($this->sess_id.$key, json_encode($val), $this->lifeTime);
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
        $data = $this->cache->get($this->sess_id.$key);
        if (empty($data)) {
            return array();
        }

        return json_decode($data, true);
    }

    /**
     * 清除SESSION
     */
    public function logout($key) {
        $this->cache->delete($this->sess_id.$key);
    }

    function open($savePath, $sessName) {
        return true; 
    }

    function close() { 
        $this->gc(ini_get('session.gc_maxlifetime')); 
        return true; 
    }

    function read($sessID) {
        return '';
    }

    function write($sessID, $sessData) {
        return true;
    }

    function destroy($sessID) { 
        // delete session-data
        return true;
    } 

    function gc($sessMaxLifeTime) {
        // delete old sessions
        return true;
    } 

}

?>