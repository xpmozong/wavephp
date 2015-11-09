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
 * Wavephp Application Cache_Redis Class
 *
 * 缓存Redis类
 *
 * @package         Wavephp
 * @subpackage      Cache
 * @author          许萍
 *
 */
class Cache_Redis implements Cache_Interface {
    public $redis;

    public function __construct(array $options) {
        if (extension_loaded('redis') == false ) {
            throw new Exception('extension redis not found!');
        }
        $this->hosts = $options;
        if (isset($this->hosts['slave'])) {
            $this->redis = new RedisCluster(true);
            $this->redis->connect(array(
                        'host'=>$this->hosts['master']['host'], 
                        'port'=>$this->hosts['master']['port']), true);
            foreach ($this->hosts['slave'] as $key => $value) {
                $this->redis->connect(array(
                            'host'=>$value['host'],
                            'port'=>$value['port']), false);
            }
        }else{
            $this->redis = new RedisCluster(false);
            $this->redis->connect(array(
                        'host'=>$this->hosts['master']['host'], 
                        'port'=>$this->hosts['master']['port']) );
        }
    }

    public function set($key, $value, $lifetime = 0) {
        return $this->redis->set($key, $value, $lifetime);
    }

    public function get($key) {
        return $this->redis->get($key);
    }

    public function lpush($key, $value) {
        return $this->redis->lpush($key, $value);
    }

    public function lpop($key) {
        return $this->redis->lpop($key);
    }

    public function rpush($key, $value) {
        return $this->redis->rpush($key, $value);
    }

    public function rpop($key) {
        return $this->redis->rpop($key);
    }

    public function lget($key, $index = 0) {
        return $this->redis->lget($key, $index);
    }

    public function llen($key) {
        return $this->redis->llen($key);
    }

    public function increment($key, $step = 1) {
        return $this->redis->incr($key, $step);
    }

    public function decrement($key, $step = 1) {
        return $this->redis->decr($key, $step);
    }

    public function delete($key) {
        return $this->redis->delete($key);
    }

    //+++-------------------------哈希操作-------------------------+++//
    /**
     * 将key->value写入hash表中
     * @param $hash string 哈希表名
     * @param $data array 要写入的数据 array('key'=>'value')
     */
    public function hashSet($hash, $key, $data) {
        return $this->redis->hashSet($hash, $key, $data);
    }

    /**
     * 获取hash表的数据
     * @param $hash string 哈希表名
     * @param $key mixed 表中要存储的key名 默认为null 返回所有key>value
     * @param $type int 要获取的数据类型 0:返回所有key 1:返回所有value 2:返回所有key->value
     */
    public function hashGet($hash, $key = array(), $type = 0) {
        return $this->redis->hashGet($hash, $key, $type);
    }

    /**
     * 获取hash表中元素个数
     * @param $hash string 哈希表名
     */
    public function hashLen($hash) {
        return $this->redis->hLen($hash);
    }

    /**
     * 删除hash表中的key
     * @param $hash string 哈希表名
     * @param $key mixed 表中存储的key名
     */
    public function hashDel($hash, $key) {
        return $this->redis->hDel($hash, $key);
    }

    /**
     * 查询hash表中某个key是否存在
     * @param $hash string 哈希表名
     * @param $key mixed 表中存储的key名
     */
    public function hashExists($hash, $key) {
        return $this->redis->hExists($hash, $key);
    }
}
