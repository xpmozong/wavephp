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
 * Wavephp Application Wave Class
 *
 * 框架入口
 *
 * @package         Wavephp
 * @author          许萍
 *
 */

define('Application', true);
define('START_TIME', microtime(TRUE));

if (function_exists('memory_get_usage'))
{
    define('MEMORY_USAGE_START', memory_get_usage());
}

class Wave
{
    public $Base            = null;
    public $Import          = null;
    public $config          = array();
    public static $app      = array();
    public static $_debug   = array();
    public static $Route;

    /**
     * 初始化
     */
    public function __construct($configfile = null)
    {
        global $config;
        require dirname(__FILE__).'/Base.php';
        if(empty($config) && file_exists($configfile)) {
            require $configfile;
        }
        $this->config = $config;
        $this->Base = Base::getInstance();
        $this->Base->init($this->config);
        $this->Base->requireFrameworkFile('Cache/Cache_Interface');
        $this->Base->requireFrameworkFile('Core/WaveLoader');
        spl_autoload_register(array('WaveLoader', 'loader'));
        self::$app = $this->Base->app();
    }

    /**
     * 开始
     */
    public function run()
    {
        $this->loadIniSet();
        $this->loadMemcache();
        $this->loadMemcached();
        $this->loadRedis();
        $this->loadSession();
        self::$Route = new Route();
        self::$Route->route();
        $this->Base->clear();
    }

    /**
     * ini_set
     */
    public function loadIniSet()
    {
        if (!empty(self::$app->config['ini_set'])) {
            $ini_setArr = self::$app->config['ini_set'];
            foreach ($ini_setArr as $key => $value) {
                ini_set($key, $value);
            }
        }
    }

    /**
     * memcache 连接
     */
    private function loadMemcache()
    {
        if(empty(self::$app->memcache)){
            if(!empty(self::$app->config['memcache'])){
                self::$app->memcache = new Cache_Memcache();
            }
        }
    }

    /**
     * memcached 连接
     */
    private function loadMemcached()
    {
        if(empty(self::$app->memcached)){
            if(!empty(self::$app->config['memcached'])){
                self::$app->memcached = new Cache_Memcached();
            }
        }
    }

    /**
     * redis 连接
     */
    private function loadRedis()
    {
        if(empty(self::$app->redis)){
            if(!empty(self::$app->config['redis'])){
                self::$app->redis = new Cache_Redis();
            }
        }
    }

    /**
     * SEESION
     */
    private function loadSession()
    {
        if(!empty(self::$app->config)){
            if(isset(self::$app->config['session'])){
                $driver = self::$app->config['session']['driver'];
                $class = 'Session_'.ucfirst($driver);
                $session = new $class();
                session_set_save_handler(array(&$session,"open"), 
                             array(&$session,"close"), 
                             array(&$session,"read"), 
                             array(&$session,"write"), 
                             array(&$session,"destroy"), 
                             array(&$session,"gc"));

                self::$app->session = $session;
            }
        }
    }

    /**
     * 一些公共参数，供项目调用的
     *
     * 例如在项目中输出除域名外的根目录地址 Wave::app()->homeUrl;
     *
     * @return object array
     *
     */
    public static function app()
    {
        return self::$app;
    }

    /**
     * 记录系统 Debug 事件
     *
     * 打开 debug 功能后相应事件会在页脚输出
     *
     * @param string $type
     * @param string $expend_time
     * @param string $message
     */
    public static function debug_log($type, $expend_time, $message)
    {
        self::$_debug[$type][] = array(
            'expend_time' => $expend_time,
            'log_time' => microtime(TRUE),
            'message' => $message
        );
    }

    /**
     * 获取控制器名
     */
    public static function getClassName() 
    {
        return self::$Route->getClassName();
    }

    /**
     * 获取控制器方法名
     */
    public static function getActionName() 
    {
        return self::$Route->getActionName();
    }

    /**
     * 写入缓存文件
     */
    public static function writeCache($filepath, $content, $mod = 'w') 
    {
        $fp = fopen($filepath, $mod);
        flock($fp, LOCK_EX);
        fwrite($fp, $content);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    /**
     * 读缓存文件
     */
    public static function readCache($filepath)
    {
        if (file_exists($filepath)) {
            return file_get_contents($filepath);
        }
        
        return false;
    }
}

?>