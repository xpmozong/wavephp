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
 * Wavephp Application Cache_File Class
 *
 * 缓存File类
 *
 * @package         Wavephp
 * @subpackage      Cache
 * @author          许萍
 *
 */
class Cache_File implements Cache_Interface 
{
    public $path;
    public $lifetime = 3600;

    public function __construct() 
    {
        $this->path = Wave::app()->projectPath.'/data/files/';
        if (!is_dir($this->path)) {
            mkdir($this->path);
        }
    }

    public function set($key, $value, $lifetime = 3600) 
    {
        return @file_put_contents($this->path.$key, serialize($value));
    }

    public function get($key, $default = false) 
    {
        if (is_file($this->path.$key)) {
            $cache = File::read($this->path.$key);
            return $cache === false ? null : unserialize($cache);
        }
        return $default;
    }

    public function increment($key, $step = 1) 
    {
        return $this->set($key, intval($this->get($key)) + $step);
    }

    public function decrement($key, $step = 1) 
    {
        $val = $this->get($key);
        return $this->set($key, intval($val) - $step);
    }

    public function delete($key) 
    {
        return @unlink($this->path.$key);
    }

    public function del($key) 
    {
        return @unlink($this->path.$key);
    }
}
?>