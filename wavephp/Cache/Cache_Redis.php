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
 * @subpackage      Db
 * @author          许萍
 *
 */
class Cache_Redis implements Cache_Interface {

    public $hosts = array();
    public $pconnect = true;
    public $lifetime = 3600;
    public $connection;

    public function __construct(array $options) {
        $this->hosts = $options;
        $this->connection = new Redis();
        $this->connect();
    }

    private function connect() {
        foreach ($this->hosts as $key => $value) {
			$this->connection->pconnect($value['host'], $value['port']);
			break;//todo支持redis集群
        }
    }

    public function set($key, $value, $lifetime = 0) {
        $lifetime = $lifetime > 0 ? $lifetime : $this->lifetime;
        return $this->connection->setex($key, $lifetime, $value);
    }

    public function get($key) {
        return $this->connection->get($key);
    }

    public function increment($key, $step = 1) {
        if ($this->get($key)) {
            return $this->connection->incrBy($key, $step);
        } else {
            return $this->set($key, 1);
        }
    }

    public function decrement($key, $step = 1) {
        return $this->connection->decrBy($key, $step);
    }

    public function delete($key) {
        return $this->connection->delete($key);
    }

    //+++-------------------------哈希操作-------------------------+++//
    /**
     * 将key->value写入hash表中
     * @param $hash string 哈希表名
     * @param $data array 要写入的数据 array('key'=>'value')
     */
    public function hashSet($hash, $key, $data) {
        $return = null;
        if (is_array($data) && !empty($data)) {
            $return = $this->connection->hSet($hash, $key, $data);
        }

        return $return;
    }

    /**
     * 获取hash表的数据
     * @param $hash string 哈希表名
     * @param $key mixed 表中要存储的key名 默认为null 返回所有key>value
     * @param $type int 要获取的数据类型 0:返回所有key 1:返回所有value 2:返回所有key->value
     */
    public function hashGet($hash, $key = array(), $type = 0) {
        $return = null;
        if ($key) {
            if (is_array($key) && !empty($key))
                $return = $this->connection->hMGet($hash, $key);
            else
                $return = $this->connection->hGet($hash, $key);
        } else {
            switch ($type) {
                case 0:
                    $return = $this->connection->hKeys($hash);
                    break;
                case 1:
                    $return = $this->connection->hVals($hash);
                    break;
                case 2:
                    $return = $this->connection->hGetAll($hash);
                    break;
                default:
                    $return = false;
                    break;
            }
        }

        return $return;
    }

    /**
     * 获取hash表中元素个数
     * @param $hash string 哈希表名
     */
    public function hashLen($hash) {
        $return = null;

        $return = $this->connection->hLen($hash);

        return $return;
    }

    /**
     * 删除hash表中的key
     * @param $hash string 哈希表名
     * @param $key mixed 表中存储的key名
     */
    public function hashDel($hash, $key) {
        $return = null;

        $return = $this->connection->hDel($hash, $key);

        return $return;
    }

    /**
     * 查询hash表中某个key是否存在
     * @param $hash string 哈希表名
     * @param $key mixed 表中存储的key名
     */
    public function hashExists($hash, $key) {
        $return = null;

        $return = $this->connection->hExists($hash, $key);

        return $return;
    }
}
