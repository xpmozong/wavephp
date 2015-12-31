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
 * Wavephp Application Cache_Memcache Class
 *
 * 缓存Memcache类
 *
 * @package         Wavephp
 * @subpackage      Cache
 * @author          许萍
 *
 */
class Cache_Memcache implements Cache_Interface {

    protected $hosts = array();
    protected $pconnect = true;
    protected $lifetime = 3600;
    protected $cacheArray = array();
    protected $cache_name = null;

    public function __construct($came = 'memcache') 
    {
        $this->cache_name = $came;
        $this->init();
    }

    public function init()
    {
        if (extension_loaded('memcache') == false ) {
            exit('extension memcache not found!');
        }
        $this->hosts = Wave::app()->config[$this->cache_name];
        $this->cacheArray[$this->cache_name] = new Memcache();
        
        $i = 1;
        foreach ($this->hosts as $key => $value) {
            if ($i == 1) {
                if (!$this->cacheArray[$this->cache_name]->connect($value['host'], $value['port'])) {
                    throw new Exception('memcahce server '.$value['host'].':'.$value['port'].' connection faild.');
                }
            } else {
                $this->cacheArray[$this->cache_name]->addServer($value['host'], $value['port']);
            }
            $i++;
        }
    }

    public function getMemcache()
    {
        return $this->cacheArray[$this->cache_name];
    }

    public function set($key, $value, $lifetime = 3600) 
    {
        $lifetime = $lifetime >= 0 ? $lifetime : $this->lifetime;
        return $this->getMemcache()->set($key, $value, false, $lifetime);
    }

    public function get($key) 
    {
        return $this->getMemcache()->get($key);
    }

    public function increment($key, $step = 1) 
    {
        if ($this->get($key)) {
            return $this->getMemcache()->increment($key, $step);
        } else {
            return $this->set($key, 1);
        }
    }

    public function decrement($key, $step = 1) 
    {
        return $this->getMemcache()->decrement($key, $step);
    }

    public function delete($key) 
    {
        return $this->getMemcache()->delete($key);
    }
}
?>