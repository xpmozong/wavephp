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
 * @subpackage      Db
 * @author          许萍
 *
 */
class Cache_Memcache implements Cache_Interface {

    public $hosts = array();
    public $pconnect = true;
    public $lifetime = 3600;
    public $connection;

    public function __construct(array $options) {
        if (extension_loaded('memcache') == false ) {
            throw new Exception('extension memcache not found!');
        }
        $this->hosts = $options;
        $this->connection = new Memcache();
        $this->connect();
    }

    public function connect() {
        $i = 1;
        foreach ($this->hosts as $key => $value) {
            if ($i == 1) {
                if (!$this->connection->connect($value['host'], $value['port'])) {
                    throw new Exception('memcahce server '.$value['host'].
                                ':'.$value['port'].' connection faild.');
                }
            } else {
                $this->connection->addServer($value['host'], $value['port']);
            }
            $i++;
        }
    }

    public function set($key, $value, $lifetime = 3600) {
        $lifetime = $lifetime > 0 ? $lifetime : $this->lifetime;
        return $this->connection->set($key, $value, false, $lifetime);
    }

    public function get($key) {
        return $this->connection->get($key);
    }

    public function increment($key, $step = 1) {
        if ($this->get($key)) {
            return $this->connection->increment($key, $step);
        } else {
            return $this->set($key, 1);
        }
    }

    public function decrement($key, $step = 1) {
        return $this->connection->decrement($key, $step);
    }

    public function delete($key) {
        return $this->connection->delete($key);
    }
}
