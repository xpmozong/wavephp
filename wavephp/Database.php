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
 * Wavephp Application Database Class
 *
 * 数据库工厂类
 *
 * @package         Wavephp
 * @subpackage      Db
 * @author          许萍
 *
 */
abstract class Database {
    public static $db;

    public static function factory() {
        $option = Wave::app()->config['database'];
        
        $driver = isset($option['driver']) ? $option['driver'] : 'mysql';
        if (is_object(self::$db[$driver])) {
            return self::$db[$driver];
        }
        
        $class = ucfirst($driver);
        $db = self::$db[$driver] = new $class($option);
        
        return $db;
    }
}