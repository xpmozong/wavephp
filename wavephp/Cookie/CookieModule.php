<?php
/**
 * PHP 5.0 以上
 * 
 * @package         Wavephp
 * @author          许萍
 * @copyright       Copyright (c) 2016
 * @link            https://github.com/xpmozong/wavephp2
 * @since           Version 2.0
 *
 */

/**
 * Wavephp Application CookieModule Class
 *
 * COOKIE类
 *
 * @package         Wavephp
 * @subpackage      cookie
 * @author          许萍
 *
 */

class CookieModule
{
    protected $lifeTime     = 86400;    // 生存周期
    protected $domain;

    public function __construct() 
    {
        $option = Wave::app()->config['cookie'];
        $this->lifeTime = $option['timeout'];
        $this->domain = $option['domain'];
    }

    /**
     * 设置COOKIE
     *  
     * @param string $key       关键字
     * @param string $val       值
     *
     */
    public function setState($key, $val, $expire = 0)
    {
        $val = json_encode($val);
        if (!empty($this->domain)) {
            setcookie($key, $val, time() + $this->lifeTime, '/', $this->domain);
        }else{
            setcookie($key, $val, time() + $this->lifeTime);
        }
    }

    /**
     * 得到COOKIE
     * 
     * @param string $key       关键字
     *
     * @return string
     *
     */
    public function getState($key)
    {
        $txt = '';
        if (isset($_COOKIE[$key])) {
            $txt = $_COOKIE[$key];
        }

        return json_decode($txt, true);
    }

    /**
     * 清除COOKIE
     */
    public function logout($key)
    {
        if (!empty($this->domain)) {
            setcookie($key, '', time() - $this->lifeTime, '/', $this->domain);
        }else{
            setcookie($key, $val, time() + $this->lifeTime);
        }
    }
}
?>