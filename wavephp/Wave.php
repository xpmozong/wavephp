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
class Wave
{
    public $Core        = null;
    public $Import      = null;
    public $config      = null;
    public static $app  = null;

    /**
     * 初始化
     */
    public function __construct($configfile = null)
    {  
        require dirname(__FILE__).'/Core.php';
        if(file_exists($configfile)) {
            require $configfile;
            $this->config = $config;
        }
        $this->Core = new Core($this->config);
        self::$app = $this->Core->app();
    }

    /**
     * 开始
     */
    public function run()
    {
        $this->Core->requireFrameworkFile('Route');
        $this->Core->requireFrameworkFile('Controller');
        $this->Core->requireFrameworkFile('Model');
        $this->Core->requireFrameworkFile('WaveBase');
        $this->Core->requireFrameworkFile('Web/Session.class');

        $this->loadSession();

        $Route = new Route(self::$app, $this->Core);
        spl_autoload_register(array('WaveBase', 'loader'));
        $Route->route();

        //关闭数据库连接
        // if(!empty(self::$app->database)) {
        //     foreach (self::$app->database as $key => $value) {
        //         self::$app->database->$key->close();
        //     }
        // }
        
        $this->Core->clear();
    }

    /**
     * SEESION
     */
    private function loadSession()
    {
        $lifeTime   = 3600;
        $prefix     = '';
        if(!empty(self::$app->config)){
            if(isset(self::$app->config['session'])){
                if(!empty(self::$app->config['session']['timeout']))
                    $lifeTime = self::$app->config['session']['timeout'];
                if(!empty(self::$app->config['session']['prefix']))
                    $prefix = self::$app->config['session']['prefix'];
            }
        }

        $session = new Session($prefix, $lifeTime);
        session_set_save_handler(array(&$session,"open"), 
                     array(&$session,"close"), 
                     array(&$session,"read"), 
                     array(&$session,"write"), 
                     array(&$session,"destroy"), 
                     array(&$session,"gc"));

        self::$app->session = $session;
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
    
}

?>