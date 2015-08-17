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
    
    private function __construct(){

    }

    public static function getInstance(){
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
            case isset($_GET[$key]):
                return $_GET[$key];
            case isset($_POST[$key]):
                return $_POST[$key];
            case isset($_COOKIE[$key]):
                return $_COOKIE[$key];
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

    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    public function isPost()
    {
        if( $this->getMethod() == 'POST' ){
            return true;
        }
        return false;
    }

    public function isGet()
    {
        if( $this->getMethod() == 'GET' ){
            return true;
        }
        return false;
    }

    public function isAjax()
    {
        return ($this->getHeader('X_REQUESTED_WITH') == 'XMLHttpRequest');
    }

    function getHostName(){

    }

    public function getServer($key = null, $default = null)
    {
        if (null === $key) {
            return $_SERVER;
        }

        return (isset($_SERVER[$key])) ? $_SERVER[$key] : $default;
    }

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

    public function getEnv($key = null, $default = null)
    {
        if (null === $key) {
            return $_ENV;
        }

        return (isset($_ENV[$key])) ? $_ENV[$key] : $default;
    }

    public function getCookie($key = null, $default = null)
    {
        if (null === $key) {
            return $_COOKIE;
        }

        return (isset($_COOKIE[$key])) ? $_COOKIE[$key] : $default;
    }

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

    // 获取客户端IP
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

    // CURL获取内容
    public static function curl_get_contents($url = '', $method = "GET", $data = array()) {
        $query  = array();
        $curl   = curl_init();
        foreach($data as $k=>$v){
            $query[] = $k.'='.urlencode($v);
        }
        if(strtoupper($method) == 'GET' && $data){
            $url .= '?'.implode('&', $query);
        }elseif(strtoupper($method) == 'POST' && $data){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, implode('&', $query));
        }
//        curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_ALL);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    // 获取主域名
    public function getDomain()
    {
        $host = $this->getServer('HTTP_HOST');
        $topDomain = 'local|com\.cn|com|edu|gov|int|mil|net|org|biz|';
        $topDomain .= 'info|pro|name|museum|coop|aero|xxx|idv|mobi|cc|me';
        $matchstr = "[^\.]+\.(?:(" . $topDomain . ")|\w{2}|((" . $topDomain . ")\.\w{2}))$";
        if(preg_match("/". $matchstr . "/ies", $host, $matchs)){
            $domain = $matchs['0'];
        }else{
            $domain = $host;
        }
        return $domain;
    }

    public function getScheme()
    {
        return ($this->getServer('HTTPS') == 'on') ? 
                self::SCHEME_HTTPS : self::SCHEME_HTTP;
    }

    // 获取域名
    public function getHttpHost()
    {
        $host = $this->getServer('HTTP_HOST');
        if (!empty($host)) {
            return $host;
        }

        $scheme = $this->getScheme();
        $name   = $this->getServer('SERVER_NAME');
        $port   = $this->getServer('SERVER_PORT');

        if(null === $name) {
            return '';
        } elseif (($scheme == self::SCHEME_HTTP && $port == 80) || 
            ($scheme == self::SCHEME_HTTPS && $port == 443)) {
            return $name;
        } else {
            return $name . ':' . $port;
        }
    }

    public function setBaseUrl($baseUrl = null)
    {
        if ((null !== $baseUrl) && !is_string($baseUrl)) {
            return $this;
        }

        if ($baseUrl === null) {
            $filename = (isset($_SERVER['SCRIPT_FILENAME'])) ? 
                        basename($_SERVER['SCRIPT_FILENAME']) : '';
            if (isset($_SERVER['SCRIPT_NAME']) && 
                basename($_SERVER['SCRIPT_NAME']) === $filename) {
                $baseUrl = $_SERVER['SCRIPT_NAME'];
            } elseif (isset($_SERVER['PHP_SELF']) && 
                basename($_SERVER['PHP_SELF']) === $filename) {
                $baseUrl = $_SERVER['PHP_SELF'];
            } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) 
                && basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
                // 1and1 shared hosting compatibility
                $baseUrl = $_SERVER['ORIG_SCRIPT_NAME'];
            } else {
                // Backtrack up the script_filename to find the portion matching
                // php_self
                $path    = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
                $file    = isset($_SERVER['SCRIPT_FILENAME']) ? 
                            $_SERVER['SCRIPT_FILENAME'] : '';
                $segs    = explode('/', trim($file, '/'));
                $segs    = array_reverse($segs);
                $index   = 0;
                $last    = count($segs);
                $baseUrl = '';
                do {
                    $seg     = $segs[$index];
                    $baseUrl = '/' . $seg . $baseUrl;
                    ++$index;
                } while (($last > $index) 
                    && (false !== ($pos = strpos($path, $baseUrl))) 
                    && (0 != $pos));
            }

            // Does the baseUrl have anything in common with the request_uri?
            $requestUri = $this->getRequestUri();

            if (0 === strpos($requestUri, $baseUrl)) {
                // full $baseUrl matches
                $this->_baseUrl = $baseUrl;
                return $this;
            }

            if (0 === strpos($requestUri, dirname($baseUrl))) {
                // directory portion of $baseUrl matches
                $this->_baseUrl = rtrim(dirname($baseUrl), '/');
                return $this;
            }

            $truncatedRequestUri = $requestUri;
            if (($pos = strpos($requestUri, '?')) !== false) {
                $truncatedRequestUri = substr($requestUri, 0, $pos);
            }

            $basename = basename($baseUrl);
            if (empty($basename) || !strpos($truncatedRequestUri, $basename)) {
                // no match whatsoever; set it blank
                $this->_baseUrl = '';
                return $this;
            }

            // If using mod_rewrite or ISAPI_Rewrite strip the script filename
            // out of baseUrl. $pos !== 0 makes sure it is not matching a value
            // from PATH_INFO or QUERY_STRING
            if ((strlen($requestUri) >= strlen($baseUrl))
                && ((false !== ($pos = strpos($requestUri, $baseUrl))) && ($pos !== 0)))
            {
                $baseUrl = substr($requestUri, 0, $pos + strlen($baseUrl));
            }
        }

        $this->_baseUrl = rtrim($baseUrl, '/');
        return $this;
    }

    // 获取URL根路径
    public function getBaseUrl($raw = false)
    {
        if (null === $this->_baseUrl) {
            $module = Application::getInstance()->getModuleName();
            $baseUrl = $this->getScheme().'://'.$this->getHttpHost().Request::URI_DELIMITER;
            if($module != 'default'){
                 $baseUrl .= $module . Request::URI_DELIMITER;
            }
            $this->setBaseUrl($baseUrl);
        }

        return $raw ? rawurlencode($this->_baseUrl) : $this->_baseUrl;
    }

    // 获取当前URL链接
    public function getCurrentUrl($raw = true)
    {
        $current_url = sprintf('http%s://%s%s',
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == TRUE ? 's' : ''),
                $_SERVER['HTTP_HOST'],
            (isset($_SERVER['REQUEST_URI']) ? 
                $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']));
        return $raw ? rawurlencode($current_url) : $current_url;
    }

    public function getReferer($filter = true, $default = '/')
    {
        if ($filter && !empty($_GET['referer'])) {
            $info = parse_url($_GET['referer']);
            if (!isset($info['host'])) {
                return $_GET['referer'];
            } else if (preg_match('/(.)*'.$this->getDomain().'$/is', $info['host'])) {
                return $_GET['referer'];
            } else {
                return $default;
            }
        }
        return !empty($_GET['referer']) ? rawurldecode($_GET['referer']) : $default;
    }

    /**
     * 比较2个数字是否相等
     * @param unknown_type $str
     * @param unknown_type $str2  要比较的数字
     * @return number
     */
    public function getIsEqual($str,$str2){
        $str  = isset($str)  ? trim($str) : 0;
        $str2 = isset($str2) ? $str2 : 0;

        if($str == $str2){
            return 100;
        }
        return 0;
    }

}
