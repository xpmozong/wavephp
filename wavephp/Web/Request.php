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
 * Wavephp Application Request Class
 *
 * HTTP请求信息
 *
 * @package         Wavephp
 * @author          许萍
 *
 */
class Request
{
    const URI_DELIMITER = '/';
    const SCHEME_HTTP  = 'http';
    const SCHEME_HTTPS = 'https';
    private $_baseUrl;
    public static $instance;

    /**
     * 单例
     */
    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __set($name, $value)
    {
        throw new Exception('Setting values in superglobals not allowed');
    }

    public function __isset($key)
    {
        switch (true) {
            case isset($this->_params[$key]):
                return true;
            case isset($_GET[$key]):
                return true;
            case isset($_POST[$key]):
                return true;
            case isset($_COOKIE[$key]):
                return true;
            case isset($_SERVER[$key]):
                return true;
            case isset($_ENV[$key]):
                return true;
            default:
                return false;
        }
    }

    public function has($key)
    {
        return $this->__isset($key);
    }

    public function setParams(array $array)
    {
        $this->_params = $this->_params + (array) $array;

        foreach ($array as $key => $value) {
            if (null === $value) {
                unset($this->_params[$key]);
            }
        }

        return $this;
    }

    public function __get($key)
    {
        switch (true) {
            case isset($this->_params[$key]):
                return $this->_params[$key];
            // case isset($_GET[$key]):
            //     return $_GET[$key];
            // case isset($_POST[$key]):
            //     return $_POST[$key];
            // case isset($_COOKIE[$key]):
            //     return $_COOKIE[$key];
            case isset($_REQUEST[$key]):
                return $_REQUEST[$key];
            case ($key == 'REQUEST_URI'):
                return $this->getRequestUri();
            case ($key == 'PATH_INFO'):
                return $this->getPathInfo();
            case isset($_SERVER[$key]):
                return $_SERVER[$key];
            case isset($_ENV[$key]):
                return $_ENV[$key];
            default:
                return null;
        }
    }

    /**
     * 获得参数int型
     *
     * @param string $key
     * @return int
     *
     */
    public function getInt($key)
    {
        if (isset($_REQUEST[$key])) {
            return (int)$_REQUEST[$key];
        }else{
            return 0;
        }
    }

    /**
     * 获得参数string型
     *
     * @param string $key
     * @return string
     *
     */
    public function getString($key)
    {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }else{
            return '';
        }
    }

    /**
     * 获得参数 加魔术引用
     *
     * @param string $key
     * @return string
     *
     */
    public function getAddslashes($key)
    {
        if (isset($_REQUEST[$key])) {
            return addslashes($_REQUEST[$key]);
        }else{
            return '';
        }
    }

    /**
     *获得参数 加转义
     *
     * @param string $key
     * @return string
     *
     */
    public function getHtmlspecialchars($key)
    {
        if (isset($_REQUEST[$key])) {
            return htmlspecialchars($_REQUEST[$key]);
        }else{
            return '';
        }
    }

    /**
     * 获得请求方法
     *
     * @return string
     *
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    /**
     * 是否POST提交
     *
     * @return bool
     *
     */
    public function isPost()
    {
        if( $this->getMethod() == 'POST' ){
            return true;
        }
        return false;
    }

    /**
     * 是否GET提交
     *
     * @return bool
     *
     */
    public function isGet()
    {
        if( $this->getMethod() == 'GET' ){
            return true;
        }
        return false;
    }

    /**
     * 是否Ajax提交
     *
     * @return bool
     *
     */
    public function isAjax()
    {
        return ($this->getHeader('X_REQUESTED_WITH') == 'XMLHttpRequest');
    }

    /**
     * 获得服务器信息
     */
    public function getServer($key = null, $default = null)
    {
        if (null === $key) {
            return $_SERVER;
        }

        return (isset($_SERVER[$key])) ? $_SERVER[$key] : $default;
    }

    /**
     * 获得头信息
     */
    public function getHeader($header)
    {
        // Try to get it from the $_SERVER array first
        $temp = 'HTTP_' . strtoupper(str_replace('-', '_', $header));
        if (isset($_SERVER[$temp])) {
            return $_SERVER[$temp];
        }

        // This seems to be the only way to get the Authorization header on
        // Apache
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (isset($headers[$header])) {
                return $headers[$header];
            }
            $header = strtolower($header);
            foreach ($headers as $key => $value) {
                if (strtolower($key) == $header) {
                    return $value;
                }
            }
        }

        return false;
    }

    /**
     * 获得全局变量
     */
    public function getEnv($key = null, $default = null)
    {
        if (null === $key) {
            return $_ENV;
        }

        return (isset($_ENV[$key])) ? $_ENV[$key] : $default;
    }

    /**
     * 获得cookie值
     */
    public function getCookie($key = null, $default = null)
    {
        if (null === $key) {
            return $_COOKIE;
        }

        return (isset($_COOKIE[$key])) ? $_COOKIE[$key] : $default;
    }

    /**
     * 获得请求URI
     *
     * @return string
     *
     */
    public function getRequestUri()
    {
         $current_uri = '';
         if( PHP_SAPI === 'cli' ){
            // Command line requires a bit of hacking
            if( isset($_SERVER['argv'][1]) ){
                $current_uri = $_SERVER['argv'][1];
                // Remove GET string from segments
                if( ($query = strpos($current_uri, '?')) !== FALSE ){
                    list($current_uri, $query) = explode('?', $current_uri, 2);
//                    // Parse the query string into $_GET
                    parse_str($query, $_GET);
                }
            }
        }elseif ( isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] ) {
            //self::$current_uri = $_SERVER['PATH_INFO'];
            $current_uri = $_SERVER['REQUEST_URI'];
        } elseif ( isset($_SERVER['ORIG_PATH_INFO']) && $_SERVER['ORIG_PATH_INFO'] ) {
            $current_uri = $_SERVER['ORIG_PATH_INFO'];
        } elseif ( isset($_SERVER['PHP_SELF']) && $_SERVER['PHP_SELF'] ) {
            $current_uri = $_SERVER['PHP_SELF'];
        }
        $current_uri = preg_replace('#\.[\s./]*/#', '', $current_uri);
        return $current_uri;
    }

    /**
     * 获取客户端IP
     *
     * @return string
     * 
     */
    public static function getClientIp()
    {
         if( isset($_SERVER) ){
            if (isset($_SERVER['HTTP_CDN_SRC_IP'])) {
                $realip = $_SERVER["HTTP_CDN_SRC_IP"];
            } else if( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif ( isset($_SERVER["HTTP_CLIENT_IP"]) ) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif ( isset($_SERVER["REMOTE_ADDR"]) ) {
                $realip = $_SERVER["REMOTE_ADDR"];
            } else {
                $realip = $_SERVER["SSH_CLIENT"];
            }
        } else {
            if( getenv("HTTP_X_FORWARDED_FOR") ){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } elseif ( getenv("HTTP_CLIENT_IP") ) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }

        return addslashes($realip);
    }

    /**
     * 获得请求类型
     *
     * @return http or https
     *
     */
    public function getScheme()
    {
        return ($this->getServer('HTTPS') == 'on') ? 
                self::SCHEME_HTTPS : self::SCHEME_HTTP;
    }

    /**
     * 获取当前URL链接
     *
     * @param string $raw 是否转义
     * @return string
     *
     */
    public function getCurrentUrl($raw = true)
    {
        $current_url = sprintf('http%s://%s%s',
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == TRUE ? 's' : ''),
                $_SERVER['HTTP_HOST'],
            (isset($_SERVER['REQUEST_URI']) ? 
                $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']));
        return $raw ? rawurlencode($current_url) : $current_url;
    }

}
